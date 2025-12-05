<?php

namespace App\Http\Controllers;

use App\Models\Moderation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        return view('backend.dashboard');
    }

    public function moderations(Request $request){
        $query = Moderation::with(['moderatable', 'moderator']);

        // Filters
        $query->where('status', $request->input('status', 'pending'));

        if ($request->filled('moderation_type')) {
            $query->where('moderatable_type', $request->moderation_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if (auth()->user()->role->name === 'super-admin' && $request->filled('country_id')) {
            // For polymorphic, filter based on moderatable's country if applicable
            // For now, skip complex joins, assume country_id is on moderatable
        }

        $moderations = $query->orderBy('created_at', 'desc')->paginate(25);

        $moderatables = [
            'App\Models\Task' => 'Task',
            'App\Models\UserVerification' => 'User Verification',
            'App\Models\Withdrawal' => 'Withdrawal',
            'App\Models\Post' => 'Post',
            'App\Models\Comment' => 'Comment',
        ];

        $countries = auth()->user()->role->name === 'super-admin' ? \App\Models\Country::all() : collect();

        return view('backend.moderations', compact('moderations', 'moderatables', 'countries'));
    }
}
