<main class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Subscription Plans</h1>
        <div class="flex justify-center mb-8">
            <button wire:click="switchType('worker')" type="button" class="px-6 py-2 rounded-l-md text-sm font-medium focus:outline-none {{ $selectedType === 'worker' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                Worker
            </button>
            <button wire:click="switchType('taskmaster')" type="button" class="px-6 py-2 rounded-r-md text-sm font-medium focus:outline-none {{ $selectedType === 'taskmaster' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                Taskmaster
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($filteredPlans as $plan)
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 {{ $plan['type'] === 'worker' ? 'border-blue-500' : 'border-green-500' }} flex flex-col">
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $plan['name'] }}</h2>
                <p class="text-gray-600 mb-4">{{ $plan['description'] }}</p>
                <div class="text-2xl font-bold text-primary mb-2">{{ auth()->user()->country->currency_symbol }} {{ number_format($plan['monthly_price'], 2) }} <span class="text-base font-normal text-gray-500">/month</span></div>
                <ul class="mb-4 text-sm text-gray-700 list-disc ml-5">
                    @foreach($plan['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <div class="mt-auto">
                    <button wire:click="choosePlan('{{ $plan['slug'] }}')" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        @if(in_array($plan['id'], $activeSubscriptionPlanIds))
                            Extend Subscription
                        @else
                            Choose Plan
                        @endif
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-500">No plans available for this type.</div>
            @endforelse
        </div>

        <!-- Modal -->
        @if($showModal && $selectedPlan)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 relative">
                <button wire:click="$set('showModal', false)" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Subscribe to {{ $selectedPlan['name'] }}</h2>
                <div class="text-primary text-xl font-bold mb-2">
                    {{ auth()->user()->country->currency_symbol }} {{ number_format($selectedPlan['monthly_price'], 2) }}
                    <span class="text-base font-normal text-gray-500">/month</span>
                </div>
                <ul class="mb-4 text-sm text-gray-700 list-disc ml-5">
                    @foreach($selectedPlan['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (months)</label>
                    <input type="number" min="1" max="24" wire:model.live="selectedDuration" id="duration" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center">
                            <input type="radio"
                                   wire:model="paymentMethod"
                                   value="wallet"
                                   class="form-radio text-primary"
                                   @if($walletBalance < $totalAmount) disabled @endif
                            />
                            <span class="ml-2">
                                Wallet ({{ auth()->user()->country->currency_symbol }} {{ number_format($walletBalance, 2) }})
                                @if($walletBalance < $totalAmount)
                                    <span class="text-xs text-red-500 ml-1">(Insufficient balance)</span>
                                @endif
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="paymentMethod" value="gateway" class="form-radio text-primary" />
                            <span class="ml-2">Pay with Card/Bank (Gateway)</span>
                        </label>
                    </div>
                    @if($paymentMethod === 'wallet' && $walletBalance < $totalAmount)
                        <div class="text-red-600 text-sm mt-2">Insufficient wallet balance for this subscription.</div>
                    @endif
                </div>
                <div class="mb-4 text-sm text-gray-800 space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>{{ auth()->user()->country->currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax ({{ $tax_rate }}%):</span>
                        <span>{{ auth()->user()->country->currency_symbol }} {{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span class="text-primary">{{ auth()->user()->country->currency_symbol }} {{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>
                <button wire:click="subscribe"
                    class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    @if($paymentMethod === 'wallet' && $walletBalance < $totalAmount) disabled @endif>
                    Subscribe & Pay
                </button>
            </div>
        </div>
        @endif
    </div>
</main>