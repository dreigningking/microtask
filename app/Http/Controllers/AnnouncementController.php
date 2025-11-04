<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use App\Notifications\General\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Show the announcement form and history
     */
    public function index()
    {
        $announcements = Announcement::with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('backend.announcements', compact('announcements'));
    }

    /**
     * Send announcement to all users
     */
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Get all active users
            $users = User::where('is_active', true)->get();
            
            // Create announcement record
            $announcement = Announcement::create([
                'subject' => $request->subject,
                'message' => $request->message,
                'sent_by' => Auth::id(),
                'recipients_count' => $users->count(),
                'status' => 'sent',
            ]);
            
            // Send notification to all users
            Notification::send($users, new AnnouncementNotification(
                $request->subject,
                $request->message
            ));

            return redirect()->back()->with('success', 'Announcement sent successfully to ' . $users->count() . ' users!');
        } catch (\Exception $e) {
            // If notification fails, update status
            if (isset($announcement)) {
                $announcement->update(['status' => 'failed']);
            }
            
            return redirect()->back()->with('error', 'Failed to send announcement: ' . $e->getMessage());
        }
    }
}
