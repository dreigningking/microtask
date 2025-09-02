<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CountrySetting;
use App\Models\Payment;
use App\Models\Exchange;
use App\Models\Settlement;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PayoutTrait;

class EarningController extends Controller
{
    use PayoutTrait;

    /**
     * Display a listing of the resource.
     */
    public function earnings(Request $request)
    {
        $query = Settlement::localize()->with(['user', 'settlementable']);

        // Apply filters
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('settlement_type')) {
            if ($request->settlement_type === 'task') {
                $query->where('settlementable_type', 'App\\Models\\Task');
            } elseif ($request->settlement_type === 'referral') {
                $query->where('settlementable_type', 'App\\Models\\Referral');
            }
        }

        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        // Country filter for super-admin users
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        // Get unique currencies for filter dropdown
        $currencies = Settlement::distinct()->pluck('currency')->filter()->sort()->values();
        
        // Get countries for super-admin filter
        $countries = null;
        if (Auth::user()->first_role->name === 'super-admin') {
            $countries = Country::orderBy('name')->get();
        }
        $settlements = $query->orderBy('id', 'desc')->paginate(20);

        return view('backend.finance.settlements', compact('settlements', 'currencies', 'countries'));
    }

    public function payments(Request $request){
        $query = Payment::localize()->with(['user', 'order.items.orderable']);

        // Apply filters
        if ($request->filled('reference')) {
            $query->where('reference', 'like', '%' . $request->reference . '%');
        }

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gateway')) {
            $query->where('gateway', 'like', '%' . $request->gateway . '%');
        }

        // Country filter for super-admin users
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        // Get unique currencies for filter dropdown
        $currencies = Payment::distinct()->pluck('currency')->filter()->sort()->values();
        
        // Get unique statuses for filter dropdown
        $statuses = Payment::distinct()->pluck('status')->filter()->sort()->values();
        
        // Get unique gateways for filter dropdown
        $gateways = Payment::distinct()->pluck('gateway')->filter()->sort()->values();
        
        // Get countries for super-admin filter
        $countries = null;
        if (Auth::user()->first_role->name === 'super-admin') {
            $countries = Country::orderBy('name')->get();
        }

        $payments = $query->orderBy('id', 'desc')->paginate(20);
        return view('backend.finance.payments', compact('payments', 'currencies', 'statuses', 'gateways', 'countries'));
    }

    public function exchanges(Request $request){
        $query = Exchange::localize()->with(['user', 'base_wallet', 'target_wallet']);

        // Apply filters
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('base_currency')) {
            $query->whereHas('base_wallet', function ($q) use ($request) {
                $q->where('currency', $request->base_currency);
            });
        }

        if ($request->filled('target_currency')) {
            $query->whereHas('target_wallet', function ($q) use ($request) {
                $q->where('currency', $request->target_currency);
            });
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Country filter for super-admin users
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        // Get unique base currencies for filter dropdown
        $baseCurrencies = Exchange::join('wallets as base', 'exchanges.base_wallet_id', '=', 'base.id')
            ->distinct()
            ->pluck('base.currency')
            ->filter()
            ->sort()
            ->values();
        
        // Get unique target currencies for filter dropdown
        $targetCurrencies = Exchange::join('wallets as target', 'exchanges.target_wallet_id', '=', 'target.id')
            ->distinct()
            ->pluck('target.currency')
            ->filter()
            ->sort()
            ->values();
        
        // Get unique statuses for filter dropdown
        $statuses = Exchange::distinct()->pluck('status')->filter()->sort()->values();
        
        // Get countries for super-admin filter
        $countries = null;
        if (Auth::user()->first_role->name === 'super-admin') {
            $countries = Country::orderBy('name')->get();
        }

        $exchanges = $query->orderBy('id', 'desc')->paginate(20);
        return view('backend.finance.exchanges', compact('exchanges', 'baseCurrencies', 'targetCurrencies', 'statuses', 'countries'));
    }

    public function withdrawals(Request $request)
    {
        $query = Withdrawal::localize()->with(['approver']);
        
        // Apply filters
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // if ($request->filled('payout_method')) {
        //     $query->whereHas('user.country.setting', function ($q) use ($request) {
        //         $q->where('payout_method', $request->payout_method);
        //     });
        // }

        // Country filter for super-admin users
        if (Auth::user()->first_role->name === 'super-admin' && $request->filled('country_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        // Get unique currencies for filter dropdown
        $currencies = Withdrawal::distinct()->pluck('currency')->filter()->sort()->values();
        
        // Get unique statuses for filter dropdown
        $statuses = Withdrawal::distinct()->pluck('status')->filter()->sort()->values();
        
        // Get unique payout methods for filter dropdown
        $payoutMethods = CountrySetting::whereNotNull('gateway')->distinct('gateway')->get()->pluck('gateway');
        
        // Get countries for super-admin filter
        $countries = null;
        if (Auth::user()->first_role->name === 'super-admin') {
            $countries = Country::orderBy('name')->get();
        }

        $withdrawals = $query->orderBy('id', 'desc')->paginate(20);
        
        return view('backend.finance.withdrawals', compact('withdrawals', 'currencies', 'statuses', 'payoutMethods', 'countries'));
    }


    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::with(['user.country.setting', 'user.bankAccount'])->findOrFail($id);
        
        // Check if user has a bank account
        if (!$withdrawal->user->bankAccount) {
            return redirect()->back()->with('error', 'User does not have a bank account configured.');
        }
        
        // Initialize the payout process
        $this->initializePayout($withdrawal);
        
        return redirect()->back()->with('success', 'Withdrawal approved and payout initiated successfully.');
    }

    public function disapproveWithdrawal(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->status = 'rejected';
        $withdrawal->rejected_at = now();
        $withdrawal->note = $request->note;
        $withdrawal->save();
        return redirect()->back()->with('success', 'Withdrawal disapproved successfully.');
    }

    public function retryWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::with(['user.country.setting', 'user.bankAccount'])->findOrFail($id);
        
        // Check if user has a bank account
        if (!$withdrawal->user->bankAccount) {
            return redirect()->back()->with('error', 'User does not have a bank account configured.');
        }
        
        // Reset status to pending for retry
        $withdrawal->update([
            'status' => 'pending',
            'note' => 'Retry initiated by admin'
        ]);
        
        return redirect()->back()->with('success', 'Withdrawal reset to pending for retry.');
    }

}
