<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Browse Available Tasks</h1>
                    <p class="mb-0">Find micro-jobs that match your skills and start earning</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
                        <span class="me-3">Sort by:</span>
                        <select wire:model.live="sortBy" class="form-select form-select-sm w-auto">
                            <option value="latest">Newest First</option>
                            <option value="highest_paid">Highest Paying</option>
                            <option value="shortest_time">Quickest Tasks</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Flash Messages -->


    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3 mb-4">
                    <button class="filter-toggle d-lg-none w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterColumn">
                        <i class="fas fa-filter me-2"></i> Show Filters
                    </button>
                    <div class="collapse d-lg-block" id="filterColumn">
                        <div class="filter-section">
                            <h5 class="mb-3">Filters</h5>

                            <!-- Category Filter -->
                            <div class="mb-4">
                                <h6>Category</h6>
                                @foreach($platforms as $platform)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedPlatforms" value="{{ $platform->id }}" id="platform-{{ $platform->id }}">
                                    <label class="form-check-label" for="platform-{{ $platform->id }}">
                                        {{ $platform->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>



                            <div class="mb-4">
                                <h6>Price Range</h6>
                                <div class="mb-3">
                                    <input type="range" wire:model.live="maxPrice" min="0" max="1000" class="form-range" id="priceRange">
                                    <div class="d-flex justify-content-between text-sm text-muted mt-1">
                                        <span>${{ $minPrice }}</span>
                                        <span>${{ $maxPrice }}</span>
                                    </div>
                                </div>
                            </div>



                            <div class="mb-4">
                                <h6 class="filter-title">Task Duration</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedDurations" value="less_than_1_hour" id="duration-1">
                                    <label class="form-check-label" for="duration-1">
                                        Less than 1 hour
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedDurations" value="1_3_hours" id="duration-2">
                                    <label class="form-check-label" for="duration-2">
                                        1-3 hours
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedDurations" value="3_6_hours" id="duration-3">
                                    <label class="form-check-label" for="duration-3">
                                        3-6 hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedDurations" value="6_plus_hours" id="duration-4">
                                    <label class="form-check-label" for="duration-4">
                                        6+ hours
                                    </label>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-4">
                                <h6>Deadline</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deadline1">
                                    <label class="form-check-label" for="deadline1">Next 24 hours</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deadline2">
                                    <label class="form-check-label" for="deadline2">Next 3 days</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deadline3">
                                    <label class="form-check-label" for="deadline3">Next week</label>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100">Apply Filters</button>
                        </div>

                        <!-- Quick Stats -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h6>Your Activity</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Applied Tasks:</span>
                                    <strong>12</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Completed:</span>
                                    <strong>8</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Earnings:</span>
                                    <strong>$247</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks List -->
                <div class="col-lg-9">
                    <!-- Search Bar -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search tasks...">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6>Found {{ $totalTasks }} tasks </h6>
                            @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1060;">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1060;">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tasks Grid -->
                    <div class="row g-4">
                        @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                        <div class="col-lg-6">
                            @include('components.layouts.taskcard',['task'=> $task])
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <h5>No tasks found</h5>
                                <p>Try adjusting your search criteria or filters</p>
                            </div>
                        </div>
                        @endif

                        <!-- Task 2 -->
                        <div class="col-lg-6">
                            <div class="task-card card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-success">Social Media</span>
                                        <span class="price-tag">$45</span>
                                    </div>
                                    <h5 class="card-title">Instagram Post Design</h5>
                                    <p class="card-text text-muted">Create 5 engaging Instagram posts for our coffee shop. Brand guidelines provided.</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> 3 days left</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 8 applicants</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/30" alt="Poster" class="rounded-circle me-2">
                                        <div>
                                            <small class="fw-bold">Mike Chen</small>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <span class="text-muted">(4.0)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100">Apply Now</button>
                                </div>
                            </div>
                        </div>

                        <!-- Task 3 -->
                        <div class="col-lg-6">
                            <div class="task-card card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-info">Writing</span>
                                        <span class="price-tag">$60</span>
                                    </div>
                                    <h5 class="card-title">Blog Article Writer</h5>
                                    <p class="card-text text-muted">Write a 1000-word blog post about sustainable living. SEO knowledge preferred.</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> 5 days left</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 15 applicants</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/30" alt="Poster" class="rounded-circle me-2">
                                        <div>
                                            <small class="fw-bold">Tech Solutions Inc.</small>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span class="text-muted">(5.0)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100">Apply Now</button>
                                </div>
                            </div>
                        </div>

                        <!-- Task 4 -->
                        <div class="col-lg-6">
                            <div class="task-card card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-warning">Graphic Design</span>
                                        <span class="price-tag">$85</span>
                                    </div>
                                    <h5 class="card-title">Logo Design for Startup</h5>
                                    <p class="card-text text-muted">Create a modern logo for a tech startup. Need vector files and brand guidelines.</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> 7 days left</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 22 applicants</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/30" alt="Poster" class="rounded-circle me-2">
                                        <div>
                                            <small class="fw-bold">Innovate Labs</small>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <span class="text-muted">(4.5)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100">Apply Now</button>
                                </div>
                            </div>
                        </div>

                        <!-- Task 5 -->
                        <div class="col-lg-6">
                            <div class="task-card card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-secondary">Web Development</span>
                                        <span class="price-tag">$120</span>
                                    </div>
                                    <h5 class="card-title">Fix WordPress Website Issues</h5>
                                    <p class="card-text text-muted">Need help fixing CSS issues and mobile responsiveness on WordPress site.</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> 1 day left</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 6 applicants</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/30" alt="Poster" class="rounded-circle me-2">
                                        <div>
                                            <small class="fw-bold">David Wilson</small>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <span class="text-muted">(3.0)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100">Apply Now</button>
                                </div>
                            </div>
                        </div>

                        <!-- Task 6 -->
                        <div class="col-lg-6">
                            <div class="task-card card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-primary">Data Entry</span>
                                        <span class="price-tag">$35</span>
                                    </div>
                                    <h5 class="card-title">PDF to Excel Conversion</h5>
                                    <p class="card-text text-muted">Convert 20 PDF documents with tables into Excel format. Attention to detail required.</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted"><i class="bi bi-clock"></i> 4 days left</small>
                                        <small class="text-muted"><i class="bi bi-person"></i> 9 applicants</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/30" alt="Poster" class="rounded-circle me-2">
                                        <div>
                                            <small class="fw-bold">Marketing Pro</small>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span class="text-muted">(5.0)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn apply-btn w-100">Apply Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-5">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')

@endpush