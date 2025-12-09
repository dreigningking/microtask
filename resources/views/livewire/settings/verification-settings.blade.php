<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h4 mb-0">Profile Settings</h1>
                    <p class="mb-0">Manage your account information, security, and preferences</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="earnings.html" class="btn btn-outline-light">Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    @include('livewire.settings.menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-shield-check-line me-2"></i>Verifications
                            </h5>
                        </div>
                        <div class="card-body">
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
                                            if (!$verification) {
                                            $status = 'not_submitted';
                                            } else {
                                            $status = $verification->latestModeration->status ?? 'pending';
                                            }
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
                                                            <div class="col-md-12 d-flex justify-content-between mb-3">
                                                                <h6 class="card-title mb-1">
                                                                    {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $docName)) }}
                                                                    <small class="text-muted">({{ $category }})</small>
                                                                </h6>
                                                                <span class="badge {{ $statusBadgeClasses[$status] }}">
                                                                    {{ $statusText[$status] }}
                                                                </span>
                                                            </div>
                                                            <div class="col-md-12">
                                                                @if($status !== 'approved')
                                                                <form wire:submit.prevent="saveVerification('{{ $docName }}')" class="row g-1">
                                                                    <div class="col-md-3">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="{{ $docName }}_upload">Select File</label>
                                                                            <input type="file" wire:model="uploads.{{ $docName }}"
                                                                                id="{{ $docName }}_upload"
                                                                                class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="mb-3">
                                                                            <label for="issued_at_{{ $docName }}" class="form-label">Issue Date</label>
                                                                            <input type="date" wire:model="issued_at.{{ $docName }}"
                                                                                id="issued_at_{{ $docName }}"
                                                                                class="form-control form-control-sm">
                                                                            @error('issued_at.' . $docName) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="mb-3">
                                                                            <label for="expiry_at_{{ $docName }}" class="form-label">Expiry Date</label>
                                                                            <input type="date" wire:model="expiry_at.{{ $docName }}"
                                                                                id="expiry_at_{{ $docName }}"
                                                                                class="form-control form-control-sm"
                                                                                {{ $never_expires[$docName] ?? false ? 'disabled' : '' }}>

                                                                            @error('expiry_at.' . $docName) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="mb-3">
                                                                            <label for="never_expires_{{ $docName }}" class="form-label">&nbsp;</label>
                                                                            <div class="form-check mt-2">
                                                                                <input class="form-check-input" type="checkbox" wire:model="never_expires.{{ $docName }}"
                                                                                    id="never_expires_{{ $docName }}">
                                                                                <label class="form-check-label" for="never_expires_{{ $docName }}">
                                                                                    Never Expires
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="" class="form-label">&nbsp;</label>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                                wire:loading.attr="disabled"
                                                                                wire:target="submitting.{{ $docName }}">
                                                                                <span class="submit-text" wire:loading.class="d-none" wire:target="submitting.{{ $docName }}">
                                                                                    <i class="ri-upload-line me-1"></i>Submit
                                                                                </span>
                                                                                <span class="uploading-text" style="display: none;" wire:loading.class.remove="d-none" wire:target="submitting.{{ $docName }}">
                                                                                    <i class="ri-loader-4-line me-1"></i>Uploading...
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <small class="text-muted">Accepted file types: JPG, PNG, PDF. Max size: 2MB.</small>
                                                                        @error('uploads.' . $docName) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                                    </div>

                                                                </form>
                                                                @endif
                                                            </div>
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

                                                        @if ($status === 'rejected' && $verification->latestModeration && $verification->latestModeration->notes)
                                                        <div class="alert alert-danger mt-3 mb-0">
                                                            <strong>Reason:</strong> {{ $verification->latestModeration->notes }}
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>