<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Task;
use App\Models\TaskPromotion;
use App\Models\Subscription;
use App\Models\Withdrawal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Transactions extends Component
{
    use WithPagination;

    public $search = '';
    public $type = 'all';
    public $status = 'all';
    public $dateFrom = '';
    public $dateTo = '';
    public $currencySymbol = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => 'all'],
        'status' => ['except' => 'all'],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->currencySymbol = $user->country->currency_symbol ?? '$';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->type = 'all';
        $this->status = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    private function getTransactionType($payment)
    {
        // Check if this is a withdrawal (negative amount)
        if ($payment->amount < 0) {
            return 'withdrawal';
        }

        // Check order items to determine type
        if ($payment->order && $payment->order->items) {
            foreach ($payment->order->items as $item) {
                if ($item->orderable_type === Subscription::class) {
                    return 'subscription';
                } elseif ($item->orderable_type === TaskPromotion::class) {
                    return 'promotion';
                } elseif ($item->orderable_type === Task::class) {
                    return 'task';
                }
            }
        }

        // Default to income if positive amount
        return $payment->amount > 0 ? 'income' : 'other';
    }

    private function getTransactionDescription($payment)
    {
        if ($payment->order && $payment->order->items) {
            foreach ($payment->order->items as $item) {
                if ($item->orderable_type === Subscription::class && $item->orderable) {
                    $booster = $item->orderable->booster;
                    return 'Subscription - ' . ($booster ? $booster->name : 'Plan');
                } elseif ($item->orderable_type === TaskPromotion::class && $item->orderable) {
                    return 'Task Promotion - ' . $item->orderable->type;
                } elseif ($item->orderable_type === Task::class && $item->orderable) {
                    return 'Task Payment: ' . ($item->orderable->title ?? 'Task');
                }
            }
        }

        // Check if it's a withdrawal
        if ($payment->amount < 0) {
            return 'Bank Withdrawal';
        }

        return 'Payment - ' . $payment->reference;
    }

    public function render()
    {
        $user = Auth::user();

        $payments = Payment::with(['order.items.orderable'])
            ->where('user_id', $user->id)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('reference', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->dateFrom, function($query) {
                $query->whereDate('created_at', '>=', Carbon::parse($this->dateFrom));
            })
            ->when($this->dateTo, function($query) {
                $query->whereDate('created_at', '<=', Carbon::parse($this->dateTo));
            })
            ->when($this->type !== 'all', function($query) {
                $query->where(function($q) {
                    switch ($this->type) {
                        case 'income':
                            $q->where('amount', '>', 0)
                              ->whereDoesntHave('order.items', function($itemQuery) {
                                  $itemQuery->where('orderable_type', Subscription::class);
                              });
                            break;
                        case 'subscription':
                            $q->whereHas('order.items', function($itemQuery) {
                                $itemQuery->where('orderable_type', Subscription::class);
                            });
                            break;
                        case 'promotion':
                            $q->whereHas('order.items', function($itemQuery) {
                                $itemQuery->where('orderable_type', TaskPromotion::class);
                            });
                            break;
                        case 'withdrawal':
                            $q->where('amount', '<', 0);
                            break;
                        case 'task':
                            $q->whereHas('order.items', function($itemQuery) {
                                $itemQuery->where('orderable_type', Task::class);
                            });
                            break;
                    }
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        // Add computed properties to payments
        $payments->getCollection()->transform(function($payment) {
            $payment->transaction_type = $this->getTransactionType($payment);
            $payment->transaction_description = $this->getTransactionDescription($payment);
            return $payment;
        });

        // Calculate stats
        $stats = [
            'total' => Payment::where('user_id', $user->id)->count(),
            'successful' => Payment::where('user_id', $user->id)->where('status', 'success')->count(),
            'failed' => Payment::where('user_id', $user->id)->where('status', 'failed')->count(),
            'total_amount' => Payment::where('user_id', $user->id)->where('status', 'success')->sum('amount'),
        ];

        return view('livewire.transactions', [
            'payments' => $payments,
            'stats' => $stats
        ]);
    }
}