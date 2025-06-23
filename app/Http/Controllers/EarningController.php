<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Exchange;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function earnings()
    {
        $settlements = Settlement::with(['user', 'settlementable'])->orderBy('id', 'desc')->get();
        return view('backend.finance.settlements', compact('settlements'));
    }

    public function payments(){
        $payments = \App\Models\Payment::with(['user', 'order.items.orderable'])->orderBy('id', 'desc')->get();
        return view('backend.finance.payments', compact('payments'));
    }

    public function exchanges(){
        $exchanges = Exchange::with(['user', 'base_wallet', 'target_wallet'])->orderBy('id', 'desc')->get();
        return view('backend.finance.exchanges', compact('exchanges'));
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::with(['user.country.setting', 'approver'])->orderBy('id', 'desc')->get();
        return view('backend.finance.withdrawals', compact('withdrawals'));
    }


    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::with('user.country.setting')->findOrFail($id);
        $withdrawal->status = 'approved';
        // Default to 'gateway' if setting or method is not present
        $payoutMethod = $withdrawal->user->country->setting->payout_method ?? 'gateway';
    
        if ($payoutMethod === 'manual') {
            // For manual payouts, approving means it has been paid
            $withdrawal->status = 'paid';
            $withdrawal->paid_at = now();
        }
    
        $withdrawal->approved_by = Auth::id();
        $withdrawal->approved_at = now();
        $withdrawal->save();
    
        return redirect()->back()->with('success', 'Withdrawal updated successfully.');
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

}
