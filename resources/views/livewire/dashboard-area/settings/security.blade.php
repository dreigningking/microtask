<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Security Settings</h1>

    {{-- 2FA Section --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Two-Factor Authentication (2FA)</h2>
        <div class="flex items-center gap-4 mb-2">
            <span class="font-medium">Status:</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $two_factor_enabled ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                {{ $two_factor_enabled ? 'Enabled' : 'Disabled' }}
            </span>
            <button wire:click="toggle2FA" @if($enforce_2fa) disabled @endif class="ml-4 px-4 py-2 rounded-button text-white {{ $two_factor_enabled ? 'bg-red-500 hover:bg-red-600' : 'bg-primary hover:bg-primary/90' }} focus:outline-none focus:ring-2 focus:ring-primary">
                {{ $two_factor_enabled ? 'Disable 2FA' : 'Enable 2FA' }}
            </button>
        </div>
        @if($enforce_2fa)
            <div class="text-xs text-gray-500 mt-2">2FA is enforced by the platform and cannot be disabled.</div>
        @endif
        <div class="text-xs text-gray-500 mt-2">All 2FA codes are sent to your email address.</div>
    </div>

    {{-- Password Update Section --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Update Password</h2>
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 text-green-700 mb-4">{{ session('success') }}</div>
        @endif
        <form wire:submit.prevent="updatePassword" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" wire:model.defer="current_password" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('current_password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" wire:model.defer="password" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" wire:model.defer="password_confirmation" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-button hover:bg-primary/90">Update Password</button>
        </form>
    </div>

    {{-- Recent Logins Section --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Login History</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">IP ADDRESS</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">DATE & TIME</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">DEVICE</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">OPERATING SYSTEM</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">BROWSER</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_logins as $login)
                    <tr class="@if($login->is_current) bg-blue-50 @endif">
                        <td class="px-4 py-2 font-mono font-bold text-gray-800">{{ $login->ip_address }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $login->created_at->format('M j, Y g:i A') }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $login->device }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $login->os }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $login->browser }}</td>
                        <td class="px-4 py-2">
                            @if($login->status === 'Active')
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700">Active</span>
                            @elseif($login->status === 'Success')
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700">Success</span>
                            @elseif($login->status === 'Unusual location')
                                <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700">Unusual location</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    
</div> 