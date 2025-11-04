<div>
    <!-- Hero Section -->
    <section class="pt-16 navy-gradient relative overflow-hidden">
        <div class="absolute inset-0" style="background-image: url('frontend/images/hero.jpg'); background-size: cover; background-position: center; opacity: 0.15;"></div>
        <div class="container mx-auto px-4 py-12 relative z-10">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Find Quick Tasks & Earn Money</h1>
                <p class="text-xl text-blue-100 mb-8">Connect with thousands of micro-jobs and start earning today. Registration is completely free!</p>

                <!-- Search Bar -->
                <div class="search-container bg-white rounded-lg p-2 flex flex-col md:flex-row shadow-lg mb-8" wire:submit.prevent="searchJobs">
                    <div class="flex-1 flex items-center px-3 border-b md:border-b-0 md:border-r border-gray-200 py-2 md:py-0">
                        <div class="w-6 h-6 flex items-center justify-center text-gray-400 mr-2">
                            <i class="ri-search-line"></i>
                        </div>
                        <input type="text" wire:model.defer="searchQuery" placeholder="Search for jobs..." class="w-full text-gray-700 text-sm">
                    </div>
                    <div class="flex items-center px-3 border-b md:border-b-0 md:border-r border-gray-200 py-2 md:py-0">
                        <div class="w-6 h-6 flex items-center justify-center text-gray-400 mr-2">
                            <i class="ri-filter-3-line"></i>
                        </div>
                        <select id="platforms" wire:model.defer="searchPlatform" class="w-full text-gray-700 bg-transparent pr-8 text-sm">
                            <option value="">All Platforms</option>
                            @if($allPlatforms)
                                @foreach($allPlatforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-button font-medium text-sm mt-2 md:mt-0 whitespace-nowrap">Search Jobs</button>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('tasks.create') }}" class="bg-white text-primary px-8 py-3 rounded-button font-semibold shadow-md hover:shadow-lg transition-shadow whitespace-nowrap">Post a Job</a>
                    <a href="{{ route('register') }}" class="bg-secondary bg-opacity-20 text-white border border-white border-opacity-30 px-8 py-3 rounded-button font-semibold hover:bg-opacity-30 transition-colors whitespace-nowrap">Register Now</a>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" fill="#f9fafb">
                <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
            </svg>
        </div>
    </section>

    @if($tasks->count() > 0)
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Latest Micro-Jobs</h2>

                <!-- Desktop Filters -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative">
                        <button id="platformFilterBtn" class="flex items-center space-x-2 bg-white border border-gray-200 rounded-button px-4 py-2 text-sm text-gray-700 shadow-sm whitespace-nowrap">
                            <span>Platform</span>
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </button>
                        <div id="platformFilterDropdown" class="hidden absolute left-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10">
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </span>
                                    All Platforms
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    Design
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    Writing
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    Development
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="priceFilterBtn" class="flex items-center space-x-2 bg-white border border-gray-200 rounded-button px-4 py-2 text-sm text-gray-700 shadow-sm whitespace-nowrap">
                            <span>Price Range</span>
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </button>
                        <div id="priceFilterDropdown" class="hidden absolute left-0 mt-2 w-64 bg-white rounded shadow-lg p-4 z-10">
                            <div class="mb-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">$0</span>
                                    <span class="text-sm text-gray-600">$1000</span>
                                </div>
                                <input type="range" min="0" max="1000" value="500" class="w-full custom-range">
                            </div>
                            <div class="flex items-center justify-between">
                                <input type="number" placeholder="Min" class="w-24 px-3 py-2 border border-gray-300 rounded text-sm">
                                <span class="text-gray-400 mx-2">-</span>
                                <input type="number" placeholder="Max" class="w-24 px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="timeFilterBtn" class="flex items-center space-x-2 bg-white border border-gray-200 rounded-button px-4 py-2 text-sm text-gray-700 shadow-sm whitespace-nowrap">
                            <span>Time Frame</span>
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </button>
                        <div id="timeFilterDropdown" class="hidden absolute left-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10">
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </span>
                                    Any Time
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    Less than 1 hour
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    1-3 hours
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    3-6 hours
                                </label>
                            </div>
                            <div class="px-4 py-2">
                                <label class="flex items-center text-sm text-gray-700">
                                    <span class="custom-checkbox">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </span>
                                    6+ hours
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="sortFilterBtn" class="flex items-center space-x-2 bg-white border border-gray-200 rounded-button px-4 py-2 text-sm text-gray-700 shadow-sm whitespace-nowrap">
                            <span>Sort By: Latest</span>
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </button>
                        <div id="sortFilterDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Latest</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Popular</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Highest Paid</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Shortest Time</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Filter Button -->
                <button id="mobileFilterBtn" class="md:hidden flex items-center space-x-2 bg-white border border-gray-200 rounded-button px-4 py-2 text-sm text-gray-700 shadow-sm whitespace-nowrap">
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-filter-3-line"></i>
                    </div>
                    <span>Filters</span>
                </button>
            </div>

            <!-- Mobile Filter Modal -->
            <div id="mobileFilterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-xl p-4 max-h-[80vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                        <button id="closeFilterModal" class="w-8 h-8 flex items-center justify-center text-gray-500">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Platform</h4>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </span>
                                All Platforms
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                Design
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                Writing
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                Development
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                Marketing
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Price Range</h4>
                        <div class="mb-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">$0</span>
                                <span class="text-sm text-gray-600">$1000</span>
                            </div>
                            <input type="range" min="0" max="1000" value="500" class="w-full custom-range">
                        </div>
                        <div class="flex items-center justify-between">
                            <input type="number" placeholder="Min" class="w-24 px-3 py-2 border border-gray-300 rounded text-sm">
                            <span class="text-gray-400 mx-2">-</span>
                            <input type="number" placeholder="Max" class="w-24 px-3 py-2 border border-gray-300 rounded text-sm">
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Time Frame</h4>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </span>
                                Any Time
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                Less than 1 hour
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                1-3 hours
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                3-6 hours
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <span class="custom-checkbox">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </span>
                                6+ hours
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Sort By</h4>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="radio" name="sort" checked class="mr-2 accent-primary">
                                Latest
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="radio" name="sort" class="mr-2 accent-primary">
                                Popular
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="radio" name="sort" class="mr-2 accent-primary">
                                Highest Paid
                            </label>
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="radio" name="sort" class="mr-2 accent-primary">
                                Shortest Time
                            </label>
                        </div>
                    </div>

                    <button class="w-full bg-primary text-white py-3 rounded-button font-medium whitespace-nowrap">Apply Filters</button>
                </div>
            </div>

            <!-- Job Cards -->
            <div class="relative">
                <div class="job-cards-container flex overflow-x-auto pb-4 -mx-4 px-4 space-x-4 snap-x scrollbar-hide">
                    @foreach($tasks as $task)
                        @livewire('tasks.single-task-grid', ['task' => $task])
                    @endforeach
                </div>

                <!-- Navigation Arrows (visible on all screen sizes) -->
                <div>
                    <button id="prevJobsBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-primary transition-colors z-10">
                        <i class="ri-arrow-left-s-line text-xl"></i>
                    </button>
                    <button id="nextJobsBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-primary transition-colors z-10">
                        <i class="ri-arrow-right-s-line text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('explore') }}" class="inline-flex items-center text-primary font-medium hover:underline">
                    <span>View All Jobses</span>
                    <div class="w-4 h-4 flex items-center justify-center ml-1">
                        <i class="ri-arrow-right-line"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>
    @endif
    <!-- Popular Platforms -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Popular Platforms</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Browse through the most in-demand platforms and find the perfect micro-job that matches your skills.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularPlatforms as $platform)
                <a href="{{ route('explore', ['selectedPlatforms' => [$platform['id']]]) }}" class="platform-card bg-white rounded-lg shadow-md p-6 text-center border border-gray-100 block">
                    <div class="w-16 h-16 flex items-center justify-center bg-{{ $platform['color'] }}-100 rounded-full mx-auto mb-4 overflow-hidden">
                        <img src="{{ $platform['image'] }}" alt="{{ $platform['name'] }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $platform['name'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $platform['jobs_count'] }} jobs available</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Platform Statistics -->
    <section class="py-16 navy-gradient text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Our Platform in Numbers</h2>
                <p class="text-blue-100 max-w-2xl mx-auto">Join thousands of freelancers and clients who trust our platform for micro-jobs.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Stat 1 -->
                <div class="text-center p-6 bg-white bg-opacity-10 rounded-lg backdrop-blur-sm">
                    <div class="w-16 h-16 flex items-center justify-center bg-white bg-opacity-20 rounded-full mx-auto mb-4">
                        <i class="ri-user-line text-2xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold mb-2 stat-counter" id="userCounter">{{ number_format($registeredUsers) }}</h3>
                    <p class="text-blue-100">Registered Users</p>
                </div>

                <!-- Stat 2 -->
                <div class="text-center p-6 bg-white bg-opacity-10 rounded-lg backdrop-blur-sm">
                    <div class="w-16 h-16 flex items-center justify-center bg-white bg-opacity-20 rounded-full mx-auto mb-4">
                        <i class="ri-check-line text-2xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold mb-2 stat-counter" id="completedCounter">{{ number_format($completedJobs) }}</h3>
                    <p class="text-blue-100">Completed Jobs</p>
                </div>

                <!-- Stat 3 -->
                <div class="text-center p-6 bg-white bg-opacity-10 rounded-lg backdrop-blur-sm">
                    <div class="w-16 h-16 flex items-center justify-center bg-white bg-opacity-20 rounded-full mx-auto mb-4">
                        <i class="ri-briefcase-4-line text-2xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold mb-2 stat-counter" id="activeCounter">{{ number_format($activeJobs) }}</h3>
                    <p class="text-blue-100">Active Jobs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">How It Works</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Getting started with our platform is easy. Follow these simple steps to find or post micro-jobs.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mx-auto mb-6 relative">
                        <i class="ri-user-add-line text-primary text-3xl"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold">1</div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Create an Account</h3>
                    <p class="text-gray-600">Sign up for free in just a few seconds. No credit card required until you're ready to post a job.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mx-auto mb-6 relative">
                        <i class="ri-search-line text-primary text-3xl"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold">2</div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Browse or Post Jobs</h3>
                    <p class="text-gray-600">Find the perfect micro-job that matches your skills or post a job to find talented freelancers.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 flex items-center justify-center bg-primary bg-opacity-10 rounded-full mx-auto mb-6 relative">
                        <i class="ri-exchange-dollar-line text-primary text-3xl"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold">3</div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Complete & Get Paid</h3>
                    <p class="text-gray-600">Work on tasks, deliver quality results, and receive payment securely through our platform.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="bg-primary text-white px-8 py-3 rounded-button font-semibold shadow-md hover:shadow-lg transition-shadow whitespace-nowrap">Get Started Now</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">What Our Users Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Hear from freelancers and clients who have found success on our platform.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20woman%20with%20brown%20hair%2C%20smiling%2C%20business%20attire%2C%20neutral%20background%2C%20high%20quality%20portrait&width=100&height=100&seq=test1&orientation=squarish" alt="User" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Rebecca Thompson</h4>
                            <p class="text-sm text-gray-500">Graphic Designer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"This platform has been a game-changer for my freelance career. I can pick up small design jobs that fit perfectly between my larger tasks, creating a steady income stream."</p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20middle-aged%20man%20with%20glasses%2C%20short%20hair%2C%20business%20casual%20attire%2C%20neutral%20background%2C%20high%20quality%20portrait&width=100&height=100&seq=test2&orientation=squarish" alt="User" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">David Chen</h4>
                            <p class="text-sm text-gray-500">Small Business Owner</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"As a small business owner, I don't always need full-time staff. This platform lets me find skilled professionals for one-off tasks without the overhead of traditional hiring."</p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20man%20with%20dark%20skin%2C%20short%20black%20hair%2C%20smiling%2C%20casual%20professional%20attire%2C%20neutral%20background%2C%20high%20quality%20portrait&width=100&height=100&seq=test3&orientation=squarish" alt="User" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Marcus Johnson</h4>
                            <p class="text-sm text-gray-500">Web Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"I started taking on micro-jobs while in college to build my portfolio. Now I have a thriving freelance business with repeat clients I met through the platform. Couldn't recommend it more!"</p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 navy-gradient">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Start Earning or Find Talent?</h2>
                <p class="text-xl text-blue-100 mb-8">Join our community of freelancers and clients today. Registration is free and takes less than a minute.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('tasks.create') }}" class="bg-white text-primary px-8 py-3 rounded-button font-semibold shadow-md hover:shadow-lg transition-shadow whitespace-nowrap">Post a Job</a>
                    <a href="{{ route('explore') }}" class="bg-secondary bg-opacity-20 text-white border border-white border-opacity-30 px-8 py-3 rounded-button font-semibold hover:bg-opacity-30 transition-colors whitespace-nowrap">Find Work</a>
                </div>
            </div>
        </div>
    </section>

</div>

@push('styles')
<style>
    .navy-gradient {
        background: linear-gradient(135deg, #0f2447 0%, #0d47a1 100%);
    }
    
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
    
    /* Hide scrollbar for the job carousel */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;  /* Chrome, Safari, Opera */
    }
</style>
@endpush
