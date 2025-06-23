<div class="container mx-auto px-4 py-8">
    <!-- Wallet Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($wallets as $wallet)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $wallet->currency }}</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ number_format($wallet->balance, 2) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        @if($wallet->balance > 0)
                            @if($wallet->currency === auth()->user()->country->currency)
                                <button wire:click="openWithdrawModal('{{ $wallet->currency }}')" 
                                        class="btn btn-secondary btn-sm">
                                    <i class="ri-bank-card-line mr-1"></i> Withdraw
                                </button>
                            @endif
                            @if(count($wallets) > 1 && $wallet->currency !== auth()->user()->country->currency)
                                <button wire:click="openExchangeModal('{{ $wallet->currency }}')" 
                                        class="btn btn-primary btn-sm">
                                    <i class="ri-exchange-dollar-line mr-1"></i> Exchange
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Total Earned</span>
                        <span>{{ number_format($wallet->total_earned, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mt-2">
                        <span>Total Withdrawn</span>
                        <span>{{ number_format($wallet->total_withdrawn, 2) }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="$set('activeTab', 'settlements')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'settlements' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Settlements
                </button>
                <button wire:click="$set('activeTab', 'withdrawals')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'withdrawals' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Withdrawals
                </button>
                <button wire:click="$set('activeTab', 'exchanges')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'exchanges' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Exchanges
                </button>
            </nav>
        </div>

        <!-- Settlements Tab -->
        @if($activeTab === 'settlements')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($settlements as $settlement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($settlement->settlementable_type === 'App\\Models\\Task')
                                        <div class="text-sm font-medium text-gray-900">Task</div>
                                    @elseif ($settlement->settlementable_type === 'App\\Models\\Referral')
                                        @if ($settlement->settlementable->type === 'internal')
                                            <div class="text-sm font-medium text-gray-900">Task Invitation</div>
                                        @else
                                            <div class="text-sm font-medium text-gray-900">Referral</div>
                                        @endif
                                    @else
                                        <div class="text-sm font-medium text-gray-900">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($settlement->settlementable_type === 'App\\Models\\Task' && $settlement->settlementable)
                                        <div class="text-sm text-gray-900">{{ $settlement->settlementable->title }}</div>
                                    @elseif ($settlement->settlementable_type === 'App\\Models\\Referral' && $settlement->settlementable)
                                        <div class="text-sm text-gray-900">{{ $settlement->settlementable->email }}</div>
                                    @else
                                        <div class="text-sm text-gray-900">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $settlement->currency }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($settlement->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $settlement->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No settlements found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $settlements->links() }}
            </div>
        @endif

        <!-- Withdrawals Tab -->
        @if($activeTab === 'withdrawals')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $withdrawal->reference }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $withdrawal->currency }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($withdrawal->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($withdrawal->status === 'paid') bg-green-100 text-green-800
                                        @elseif($withdrawal->status === 'approved') bg-blue-100 text-blue-800
                                        @elseif($withdrawal->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($withdrawal->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $withdrawal->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No withdrawals found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $withdrawals->links() }}
            </div>
        @endif

        <!-- Exchanges Tab -->
        @if($activeTab === 'exchanges')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($exchanges as $exchange)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $exchange->reference }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($exchange->base_amount, 2) }} {{ $exchange->base_currency }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($exchange->target_amount, 2) }} {{ $exchange->target_currency }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($exchange->exchange_rate, 4) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($exchange->status === 'completed') bg-green-100 text-green-800
                                        @elseif($exchange->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($exchange->status === 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $exchange->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No exchanges found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $exchanges->links() }}
            </div>
        @endif
    </div>

    <!-- Withdrawal Modal -->
    <div x-data="{ show: @entangle('showWithdrawModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="ri-bank-card-line text-primary text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Withdraw {{ $withdrawCurrency }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="withdrawAmount" class="block text-sm font-medium text-gray-700">Amount</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">{{ $withdrawCurrency }}</span>
                                        </div>
                                        <input type="number" 
                                               id="withdrawAmount" 
                                               wire:model.live="withdrawAmount" 
                                               step="0.01"
                                               class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                               placeholder="0.00">
                                    </div>
                                    @error('withdrawAmount') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="bg-gray-50 rounded-md p-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Available Balance:</span>
                                        <span class="font-medium">{{ number_format($availableBalance, 2) }} {{ $withdrawCurrency }}</span>
                                    </div>
                                    
                                    @if($withdrawAmount > 0 && !$errors->has('withdrawAmount'))
                                        <div class="border-t pt-2 space-y-1">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-500">Withdrawal Fee:</span>
                                                <span class="font-medium text-red-600">{{ number_format($withdrawalFee, 2) }} {{ $withdrawCurrency }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm font-bold pt-1">
                                                <span class="text-gray-700">You will receive:</span>
                                                <span class="text-primary">{{ number_format($netAmount, 2) }} {{ $withdrawCurrency }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="submitWithdrawal" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Submit Withdrawal
                    </button>
                    <button type="button" wire:click="closeWithdrawModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Exchange Modal -->
    <div x-data="{ show: @entangle('showExchangeModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="ri-exchange-dollar-line text-primary text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Exchange Currency
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="bg-gray-50 rounded-md p-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">From Currency:</span>
                                        <span class="font-medium">{{ $fromCurrency }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Available Balance:</span>
                                        <span class="font-medium">{{ number_format($exchangeAvailableBalance, 2) }} {{ $fromCurrency }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">To Currency:</span>
                                        <span class="font-medium">{{ $toCurrency }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount to Exchange</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">{{ $fromCurrency }}</span>
                                        </div>
                                        <input type="number"
                                               id="amount"
                                               wire:model.live="amount"
                                               step="0.01"
                                               class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                               placeholder="0.00">
                                    </div>
                                    @error('amount') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                @if($targetAmount > 0)
                                    <div class="bg-gray-50 rounded-md p-4">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Exchange Rate:</span>
                                            <span class="font-medium">1 {{ $fromCurrency }} &asymp; {{ number_format($exchangeRate, 4) }} {{ $toCurrency }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm mt-2 font-bold">
                                            <span class="text-gray-700">You will receive:</span>
                                            <span class="text-primary">{{ number_format($targetAmount, 2) }} {{ $toCurrency }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="executeExchange" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm" @if($targetAmount <= 0) disabled @endif>
                        Confirm Exchange
                    </button>
                    <button type="button" wire:click="closeExchangeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
