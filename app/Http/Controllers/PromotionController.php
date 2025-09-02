<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Platform;
use App\Models\TaskPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = TaskPromotion::with(['task', 'user.country', 'user'])
            ->localize();

        // Search by task title/description
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Handle case where search might be an array
            if (is_array($search)) {
                $search = $search[0] ?? null;
            }
            
            if ($search) {
                $query->searchTask($search);
            }
        }

        // Filter by promotion type
        if ($request->filled('type')) {
            $type = $request->type;
            
            // Handle case where type might be an array
            if (is_array($type)) {
                $type = $type[0] ?? null;
            }
            
            if ($type) {
                $query->byType($type);
            }
        }

        // Filter by status (running/finished)
        if ($request->filled('status')) {
            $status = $request->status;
            
            // Handle case where status might be an array
            if (is_array($status)) {
                $status = $status[0] ?? null;
            }
            
            if ($status === 'running') {
                $query->running();
            } elseif ($status === 'finished') {
                $query->finished();
            }
        }

        // Filter by country (super admin only)
        if ($request->filled('country_id') && Auth::check() && Auth::user()->first_role && Auth::user()->first_role->name === 'super-admin') {
            $countryId = $request->country_id;
            
            // Handle case where country_id might be an array
            if (is_array($countryId)) {
                $countryId = $countryId[0] ?? null;
            }
            
            if ($countryId) {
                $query->byCountry($countryId);
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Filter by cost range
        if ($request->filled('cost_min')) {
            $query->where('cost', '>=', $request->cost_min);
        }
        if ($request->filled('cost_max')) {
            $query->where('cost', '<=', $request->cost_max);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $promotions = $query->paginate(25);

        // Get data for filters
        $countries = Country::orderBy('name')->get();
        $promotionTypes = TaskPromotion::distinct()->pluck('type')->filter()->values();
        $monitoringTypes = [
            'self_monitoring' => 'Self Monitoring',
            'admin_monitoring' => 'Admin Monitoring',
            'system_monitoring' => 'System Monitoring'
        ];

        return view('backend.tasks.promotions', compact(
            'promotions',
            'countries',
            'promotionTypes',
            'monitoringTypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
