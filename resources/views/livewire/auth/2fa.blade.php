<main class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-shield-keyhole-line text-primary text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Two-Factor Authentication</h1>
                <p class="text-gray-600 mt-2">A verification code has been sent to your email address.</p>
            </div>
            <form wire:submit.prevent="verify" class="space-y-4">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Verification Code</label>
                    <input type="text" id="code" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required autofocus wire:model="code">
                    @if($otp_error)
                        <div class="text-red-500 text-sm mt-1">{{ $otp_error }}</div>
                    @endif
                    @if($otp_response)
                        <div class="text-green-500 text-sm mt-1">{{ $otp_response }}</div>
                    @endif
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">Verify</button>
            </form>
            <div class="mt-4 text-center">
                <button type="button" class="text-primary underline text-sm" wire:click="resend">Resend code</button>
            </div>
        </div>
    </div>
</main> 