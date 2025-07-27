<div>
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title">Find Quick Tasks & <br>Earn Money</h1>
                    <p class="hero-subtitle">
                        Connect with thousands of micro-jobs and start earning today. Registration is completely free!
                    </p>
            </div>
        </div>

            <div class="row mt-4">
                <div class="col-lg-10 mx-auto">
                    <div class="search-card">
                        <form class="search-form row g-3" wire:submit.prevent="searchJobs">
                            <div class="col-md-5">
                                <input type="text" class="form-control" wire:model.defer="searchQuery" placeholder="Search for jobs...">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>All Locations</option>
                                    <option>New York</option>
                                    <option>Los Angeles</option>
                                    <option>Chicago</option>
                                    <option>Remote</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="platforms" wire:model.defer="searchPlatform">
                                    <option value="">All Platforms</option>
                                    @if($allPlatforms)
                                        @foreach($allPlatforms as $platform)
                                            <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>

            <div class="row mt-4 text-center">
                <div class="col-md-12">
                    <p class="text-light mb-0"><strong>Popular Searches:</strong> Graphic Designer, Web Developer, Social Media Manager, Project Manager, Copywriter</p>
                            </div>
                        </div>
                    </div>
    </section>

    <!-- Job Categories Slider -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Popular Platforms</h2>
                    <p class="text-muted">Browse through the most in-demand platforms and find the perfect micro-job that matches your skills</p>
                </div>
            </div>

            <!-- Job Categories Slider -->
            <div class="position-relative">
                <!-- Left Button -->
                <button type="button" class="btn btn-light category-scroll-btn category-scroll-left"
                    style="position:absolute;top:50%;left:-40px;z-index:2;transform:translateY(-50%);">
                    <i class="fas fa-chevron-left"></i>
                        </button>

                <!-- Scrollable Categories -->
                <div class="category-scroll-wrapper d-flex overflow-auto" style="scroll-behavior:smooth;">
                    @foreach($popularPlatforms as $platform)
                        <div class="category-card card text-center p-4 flex-shrink-0 mx-2" style="min-width:220px;">
                            <div class="category-icon">
                                @if($platform['image'])
                                    <img src="{{ $platform['image'] }}" alt="{{ $platform['name'] }}" style="width:40px;height:40px;object-fit:contain;">
                                @else
                                    <i class="fas fa-briefcase"></i>
                                @endif
                            </div>
                            <h5>{{ $platform['name'] }}</h5>
                            <p class="text-muted">{{ number_format($platform['jobs_count']) }} Jobs Available</p>
                        </div>
                    @endforeach
                </div>

                <!-- Right Button -->
                <button type="button" class="btn btn-light category-scroll-btn category-scroll-right"
                    style="position:absolute;top:50%;right:-40px;z-index:2;transform:translateY(-50%);">
                    <i class="fas fa-chevron-right"></i>
                    </button>
            </div>

            <!-- Bottom Navigation (arrows) -->
            <div class="text-center mt-3">
                <button type="button" class="btn btn-outline-secondary category-scroll-btn category-scroll-left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary category-scroll-btn category-scroll-right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>


        </div>
    </section>

    <!-- Featured Jobs -->
    @if($tasks->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Featured Jobs</h2>
                    <p class="text-muted">Hand-picked opportunities you might love</p>
                </div>
            </div>

            <div class="row">
                @foreach($tasks as $task)
                    <div class="col-lg-6">
                        @livewire('tasks.single-task-grid', ['task' => $task])
                </div>
                @endforeach
                <!-- Job 1 --> 
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('explore') }}" class="btn btn-primary">Browse All Tasks</a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- How It Works -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">How It Works</h2>
                    <p class="text-muted">Get started in just a few easy steps</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="how-it-works-step">
                        <div class="step-number">1</div>
                        <h4>Create an Account</h4>
                        <p>Sign up for free in just a few seconds. No credit card required until you're ready to post a job.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="how-it-works-step">
                        <div class="step-number">2</div>
                        <h4>Find Opportunities</h4>
                        <p>Browse thousands of gigs and tasks that match your skills and preferences.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="how-it-works-step">
                        <div class="step-number">3</div>
                        <h4>Complete & Get Paid</h4>
                        <p>Work on tasks, deliver quality results, and receive payment securely through our platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('styles')
<style>
    .category-scroll-wrapper {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE 10+ */
    }
    .category-scroll-wrapper::-webkit-scrollbar {
        display: none; /* Chrome/Safari/Webkit */
    }
</style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.category-scroll-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const wrapper = document.querySelector('.category-scroll-wrapper');
                const scrollAmount = 240; // px
                if (this.classList.contains('category-scroll-left')) {
                    wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else if (this.classList.contains('category-scroll-right')) {
                    wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endpush