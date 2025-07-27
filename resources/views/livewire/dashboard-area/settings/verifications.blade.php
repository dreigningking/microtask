<div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Identity & Address Verification</h3>

    @if (session('status') === 'verification-submitted')
        <div class="mb-4 text-sm text-green-600 dark:text-green-400 p-4 bg-green-50 dark:bg-green-900/50 rounded-md border border-green-200 dark:border-green-700">
            Verification document submitted successfully. It is now pending review.
        </div>
    @endif

    @forelse($verificationRequirements as $category => $req)
        <div class="mb-6">
            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $category }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                You are required to submit {{ $req['mode'] === 'all' ? 'all of the following' : 'at least one of the following' }} documents.
            </p>

            <div class="space-y-4">
                @foreach($req['docs'] as $docName)
                    @php
                        $verification = $userVerifications[$docName] ?? null;
                        $status = $verification->status ?? 'not_submitted';
                        $statusClasses = [
                            'not_submitted' => 'bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600',
                            'pending' => 'bg-yellow-50 dark:bg-yellow-900/50 border-yellow-400 dark:border-yellow-600',
                            'approved' => 'bg-green-50 dark:bg-green-900/50 border-green-500 dark:border-green-600',
                            'rejected' => 'bg-red-50 dark:bg-red-900/50 border-red-400 dark:border-red-600',
                        ];
                        $statusText = [
                            'not_submitted' => 'Not Submitted',
                            'pending' => 'Pending Review',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ];
                    @endphp
                    <div class="border-l-4 p-4 {{ $statusClasses[$status] }}">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
<div>
                                <h5 class="font-medium text-gray-800 dark:text-white">
                                    {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $docName)) }}
                                    <span class="text-xs text-gray-500 ml-2">({{ $documentType = array_search($docName, $req['docs']) !== false ? $category : '' }})</span>
                                </h5>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ ['approved' => 'text-green-600 bg-green-200 dark:bg-green-700 dark:text-green-200', 'pending' => 'text-yellow-600 bg-yellow-200 dark:bg-yellow-700 dark:text-yellow-200', 'rejected' => 'text-red-600 bg-red-200 dark:bg-red-700 dark:text-red-200', 'not_submitted' => 'text-gray-600 bg-gray-200 dark:bg-gray-600 dark:text-gray-300'][$status] }}">
                                    {{ $statusText[$status] }}
                                </span>
                            </div>
                            @if($status !== 'approved')
                                <div class="mt-4 md:mt-0">
                                    <form wire:submit.prevent="saveVerification('{{ $docName }}')">
                                        <div class="flex items-center space-x-2">
                                            <input type="file" wire:model="uploads.{{ $docName }}" id="{{ $docName }}_upload" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 dark:file:bg-primary/20 dark:file:text-white dark:hover:file:bg-primary/30"/>
                                            <button type="submit" class="px-3 py-2 text-sm bg-primary text-white rounded-md hover:bg-primary/90" wire:loading.attr="disabled" wire:target="uploads.{{ $docName }}">
                                                <span wire:loading.remove wire:target="uploads.{{ $docName }}">Submit</span>
                                                <span wire:loading wire:target="uploads.{{ $docName }}">Uploading...</span>
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Accepted file types: JPG, PNG, PDF. Max size: 2MB.</p>
                                        @error('uploads.' . $docName) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </form>
                                </div>
                            @endif
                        </div>

                        @if ($uploads[$docName] ?? false)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Preview:</p>
                                @if (str_starts_with($uploads[$docName]->getMimeType(), 'image/'))
                                    <img src="{{ $uploads[$docName]->temporaryUrl() }}" class="h-20 rounded-md mt-1">
                                @else
                                    <div class="flex items-center space-x-2 p-2 bg-gray-100 dark:bg-gray-700 rounded-md mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $uploads[$docName]->getClientOriginalName() }}</p>
                                    </div>
                                @endif
                            </div>
                        @elseif ($verification && $verification->file_path)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Submitted Document:</p>
                                @php
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
                                    $fileExtension = strtolower(pathinfo($verification->file_path, PATHINFO_EXTENSION));
                                @endphp
                                @if(in_array($fileExtension, $imageExtensions))
                                    <img src="{{ Storage::url($verification->file_path) }}" class="h-20 rounded-md mt-1">
                                @else
                                    <div class="flex items-center space-x-2 p-2 bg-gray-100 dark:bg-gray-700 rounded-md mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <a href="{{ Storage::url($verification->file_path) }}" target="_blank" class="text-sm text-primary hover:underline">{{ basename($verification->file_path) }}</a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if ($status === 'rejected' && $verification->remarks)
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/50 p-3 rounded-md">
                                <strong>Reason:</strong> {{ $verification->remarks }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500 dark:text-gray-400">No verification requirements are currently set for your country.</p>
    @endforelse
</div>
