@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header d-flex align-items-center mb-4">
            <h1 class="header-title">Blog Comments</h1>
            <div class="ml-auto">
                <span class="badge bg-primary me-2">Total: {{ $totalComments }}</span>
                <span class="badge bg-warning me-2">Pending: {{ $pendingCount }}</span>
                <span class="badge bg-success me-2">Approved: {{ $approvedCount }}</span>
                <span class="badge bg-danger">Spam: {{ $spamCount }}</span>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.blog.comments') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Comments</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="post" class="form-label">Blog Post</label>
                        <select name="post" id="post" class="form-select">
                            <option value="">All Posts</option>
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}" {{ request('post') == $post->id ? 'selected' : '' }}>
                                    {{ Str::limit($post->title, 50) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search content, author..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-search-line"></i> Filter
                            </button>
                            <a href="{{ route('admin.blog.comments') }}" class="btn btn-secondary">
                                <i class="ri-refresh-line"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Engagement</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        @if($comment->user)
                                            <img src="{{ $comment->user->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                                                 alt="{{ $comment->user->name }}" 
                                                 class="rounded-circle" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="ri-user-line text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold">
                                            @if($comment->user)
                                                {{ $comment->user->name }}
                                                <span class="badge bg-info ms-1">Registered</span>
                                            @else
                                                {{ $comment->guest_name }}
                                                <span class="badge bg-warning ms-1">Guest</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            @if($comment->user)
                                                {{ $comment->user->email }}
                                            @else
                                                {{ $comment->guest_email }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="comment-content">
                                    <p class="mb-1">{{ Str::limit($comment->content, 100) }}</p>
                                    @if($comment->mentions)
                                        <small class="text-primary">
                                            <i class="ri-at-line"></i> Mentions: {{ count(json_decode($comment->mentions, true) ?? []) }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('blog.show', $comment->blogPost->slug) }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($comment->blogPost->title, 40) }}
                                </a>
                            </td>
                            <td>
                                @if($comment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($comment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                    @if($comment->is_featured)
                                        <span class="badge bg-primary ms-1">Featured</span>
                                    @endif
                                @elseif($comment->status === 'spam')
                                    <span class="badge bg-danger">Spam</span>
                                @elseif($comment->status === 'rejected')
                                    <span class="badge bg-secondary">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <div>{{ $comment->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $comment->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">
                                        <i class="ri-heart-line"></i> {{ $comment->likes_count }}
                                    </span>
                                    @if($comment->approved_at)
                                        <small class="text-success">
                                            <i class="ri-check-line"></i> Approved {{ $comment->approved_at->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    @if($comment->status === 'pending')
                                        <form action="{{ route('admin.blog.comments.approve') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="ri-check-line"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.blog.comments.reject') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Reject">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($comment->status !== 'spam')
                                        <form action="{{ route('admin.blog.comments.spam') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <button type="submit" class="btn btn-sm btn-warning" title="Mark as Spam">
                                                <i class="ri-spam-line"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.blog.comments.delete') }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @csrf
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="ri-delete-bin-2-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if($comments->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="ri-message-3-line fs-1 text-muted mb-3 d-block"></i>
                                No comments found matching your criteria.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                
                @if($comments->hasPages())
                <div class="mt-3">
                    {{ $comments->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .comment-content p {
        line-height: 1.4;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush
