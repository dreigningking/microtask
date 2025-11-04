@extends('backend.layouts.dashboard')

@section('title', 'Send Announcements')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Announcements
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Announcements</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Send Announcement to All Users</h4>
                        <p class="card-text">Send an important message to all active users on the platform.</p>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('admin.announcements.send') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                            id="subject" name="subject" value="{{ old('subject') }}"
                                            placeholder="Enter announcement subject" required>
                                        @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('message') is-invalid @enderror"
                                            id="message" name="message" rows="8"
                                            placeholder="Enter your announcement message here..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <small class="text-muted">Maximum 5000 characters. This message will be sent to all active users.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Warning:</strong> This announcement will be sent to all active users on the platform.
                                        Please ensure your message is clear and appropriate for all users.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to send this announcement to all users?')">
                                            <i class="fas fa-paper-boostere me-2"></i>
                                            Send Announcement
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement History -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Announcement History</h5>
                        <p class="card-text">View all previously sent announcements.</p>
                    </div>
                    <div class="card-body">
                        @if($announcements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Sent By</th>
                                        <th>Recipients</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $announcement)
                                    <tr>
                                        <td>
                                            <strong>{{ $announcement->subject }}</strong>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $announcement->message }}">
                                                {{ Str::limit($announcement->message, 100) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $announcement->sender->name ?? 'Unknown' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $announcement->recipients_count }}</span>
                                        </td>
                                        <td>
                                            @if($announcement->status === 'sent')
                                            <span class="badge bg-success">Sent</span>
                                            @else
                                            <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $announcement->created_at->format('M d, Y H:i') }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $announcements->links() }}
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No announcements have been sent yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
 @endsection
@push('scripts')
<script>
    // Character counter for message
    document.getElementById('message').addEventListener('input', function() {
        const maxLength = 5000;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;

        // Update character count
        const formText = this.parentNode.querySelector('.form-text');
        if (formText) {
            formText.innerHTML = `<small class="text-muted">${currentLength}/${maxLength} characters remaining. This message will be sent to all active users.</small>`;
        }

        // Add warning class when approaching limit
        if (remaining <= 100) {
            this.classList.add('border-warning');
        } else {
            this.classList.remove('border-warning');
        }

        // Add danger class when over limit
        if (remaining < 0) {
            this.classList.add('border-danger');
        } else {
            this.classList.remove('border-danger');
        }
    });
</script>
@endpush
   