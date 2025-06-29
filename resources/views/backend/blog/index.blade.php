@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header mb-4">
            <h1 class="header-title">Blog Posts</h1>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary float-right">
                <i class="ri-add-line"></i> New Post
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Excerpt</th>
                            <th>Author</th>
                            <th>Published</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>
                                <img src="{{ $post->featured_image ?? 'https://picsum.photos/seed/'.$post->id.'wonegig/80/50' }}" alt="Image" class="rounded" style="width:80px; height:50px; object-fit:cover;">
                            </td>
                            <td>
                                <strong>{{ $post->title }}</strong>
                            </td>
                            <td>
                                {{ Str::limit($post->excerpt, 60) }}
                            </td>
                            <td>
                                {{ $post->author->name ?? 'Admin' }}
                            </td>
                            <td>
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}
                            </td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-warning"><i class="ri-edit-line"></i> Edit</a>
                                <form action="{{ route('admin.blog.destroy') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                    <button class="btn btn-sm btn-danger"><i class="ri-delete-bin-2-line"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($posts->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center text-muted">No blog posts found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection