<main class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-mail-check-line text-primary text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Verify Your Email</h1>
                <p class="text-gray-600 mt-2">We need to verify your email address to continue.</p>
            </div>

            <div class="mt-4 flex flex-col gap-6">
                <p class="text-center text-gray-700">
                    We will send a verification code to your email address:
                    <span class="font-semibold">{{ $user->email }}</span>
                </p>
                <div class="flex justify-center mb-2">
                    <button class="text-sm text-primary underline" wire:click="$set('showEditEmail', true)">Edit email</button>
                </div>

                @if ($otp_response)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 text-green-700 text-center mb-2">
                        {{ $otp_response }}
                    </div>
                @endif
                @if ($otp_error)
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 text-red-700 text-center mb-2">
                        {{ $otp_error }}
                    </div>
                @endif

                @if (! $showCodeInput)
                    <div class="flex flex-col items-center gap-3">
                        <button type="button" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors" wire:click="otp_send">
                            Get Verification Code
                        </button>
                        @if (session()->has('otp_sent'))
                            <button type="button" class="w-full mt-2 bg-secondary text-white py-2 px-4 rounded-button hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors" wire:click="$set('showCodeInput', true)">
                                I've received the code
                            </button>
                        @endif
                    </div>
                @else
                    <div class="flex flex-col items-center gap-3">
                        <input type="text" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Enter verification code" wire:model="code">
                        <button type="button" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors" wire:click="otp_verify">
                            Validate Code
                        </button>
                        <button type="button" class="text-sm text-primary underline mt-2" wire:click="otp_send">
                            Resend code
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @if ($showEditEmail)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm relative">
                    <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-600" wire:click="$set('showEditEmail', false)">&times;</button>
                    <h2 class="text-lg font-bold mb-4">Edit Email Address</h2>
                    <input type="email" class="form-control w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none mb-3" wire:model="email">
                    @error('email')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <div class="flex justify-end gap-2">
                        <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-button" wire:click="$set('showEditEmail', false)">Cancel</button>
                        <button class="bg-primary text-white px-4 py-2 rounded-button" wire:click.prevent="saveEmail">Save</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>