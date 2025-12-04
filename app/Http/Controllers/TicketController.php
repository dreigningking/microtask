<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trail;
use App\Models\Support;
use App\Models\Permission;
use App\Models\TaskDispute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', null);
        $period = $request->query('period', 'month');
        $sortBy = $request->query('sortBy', null);

        // Base query for stats (unfiltered)
        $baseQuery = Support::with(['trails']);
        $allTickets = $baseQuery->get();

        // Filtered query for display
        $ticketsQuery = Support::with(['trails', 'user.country', 'user.state', 'user.city']);
        
        // Apply search filter
        if ($search) {
            $ticketsQuery = $ticketsQuery->where(function($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")
                      ->orWhere('description', 'LIKE', "%$search%");
            });
        }
        
        // Apply status filter
        if ($status && $status !== 'all') {
            $ticketsQuery = $ticketsQuery->where('status', $status);
        }
        
        // Apply period filter
        if ($period) {
            $now = now();
            switch ($period) {
                case 'today':
                    $ticketsQuery = $ticketsQuery->whereDate('created_at', $now->toDateString());
                    break;
                case 'week':
                    $ticketsQuery = $ticketsQuery->whereBetween('created_at', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'month':
                    $ticketsQuery = $ticketsQuery->whereMonth('created_at', $now->month)
                                                 ->whereYear('created_at', $now->year);
                    break;
                case 'year':
                    $ticketsQuery = $ticketsQuery->whereYear('created_at', $now->year);
                    break;
            }
        }
        
        // Apply sorting
        if ($sortBy) {
            switch ($sortBy) {
                case 'name_asc':
                    $ticketsQuery = $ticketsQuery->orderBy('id', 'asc');
                    break;
                case 'name_desc':
                    $ticketsQuery = $ticketsQuery->orderBy('id', 'desc');
                    break;
                default:
                    $ticketsQuery = $ticketsQuery->latest();
            }
        } else {
            $ticketsQuery = $ticketsQuery->latest();
        }
        
        $tickets = $ticketsQuery->get();
        
        return view('backend.support.tickets.list', compact('tickets', 'status', 'search', 'period', 'sortBy'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Support $support)
    {
        // dd($support);
        $support->load(['user.country', 'user.state', 'user.city', 'trails.user']);
        return view('backend.support.tickets.view',compact('support'));
    }


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
            'profile_id'=> Auth::id(),
            'profile_type'=> get_class(Auth::user()),
            'user_id' => Auth::id(),
            'body' => $request->body,
            'attachments' => $attachments ? $attachments : null,
        ]);
        Trail::updateOrCreate(['user_id'=> Auth::id(),
        'trailable_id'=> $support->id,
        'trailable_type'=> 'App\Models\Support']);
        return redirect()->route('admin.support.tickets.show', $support)->with('success', 'Message sent successfully!');
    }


    public function ping(Request $request)
    {
        Trail::updateOrCreate(['user_id'=> $request->user_id,
        'trailable_id'=> $request->support_id,
        'trailable_type'=> 'App\Models\Support'],[
        'assigned_by'=> Auth::id(),
        'message'=> $request->message]);
        if($request->priority){
            Support::where('id',$request->support_id)->update(['priority'=> $request->priority]);
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function disputes()
    {
        $disputes = TaskDispute::orderBy('resolved_at','asc')->get();
        return view('backend.support.disputes.list',compact('disputes'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
