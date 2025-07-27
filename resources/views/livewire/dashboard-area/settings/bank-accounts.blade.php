<div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
    @if ($storage_location === 'on_premises')
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @if(!empty($verification_settings['required']) && $bankAccount)
            <div class="mb-4 p-4 rounded-md @if($bankAccount->verified_at) bg-green-50 dark:bg-green-900/50 border-green-200 dark:border-green-700 @else bg-yellow-50 dark:bg-yellow-900/50 border-yellow-200 dark:border-yellow-700 @endif">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($bankAccount->verified_at)
                            <i class="ri-checkbox-circle-fill text-green-500"></i>
                        @else
                            <i class="ri-error-warning-fill text-yellow-500"></i>
                        @endif
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm @if($bankAccount->verified_at) text-green-700 dark:text-green-300 @else text-yellow-700 dark:text-yellow-300 @endif">
                            @if($bankAccount->verified_at)
                                Your bank account has been verified.
                            @else
                                Your bank account is pending verification.
                            @endif
                        </p>
                        @if(!$bankAccount->verified_at)
                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <button wire:click="verifyAccount" class="whitespace-nowrap font-medium text-yellow-700 dark:text-yellow-300 hover:text-yellow-600 dark:hover:text-yellow-200">
                                    Verify Now <span aria-hidden="true">&rarr;</span>
                                </button>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="saveBankAccount">
            <div class="space-y-4">
                @foreach($required_fields as $field)
                    @if($field === 'bank_name')
                        <div>
                            <label for="bank_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                            <select id="bank_code" wire:model.defer="bank_code"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                    {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                                <option value="">Select a bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank['code'] }}">{{ ucwords($bank['name']) }}</option>
                                @endforeach
                            </select>
                            @error('bank_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div>
                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" id="{{ $field }}" wire:model.defer="{{ $field }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                   {{ !$isEditMode && $bankAccount ? 'disabled' : '' }}>
                            @error($field) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                @if($isEditMode || !$bankAccount)
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary/90">
                        Save
                    </button>
                    @if($bankAccount)
                        <button type="button" wire:click="toggleEditMode" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                            Cancel
                        </button>
                    @endif
                @else
                    <button type="button" wire:click="toggleEditMode" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary/90">
                        Edit
                    </button>
                @endif
            </div>
        </form>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Bank Account Management</h3>
            @if($bankAccount)
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Your bank account is securely connected via our payment provider.
                </p>
                <button class="mt-4 inline-block px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary/90">
                    Reconnect Account
                </button>
            @else
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    To manage your bank account details, please connect to our payment provider.
                </p>
                <button class="mt-4 inline-block px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary/90">
                    Connect Bank Account
                </button>
            @endif
        </div>
    @endif
</div>
