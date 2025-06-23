<main class="container mx-auto px-4 py-6 lg:flex lg:gap-6">
    <!-- Mobile Search and Filter Controls -->
    <div class="lg:hidden sticky top-[72px] bg-white z-40 border-b pb-4">
        <div class="flex gap-3 mb-4">
            <button wire:click="$set('showSearch', true)" class="flex-1 flex items-center justify-center gap-2 bg-white border border-gray-300 py-3 px-4 rounded-button shadow-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="ri-search-line ri-lg"></i>
                <span>Search Jobs</span>
            </button>
            <button wire:click="$set('showFilters', true)" class="flex-1 flex items-center justify-center gap-2 bg-white border border-gray-300 py-3 px-4 rounded-button shadow-sm hover:bg-gray-50 whitespace-nowrap">
                <i class="ri-filter-3-line ri-lg"></i>
                <span>Filters</span>
            </button>
        </div>
    </div>

    <!-- Desktop Sidebar Filters -->
    <aside class="hidden lg:block w-72 bg-white p-5 rounded-lg shadow-sm sticky top-[88px] h-[calc(100vh-120px)] overflow-auto">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filters</h2>

            <!-- Search -->
            <div class="relative mb-6">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search for jobs..." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center">
                    <i class="ri-search-line text-gray-500"></i>
                </div>
            </div>

            <!-- Platform Filter -->
            <div class="mb-6">
                <h3 class="font-medium text-gray-800 mb-3">Platforms</h3>
                <div class="space-y-2">
                    @foreach($platforms as $key => $platform)
                    <label class="flex items-center gap-2 text-sm" wire:key="platform-{{ $key }}">
                        <input type="checkbox" wire:key="platform-checkbox-{{ $key }}" wire:model.live="selectedPlatforms" value="{{ $platform->id }}" class="custom-checkbox">
                        <span>{{ $platform->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Range -->
            <div class="mb-6">
                <h3 class="font-medium text-gray-800 mb-3">Price Range</h3>
                <div class="px-1">
                    <input type="range" wire:model.live="maxPrice" min="0" max="1000" class="w-full custom-range">
                    <div class="flex justify-between text-sm text-gray-600 mt-1">
                        <span>${{ $minPrice }}</span>
                        <span>${{ $maxPrice }}</span>
                    </div>
                </div>
            </div>

            <!-- Duration -->
            <div class="mb-6">
                <h3 class="font-medium text-gray-800 mb-3">Duration</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedDurations" value="less_than_1_hour" class="custom-checkbox">
                        <span>Less than 1 hour</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedDurations" value="1_3_hours" class="custom-checkbox">
                        <span>1-3 hours</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedDurations" value="3_6_hours" class="custom-checkbox">
                        <span>3-6 hours</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedDurations" value="6_plus_hours" class="custom-checkbox">
                        <span>6+ hours</span>
                    </label>
                </div>
            </div>

            <!-- Experience Level -->
            <div class="mb-6">
                <h3 class="font-medium text-gray-800 mb-3">Experience Level</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedExperienceLevels" value="entry" class="custom-checkbox">
                        <span>Entry Level</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedExperienceLevels" value="intermediate" class="custom-checkbox">
                        <span>Intermediate</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedExperienceLevels" value="expert" class="custom-checkbox">
                        <span>Expert</span>
                    </label>
                </div>
            </div>

            <!-- Skills -->
            <div class="mb-6">
                <h3 class="font-medium text-gray-800 mb-3">Skills</h3>
                <div class="space-y-2">
                    @foreach($skills as $skill)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="selectedSkills" value="{{ $skill }}" class="custom-checkbox">
                        <span>{{ $skill }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button wire:click="clearFilters" class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 rounded-button hover:bg-gray-50 whitespace-nowrap">Clear All</button>
            </div>
        </div>
    </aside>

    <!-- Job Listings -->
    <div class="flex-1">
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Explore Jobs</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">Sort by:</span>
                    <select wire:model.live="sortBy" class="border border-gray-300 rounded-button py-2 pr-8 pl-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                        <option value="latest">Newest First</option>
                        <option value="highest_paid">Highest Paying</option>
                        <option value="shortest_time">Quickest Tasks</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
            <p class="text-gray-600">Found {{ $totalTasks }} jobs matching your criteria</p>
        </div>

        <!-- Job Cards -->
        <div class="space-y-4">
            @if($tasks->count() > 0)
                @foreach($tasks as $task)
                    @livewire('tasks.single-task-list', ['task' => $task], key('task-'.$task->id))
                @endforeach
            @else
                <div class="text-center text-gray-600">No tasks found</div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $tasks->links() }}
        </div>
    </div>

    <!-- Task Details Modal -->
    @if($showModal && $selectedTask)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.away="closeModal">
            <div class="p-6">
                <!-- Title -->
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $selectedTask->title }}</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="ri-close-line ri-lg"></i>
                    </button>
                </div>

                <!-- Meta Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600 mb-6">
                    <div class="flex items-center gap-2">
                        <i class="ri-money-dollar-circle-line text-lg text-primary"></i>
                        <span>{{ $selectedTask->user->country->currency_symbol ?? '$' }}{{ $selectedTask->budget_per_person }} per person</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ri-group-line text-lg text-primary"></i>
                        <span>{{ $selectedTask->workers->whereNotNull('accepted_at')->count() }} of {{ $selectedTask->number_of_people }} spots filled</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ri-time-line text-lg text-primary"></i>
                        <span>
                            @php
                                $minutes = $selectedTask->expected_completion_minutes;
                                if ($minutes < 60) {
                                    echo $minutes . " minutes";
                                } elseif ($minutes < 1440) {
                                    echo floor($minutes / 60) . " hours";
                                } else {
                                    echo floor($minutes / 1440) . " days";
                                }
                            @endphp
                        </span>
                    </div>
                    @if($selectedTask->expiry_date)
                    <div class="flex items-center gap-2">
                        <i class="ri-calendar-close-line text-lg text-primary"></i>
                        <span>Expires in {{ $selectedTask->expiry_date->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>

                <!-- Description Snippet -->
                <div class="mb-6">
                    <p class="text-gray-700 line-clamp-3">{{ $selectedTask->description }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('explore.task', $selectedTask) }}" class="w-full sm:w-auto flex justify-center bg-primary text-white px-6 py-3 rounded-button hover:bg-primary/90 whitespace-nowrap font-medium">
                        View Full Details
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Mobile Search Modal -->
    @if($showSearch)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Search Jobs</h3>
                    <button wire:click="$set('showSearch', false)" class="text-gray-500">
                        <i class="ri-close-line ri-lg"></i>
                    </button>
                </div>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search for jobs..." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center">
                        <i class="ri-search-line text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Mobile Filters Modal -->
    @if($showFilters)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Filters</h3>
                    <button wire:click="$set('showFilters', false)" class="text-gray-500">
                        <i class="ri-close-line ri-lg"></i>
                    </button>
                </div>

                <!-- Platform Filter -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Platforms</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($platforms as $platform)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedPlatforms" value="{{ $platform->id }}" class="custom-checkbox">
                            <span>{{ $platform->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Price Range</h4>
                    <div class="px-1">
                        <input type="range" wire:model.live="maxPrice" min="0" max="1000" class="w-full custom-range">
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span>${{ $minPrice }}</span>
                            <span>${{ $maxPrice }}</span>
                        </div>
                    </div>
                </div>

                <!-- Duration -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Duration</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedDurations" value="less_than_1_hour" class="custom-checkbox">
                            <span>Less than 1 hour</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedDurations" value="1_3_hours" class="custom-checkbox">
                            <span>1-3 hours</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedDurations" value="3_6_hours" class="custom-checkbox">
                            <span>3-6 hours</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedDurations" value="6_plus_hours" class="custom-checkbox">
                            <span>6+ hours</span>
                        </label>
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Experience Level</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedExperienceLevels" value="entry" class="custom-checkbox">
                            <span>Entry Level</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedExperienceLevels" value="intermediate" class="custom-checkbox">
                            <span>Intermediate</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedExperienceLevels" value="expert" class="custom-checkbox">
                            <span>Expert</span>
                        </label>
                    </div>
                </div>

                <!-- Skills -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Skills</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($skills as $skill)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="selectedSkills" value="{{ $skill }}" class="custom-checkbox">
                            <span>{{ $skill }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button wire:click="clearFilters" class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-button hover:bg-gray-50 whitespace-nowrap">Clear All</button>
            </div>
        </div>
    </div>
    @endif
</main>

@push('styles')
<style>
    .rounded-button {
        border-radius: 6px;
    }
    
    .custom-checkbox {
        display: inline-block;
        position: relative;
        padding-left: 25px;
        margin-right: 10px;
        cursor: pointer;
    }
    
    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    
    .custom-checkbox input:checked ~ .checkmark {
        background-color: #0d47a1;
        border-color: #0d47a1;
    }
    
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }
    
    .custom-checkbox .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .custom-range {
        -webkit-appearance: none;
        width: 100%;
        height: 6px;
        border-radius: 5px;
        background: #e2e8f0;
        outline: none;
    }
    
    .custom-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #0d47a1;
        cursor: pointer;
    }
    
    .custom-range::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border: none;
        border-radius: 50%;
        background: #0d47a1;
        cursor: pointer;
    }
</style>
@endpush