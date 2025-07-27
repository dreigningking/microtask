<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <button wire:click="confirmDeletion" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
        Delete Account
    </button>

    @if($confirming)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="mt-4">
                    <input wire:model.defer="password" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Password">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="$set('confirming', false)" class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </button>

                    <button wire:click="deleteAccount" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
