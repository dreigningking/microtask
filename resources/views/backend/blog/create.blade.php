@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header mb-4">
            <h1 class="header-title">Create Blog Post</h1>
            <!-- <a href="{{ route('admin.blog.index') }}" class="btn btn-light float-right"><i class="ri-arrow-left-line"></i> Back to List</a> -->
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Excerpt</label>
                                <textarea name="excerpt" class="form-control" rows="2" required>{{ old('excerpt') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="featured_image" class="form-control">
                                <small class="text-muted">Recommended: 1200x420px</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" name="author" class="form-control" value="{{ old('author', auth()->user()->name ?? 'Admin') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_published" class="form-control">
                                    <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Publish Date</label>
                                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', now()->toDateString()) }}">
                            </div>
                            <button class="btn btn-primary w-100"><i class="ri-save-line"></i> Create Post</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection