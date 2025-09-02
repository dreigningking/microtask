@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header d-flex align-items-center mb-4">
            <h1 class="header-title">Blog Posts</h1>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary ml-auto">
                <i class="ri-add-line"></i> New Post
            </a>
        </div>

        <!-- Filters Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.blog.index') }}" id="blogFiltersForm">
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ request('title') }}" placeholder="Search by title">
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" class="form-control" id="author" name="author" 
                                           value="{{ request('author') }}" placeholder="Search by author">
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">All Categories</option>
                                        @if($categories)
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="featured" class="form-label">Featured</label>
                                    <select class="form-select" id="featured" name="featured">
                                        <option value="">All Posts</option>
                                        <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured Only</option>
                                        <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="published_after" class="form-label">Published After</label>
                                    <input type="date" class="form-control" id="published_after" name="published_after" 
                                           value="{{ request('published_after') }}">
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="published_before" class="form-label">Published Before</label>
                                    <input type="date" class="form-control" id="published_before" name="published_before" 
                                           value="{{ request('published_before') }}">
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="published_date" class="form-label">Published Date</label>
                                    <input type="date" class="form-control" id="published_date" name="published_date" 
                                           value="{{ request('published_date') }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2" id="applyFiltersBtn">
                                        <i class="ri-search-line me-1"></i>Apply Filters
                                    </button>
                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                                        <i class="ri-refresh-line me-1"></i>Clear Filters
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Blog Posts</h5>
                <h6 class="card-subtitle text-muted">
                    @if($posts->total() > 0)
                        Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                    @else
                        No blog posts found
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Excerpt</th>
                                <th>Author</th>
                                <th>Published</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td>
                                    @if($post->featured_image)
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="rounded" style="width:80px; height:50px; object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:80px; height:50px;">
                                            <i class="ri-image-line text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('blog.show', $post) }}" target="_blank">
                                        <strong>{{ $post->title }}</strong>
                                    </a>
                                    <div class="d-flex gap-2 mt-1">
                                        @if($post->featured)
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                        @if($post->category)
                                            <span class="badge bg-info">{{ $post->category }}</span>
                                        @endif
                                        @if($post->reading_time)
                                            <span class="badge bg-light text-dark">{{ $post->reading_time }} min read</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($post->excerpt, 60) }}</span>
                                </td>
                                <td>
                                    @if($post->user)
                                        <span class="badge bg-light text-dark">{{ $post->user->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($post->published_at)
                                        <span class="text-muted">{{ $post->published_at->format('M d, Y') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($post->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($post->status === 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @elseif($post->status === 'archived')
                                        <span class="badge bg-dark">Archived</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-warning">
                                            <i class="ri-edit-line me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.blog.destroy') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this post?')">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-2-line me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ri-inbox-line me-2"></i>No blog posts found
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($posts->hasPages())
            <div class="card-footer">
                @include('backend.layouts.pagination', ['items' => $posts])
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .filter-loading {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    
    .btn-group {
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .btn-group .btn {
        margin: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {
        // Auto-submit form when certain filters change
        $('#status, #category, #featured').on('change', function() {
            $('#blogFiltersForm').submit();
        });

        // Add loading state to form
        function setFormLoading(loading) {
            const form = $('#blogFiltersForm');
            if (loading) {
                form.addClass('filter-loading');
                $('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
            } else {
                form.removeClass('filter-loading');
                $('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
            }
        }

        // Show loading state when form is submitted
        $('#blogFiltersForm').on('submit', function() {
            setFormLoading(true);
        });
    });
</script>
@endpush