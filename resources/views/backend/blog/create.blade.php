@extends('backend.layouts.dashboard')
@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote-bs4.css')}}">
@endpush
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
                            <div class="mb-4">
                                <label class="form-label font-semibold">Title <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-pen"></i></span>
                                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                                </div>
                                @error('title') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label font-semibold">Excerpt <span class="text-danger">*</span></label>
                                <textarea name="excerpt" class="form-control" rows="2" required>{{ old('excerpt') }}</textarea>
                                @error('excerpt') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label font-semibold">Content <span class="text-danger">*</span></label>
                                <textarea id="content" name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
                                @error('content') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- SEO Section -->
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-header bg-transparent">
                                    <h5 class="mb-0"><i class="ri-search-line mr-2"></i>SEO Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Leave empty to use post title">
                                        @error('meta_title') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" rows="2" placeholder="Leave empty to use post excerpt">{{ old('meta_description') }}</textarea>
                                        @error('meta_description') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                        @error('meta_keywords') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label font-semibold">Featured Image</label>
                                <input type="file" name="featured_image" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Recommended: 1200x420px</small>
                                <div id="imagePreview" class="mt-2">
                                    <!-- JS will show preview here -->
                                </div>
                                @error('featured_image') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-semibold">Tags</label>
                                <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3">
                                <small class="text-muted">Separate tags with commas</small>
                                @error('tags') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            

                            <div class="mb-4">
                                <label class="form-label font-semibold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-semibold">Publish Date</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                @error('published_at') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="featured" class="form-check-input" value="1" {{ old('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label">Featured Post</label>
                                </div>
                                @error('featured') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="allow_comments" class="form-check-input" value="1" {{ old('allow_comments', true) ? 'checked' : '' }}>
                                    <label class="form-check-label">Allow Comments</label>
                                </div>
                                @error('allow_comments') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <button class="btn btn-primary w-100 flex items-center justify-center gap-2" type="submit">
                                <i class="ri-save-line"></i> <span>Create Post</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script src="{{asset('backend/summernote/summernote-bs4.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    // Handle image upload if needed
                    for(let i=0; i < files.length; i++) {
                        uploadImage(files[i], this);
                    }
                }
            }
        });
    });

    function uploadImage(file, editor) {
        // You can implement image upload functionality here
        // For now, we'll just create a placeholder
        const reader = new FileReader();
        reader.onload = function(e) {
            $(editor).summernote('insertImage', e.target.result);
        }
        reader.readAsDataURL(file);
    }

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid rounded shadow border mt-2';
                img.style.maxHeight = '180px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush