<div>

    <section class="task-header py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-5 fw-bold my-3">{{ $post->title }}</h1>
                    <p class="lead mb-4">{{ $post->excerpt }}</p>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Support Article Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="blog-content">
                        @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" class="img-fluid w-100" alt="Support Article Image">
                        @else
                        <img src="https://placehold.co/800x400/10b981/ffffff?text=Support+Article+Image" class="img-fluid w-100" alt="Support Article Image">
                        @endif

                        {!! $post->content !!}
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <a href="{{ route('support.articles') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left-circle me-2"></i> Back to Help</a>
                            <a href="{{ route('support') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left-circle me-2"></i> Back to Support</a>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
