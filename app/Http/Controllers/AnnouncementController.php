<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use App\Services\AnnouncementTargetingService;
use App\Notifications\General\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    protected $targetingService;

    public function __construct(AnnouncementTargetingService $targetingService)
    {
        $this->middleware(['auth', 'admin']); // Only admin users can manage announcements
        $this->targetingService = $targetingService;
    }

    /**
     * Display the announcement management dashboard
     */
    public function index(Request $request)
    {
        $query = Announcement::with(['sender', 'recipients'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $announcements = $query->paginate(15);

        // Get statistics
        $stats = $this->getAnnouncementStats();

        return view('backend.announcements.index', compact('announcements', 'stats'));
    }

    /**
     * Show the announcement creation form
     */
    public function create()
    {
        $segments = $this->targetingService->getSegmentsWithCounts();
        $availableSegments = User::getAvailableSegments();
        
        return view('backend.announcements.create', compact('segments', 'availableSegments'));
    }

    /**
     * Store a new announcement
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'via' => 'required|in:email,database,both',
            'target_segment' => 'required|string',
            'target_criteria' => 'nullable|array',
            'priority' => 'required|in:low,normal,high,urgent',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:scheduled_at',
            'metadata' => 'nullable|array'
        ]);

        // Validate target segment
        if (!$this->targetingService->validateSegment($request->target_segment)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid target segment selected.');
        }

        DB::beginTransaction();
        try {
            // Create announcement
            $announcement = Announcement::create([
                'subject' => $request->subject,
                'message' => $request->message,
                'via' => $request->via,
                'target_segment' => $request->target_segment,
                'target_criteria' => $request->target_criteria,
                'priority' => $request->priority,
                'scheduled_at' => $request->scheduled_at,
                'expires_at' => $request->expires_at,
                'metadata' => $request->metadata,
                'sent_by' => Auth::id(),
                'status' => $request->scheduled_at ? 'scheduled' : 'pending'
            ]);

            if ($request->scheduled_at) {
                // Schedule for later
                DB::commit();
                return redirect()->route('admin.announcements.index')
                    ->with('success', 'Announcement scheduled successfully for ' . Carbon::parse($request->scheduled_at)->format('M d, Y \a\t h:i A'));
            } else {
                // Send immediately
                $result = $this->targetingService->sendToTargets(
                    $announcement,
                    $request->target_segment,
                    $request->target_criteria ?? []
                );

                DB::commit();

                if ($result['success']) {
                    return redirect()->route('admin.announcements.show', $announcement->id)
                        ->with('success', $result['message']);
                } else {
                    return redirect()->back()
                        ->with('error', $result['message']);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create announcement: ' . $e->getMessage());
        }
    }

    /**
     * Show detailed view of an announcement
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['sender', 'recipients.user']);
        
        // Get delivery statistics
        $stats = $this->targetingService->getDeliveryStats($announcement);
        
        // Get recipient breakdown by status
        $recipientStats = [
            'pending' => $announcement->recipients()->where('status', 'pending')->count(),
            'sent' => $announcement->recipients()->where('status', 'sent')->count(),
            'delivered' => $announcement->recipients()->where('status', 'delivered')->count(),
            'read' => $announcement->recipients()->where('status', 'read')->count(),
            'clicked' => $announcement->recipients()->where('clicked_link', true)->count(),
            'failed' => $announcement->recipients()->where('status', 'failed')->count(),
        ];

        return view('backend.announcements.show', compact('announcement', 'stats', 'recipientStats'));
    }

    /**
     * Show the announcement edit form
     */
    public function edit(Announcement $announcement)
    {
        if ($announcement->status === 'sent') {
            return redirect()->back()->with('error', 'Cannot edit already sent announcements.');
        }

        $segments = $this->targetingService->getSegmentsWithCounts();
        $availableSegments = User::getAvailableSegments();
        
        return view('backend.announcements.edit', compact('announcement', 'segments', 'availableSegments'));
    }

    /**
     * Update an announcement
     */
    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->status === 'sent') {
            return redirect()->back()->with('error', 'Cannot update already sent announcements.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'via' => 'required|in:email,database,both',
            'target_segment' => 'required|string',
            'target_criteria' => 'nullable|array',
            'priority' => 'required|in:low,normal,high,urgent',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:scheduled_at',
            'metadata' => 'nullable|array'
        ]);

        $announcement->update($request->all());

        return redirect()->route('admin.announcements.show', $announcement->id)
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Send a scheduled announcement immediately
     */
    public function sendNow(Announcement $announcement)
    {
        if ($announcement->status !== 'scheduled') {
            return redirect()->back()->with('error', 'Only scheduled announcements can be sent immediately.');
        }

        $result = $this->targetingService->sendToTargets(
            $announcement,
            $announcement->target_segment,
            $announcement->target_criteria ?? []
        );

        if ($result['success']) {
            $announcement->markAsSent();
            return redirect()->route('admin.announcements.show', $announcement->id)
                ->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Archive an announcement
     */
    public function archive(Announcement $announcement)
    {
        $announcement->update(['is_archived' => true]);
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement archived successfully.');
    }

    /**
     * Unarchive an announcement
     */
    public function unarchive(Announcement $announcement)
    {
        $announcement->update(['is_archived' => false]);
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement unarchived successfully.');
    }

    /**
     * Delete an announcement
     */
    public function destroy(Announcement $announcement)
    {
        // Only allow deletion of archived announcements or failed ones
        if (!$announcement->is_archived && $announcement->status !== 'failed') {
            return redirect()->back()->with('error', 'Only archived or failed announcements can be deleted.');
        }

        $announcement->delete();
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Get recipients for an announcement (AJAX)
     */
    public function getRecipients(Announcement $announcement, Request $request)
    {
        $query = $announcement->recipients()->with('user');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by user name or email
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $recipients = $query->paginate(20);

        return response()->json([
            'recipients' => $recipients->items(),
            'pagination' => [
                'current_page' => $recipients->currentPage(),
                'last_page' => $recipients->lastPage(),
                'per_page' => $recipients->perPage(),
                'total' => $recipients->total()
            ]
        ]);
    }

    /**
     * Get segment user count (AJAX)
     */
    public function getSegmentCount(Request $request)
    {
        $request->validate([
            'segment' => 'required|string',
            'criteria' => 'nullable|array'
        ]);

        $count = $this->targetingService->getTargetUserCount(
            $request->segment,
            $request->criteria ?? []
        );

        return response()->json(['count' => $count]);
    }

    /**
     * Preview announcement to specific users
     */
    public function preview(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'target_segment' => 'required|string',
            'target_criteria' => 'nullable|array'
        ]);

        $users = $this->targetingService->getTargetUsers(
            $request->target_segment,
            $request->criteria ?? []
        )->take(10); // Preview first 10 users

        return view('backend.announcements.preview', compact('users'))
            ->with('announcement_data', $request->only(['subject', 'message', 'target_segment', 'target_criteria']));
    }

    /**
     * Export announcement data
     */
    public function export(Announcement $announcement, $format = 'csv')
    {
        $recipients = $announcement->recipients()->with('user')->get();

        $filename = 'announcement_' . $announcement->id . '_recipients.' . $format;
        $path = 'exports/' . $filename;

        // Create CSV content
        $csvContent = "User Name,Email,Status,Email Sent,Email Delivered,First Viewed,Clicked,Completed\n";
        
        foreach ($recipients as $recipient) {
            $csvContent .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $recipient->user->name,
                $recipient->user->email,
                $recipient->status,
                $recipient->email_sent_at ? $recipient->email_sent_at->format('Y-m-d H:i:s') : 'N/A',
                $recipient->email_delivered_at ? $recipient->email_delivered_at->format('Y-m-d H:i:s') : 'N/A',
                $recipient->first_viewed_at ? $recipient->first_viewed_at->format('Y-m-d H:i:s') : 'N/A',
                $recipient->clicked_link ? 'Yes' : 'No',
                $recipient->completed_at ? $recipient->completed_at->format('Y-m-d H:i:s') : 'N/A'
            );
        }

        Storage::put($path, $csvContent);

        return Storage::download($path);
    }

    /**
     * Get announcement statistics
     */
    private function getAnnouncementStats(): array
    {
        return [
            'total' => Announcement::count(),
            'sent' => Announcement::successful()->count(),
            'scheduled' => Announcement::scheduled()->count(),
            'failed' => Announcement::failed()->count(),
            'active' => Announcement::active()->count(),
            'archived' => Announcement::where('is_archived', true)->count(),
            'this_month' => Announcement::whereMonth('created_at', now()->month)->count(),
            'total_recipients' => AnnouncementRecipient::count(),
            'average_delivery_rate' => $this->calculateAverageDeliveryRate()
        ];
    }

    /**
     * Calculate average delivery rate across all announcements
     */
    private function calculateAverageDeliveryRate(): float
    {
        $announcements = Announcement::where('emails_sent', '>', 0)->get();
        
        if ($announcements->isEmpty()) {
            return 0.0;
        }

        $totalDeliveryRate = $announcements->sum(function ($announcement) {
            return $announcement->delivery_rate;
        });

        return round($totalDeliveryRate / $announcements->count(), 2);
    }

    /**
     * Get dashboard data for widgets
     */
    public function dashboard()
    {
        $recentAnnouncements = Announcement::with('sender')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $upcomingScheduled = Announcement::scheduled()
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $topPerforming = Announcement::with('recipients')
            ->get()
            ->sortByDesc('open_rate')
            ->take(5);

        return response()->json([
            'recent_announcements' => $recentAnnouncements,
            'upcoming_scheduled' => $upcomingScheduled,
            'top_performing' => $topPerforming
        ]);
    }
}
