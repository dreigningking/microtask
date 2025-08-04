<?php

namespace App\Http\Controllers\Logistics;

use App\Models\Shipper;
use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shipper = auth()->user()->logistics->shipper;
        
        $search = $request->query('search', null);
        $status = $request->query('status', 'all');

        // Base query for stats (unfiltered)
        $baseQuery = Support::where('supportable_type', get_class($shipper))
            ->where('supportable_id', $shipper->id)
            ->with('trails');
        $allTickets = $baseQuery->get();
        
        // Calculate stats from all tickets
        $total = $allTickets->count();
        $open = $allTickets->where('status', 'open')->count();
        $closed = $allTickets->where('status', 'closed')->count();
        
        // Pending: tickets without trail (trail is empty)
        $pending = $allTickets->filter(function ($ticket) {
            return $ticket->trails->isEmpty();
        })->count();
        
        $stats = [
            'total' => $total,
            'open' => $open,
            'closed' => $closed,
            'pending' => $pending,
        ];

        // Filtered query for display
        $ticketsQuery = Support::where('supportable_type', get_class($shipper))
            ->where('supportable_id', $shipper->id)
            ->with('trails');
        
        // Apply search filter
        if ($search) {
            $ticketsQuery = $ticketsQuery->where(function($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")
                      ->orWhere('subject', 'LIKE', "%$search%")
                      ->orWhere('description', 'LIKE', "%$search%");
            });
        }
        
        // Apply status filter
        if ($status && $status !== 'all') {
            $ticketsQuery = $ticketsQuery->where('status', $status);
        }
        
        $tickets = $ticketsQuery->latest()->paginate(16);

        return view('logistics.support.index', compact('tickets', 'stats', 'search', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shipper = auth()->user()->logistics->shipper; 
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,normal,high',
            'attachments.*' => 'nullable|image|max:2048',
        ]);

        $support = Support::create([
            'supportable_id' => $shipper->id,
            'supportable_type' => get_class($shipper),
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('support_attachments', 'public');
            }
        }

        $support->comments()->create([
            'profile_id'=> $shipper->id,
            'profile_type'=> get_class($shipper),
            'user_id' => auth()->id(),
            'body' => $request->description,
            'attachments' => $attachments ? $attachments : null,
        ]);

        return redirect()->route('logistics.support.ticket', $support)->with('success', 'Support ticket created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function ticket(Support $support)
    {
        return view('logistics.support.view',compact('support'));
    }

    /**
     * Add a comment/message to a support ticket.
     */
    public function addComment(Request $request)
    {
        $support = Support::findOrFail($request->support_id);
        $request->validate([
            'body' => 'required|string',
            'attachments.*' => 'nullable|image|max:2048',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('support_attachments', 'public');
            }
        }
        $support->comments()->create([
            'profile_id'=> $support->supportable_id,
            'profile_type'=> $support->supportable_type,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'attachments' => $attachments ? $attachments : null,
        ]);

        $support->status = 'open';
        $support->save();
        return redirect()->route('logistics.support.ticket', $support)->with('success', 'Message sent successfully!');
    }

    /**
     * Close the specified support ticket.
     */
    public function close(Request $request)
    {
        $support = Support::findOrFail($request->support_id);
        $support->status = 'closed';
        $support->save();
        return redirect()->route('logistics.support.ticket', $support)->with('success', 'Support ticket closed successfully!');
    }
}
