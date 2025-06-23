<main class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-mail-check-line text-primary text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Verify Your Email</h1>
                    <p class="text-gray-600 mt-2">Please check your inbox to confirm your account</p>
                </div>
                
                <div class="mt-4 flex flex-col gap-6">
                    <p class="text-center text-gray-700">
                        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="bg-green-50 border-l-4 border-green-400 p-4">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-green-700">
                                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col items-center justify-between space-y-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                {{ __('Resend verification email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-secondary hover:text-primary cursor-pointer">
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>