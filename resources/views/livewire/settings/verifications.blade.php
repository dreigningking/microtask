<div>
<h5 class="mb-4">Identity & Address Verification</h5>

@if (session('status') === 'verification-submitted')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-check-line me-2"></i>Verification document submitted successfully. It is now pending review.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@forelse($verificationRequirements as $category => $req)
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">{{ $category }}</h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">
                You are required to submit {{ $req['mode'] === 'all' ? 'all of the following' : 'at least one of the following' }} documents.
            </p>

            <div class="row g-3">
                @foreach($req['docs'] as $docName)
                    @php
                        $verification = $userVerifications[$docName] ?? null;
                        $status = $verification->status ?? 'not_submitted';
                        $statusClasses = [
                            'not_submitted' => 'border-secondary',
                            'pending' => 'border-warning',
                            'approved' => 'border-success',
                            'rejected' => 'border-danger',
                        ];
                        $statusText = [
                            'not_submitted' => 'Not Submitted',
                            'pending' => 'Pending Review',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ];
                        $statusBadgeClasses = [
                            'not_submitted' => 'bg-secondary',
                            'pending' => 'bg-warning',
                            'approved' => 'bg-success',
                            'rejected' => 'bg-danger',
                        ];
                    @endphp
                    <div class="col-12">
                        <div class="card {{ $statusClasses[$status] }} border-start border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6 class="card-title mb-1">
                                            {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $docName)) }}
                                            <small class="text-muted">({{ $category }})</small>
                                        </h6>
                                        <span class="badge {{ $statusBadgeClasses[$status] }}">
                                            {{ $statusText[$status] }}
                                        </span>
                                    </div>
                                    @if($status !== 'approved')
                                        <div class="col-md-6">
                                            <form wire:submit.prevent="saveVerification('{{ $docName }}')">
                                                <div class="d-flex gap-2">
                                                    <input type="file" wire:model="uploads.{{ $docName }}" 
                                                           id="{{ $docName }}_upload" 
                                                           class="form-control form-control-sm">
                                                    <button type="submit" class="btn btn-primary btn-sm" 
                                                            wire:loading.attr="disabled" 
                                                            wire:target="uploads.{{ $docName }}">
                                                        <span wire:loading.remove wire:target="uploads.{{ $docName }}">
                                                            <i class="ri-upload-line me-1"></i>Submit
                                                        </span>
                                                        <span wire:loading wire:target="uploads.{{ $docName }}">
                                                            <i class="ri-loader-4-line me-1"></i>Uploading...
                                                        </span>
                                                    </button>
                                                </div>
                                                <small class="text-muted">Accepted file types: JPG, PNG, PDF. Max size: 2MB.</small>
                                                @error('uploads.' . $docName) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                @if ($uploads[$docName] ?? false)
                                    <div class="mt-3">
                                        <small class="text-muted">Preview:</small>
                                        @if (str_starts_with($uploads[$docName]->getMimeType(), 'image/'))
                                            <img src="{{ $uploads[$docName]->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                        @else
                                            <div class="d-flex align-items-center gap-2 p-2 bg-light rounded mt-2">
                                                <i class="ri-file-line text-muted"></i>
                                                <span class="small">{{ $uploads[$docName]->getClientOriginalName() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @elseif ($verification && $verification->file_path)
                                    <div class="mt-3">
                                        <small class="text-muted">Submitted Document:</small>
                                        @php
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
                                            $fileExtension = strtolower(pathinfo($verification->file_path, PATHINFO_EXTENSION));
                                        @endphp
                                        @if(in_array($fileExtension, $imageExtensions))
                                            <img src="{{ Storage::url($verification->file_path) }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                        @else
                                            <div class="d-flex align-items-center gap-2 p-2 bg-light rounded mt-2">
                                                <i class="ri-file-line text-muted"></i>
                                                <a href="{{ Storage::url($verification->file_path) }}" target="_blank" class="text-decoration-none">
                                                    {{ basename($verification->file_path) }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($status === 'rejected' && $verification->remarks)
                                    <div class="alert alert-danger mt-3 mb-0">
                                        <strong>Reason:</strong> {{ $verification->remarks }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5">
        <i class="ri-shield-check-line display-4 text-muted mb-3"></i>
        <p class="text-muted">No verification requirements are currently set for your country.</p>
    </div>
@endforelse
</div>