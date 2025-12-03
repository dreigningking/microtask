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
                                    <input class="form-check-input" type="checkbox" wire:model="selectedPlatforms" value="{{ $platform->id }}" id="platform-{{ $platform->id }}">
                                    <label class="form-check-label" for="platform-{{ $platform->id }}">
                                        {{ $platform->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>



                            <div class="mb-4">
                                <h6>Price Range</h6>
                                <div class="mb-3">
                                    <input type="range" wire:model="maxPrice" min="0" max="1000" class="form-range" id="priceRange">
                                    <div class="d-flex justify-content-between text-sm text-muted mt-1">
                                        <span>{{ $minPrice }}</span>
                                        <span>{{ $maxPrice }}</span>
                                    </div>
                                </div>
                            </div>



                            <div class="mb-4">
                                <h6 class="filter-title">Task Duration</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedDurations" value="less_than_1_hour" id="duration-1">
                                    <label class="form-check-label" for="duration-1">
                                        Less than 1 hour
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedDurations" value="1_3_hours" id="duration-2">
                                    <label class="form-check-label" for="duration-2">
                                        1-3 hours
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedDurations" value="3_6_hours" id="duration-3">
                                    <label class="form-check-label" for="duration-3">
                                        3-6 hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedDurations" value="6_plus_hours" id="duration-4">
                                    <label class="form-check-label" for="duration-4">
                                        6+ hours
                                    </label>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-4">
                                <h6>Deadline</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="selectedDeadline" value="24_hours" id="deadline-24h">
                                    <label class="form-check-label" for="deadline-24h">Within 24 hours</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="selectedDeadline" value="7_days" id="deadline-7d">
                                    <label class="form-check-label" for="deadline-7d">Within 7 days</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="selectedDeadline" value="30_days" id="deadline-30d">
                                    <label class="form-check-label" for="deadline-30d">Within 30 days</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="selectedDeadline" value="3_months" id="deadline-3m">
                                    <label class="form-check-label" for="deadline-3m">Within 3 months</label>
                                </div>
                            </div>

                            <button wire:click="applyFilters" class="btn btn-primary w-100">Apply Filters</button>
                        </div>

                        <!-- Clear Filters -->
                        @if($hasActiveFilters)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="fas fa-times me-2"></i> Clear Filters
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Tasks List -->
                <div class="col-lg-9">
                    <!-- Search Bar -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" wire:model="search" class="form-control" placeholder="Search tasks...">
                                <button wire:click="searchTasks" class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6>Found {{ $totalTasks }} tasks</h6>
                                @if($hasActiveFilters)
                                <a href="#" wire:click.prevent="clearFilters" class="text-decoration-none">
                                    <i class="fas fa-times me-1"></i>Clear Filters
                                </a>
                                @endif
                            </div>
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