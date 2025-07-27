<div>
    {{-- The whole world belongs to you. --}}
    <form wire:submit.prevent="updatePassword">
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input wire:model.defer="current_password" id="current_password" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input wire:model.defer="new_password" id="new_password" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input wire:model.defer="new_password_confirmation" id="new_password_confirmation" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-darker focus:outline-none focus:border-primary-darker focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150">
                Update Password
            </button>
        </div>
    </form>
</div>
