<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-4">My Payments & Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Currency</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">VAT</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paid For</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr>
                            <td class="px-4 py-2">{{ $payment->reference }}</td>
                            <td class="px-4 py-2">{{ $payment->currency }}</td>
                            <td class="px-4 py-2">{{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($payment->vat_value, 2) }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                    @if($payment->status === 'success') bg-green-100 text-green-800
                                    @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-2">
                                <button @click="window.dispatchEvent(new CustomEvent('open-modal-{{ $payment->id }}'))" class="btn btn-primary btn-xs">View Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>

    @foreach($payments as $payment)
        <div x-data="{ show: false }"
             x-on:open-modal-{{ $payment->id }}.window="show = true"
             x-show="show"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto p-6 relative">
                <button @click="show = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-lg font-semibold mb-4">Paid For Details (Payment Ref: {{ $payment->reference }})</h3>
                <div>
                    @if($payment->order && $payment->order->items)
                        <ul class="mb-0">
                            @foreach($payment->order->items as $item)
                                <li class="mb-2">
                                    @php
                                        $type = class_basename($item->orderable_type ?? '');
                                    @endphp
                                    @if($type === 'Task')
                                        Task: {{ $item->orderable->title ?? '-' }}
                                    @elseif($type === 'TaskPromotion')
                                        Task Promotion: {{ $item->orderable->type ?? '-' }}
                                    @elseif($type === 'Subscription')
                                        Subscription: {{ $item->orderable->plan->name ?? '-' }}
                                    @else
                                        {{ $type }}
                                    @endif
                                    ({{ number_format($item->amount, 2) }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No order items found for this payment.</p>
                    @endif
                </div>
                <div class="mt-4 text-right">
                    <button @click="show = false" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    @endforeach
</div>
