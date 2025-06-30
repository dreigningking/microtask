<main class="container mx-auto px-4 py-6">
    <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">My Jobs</h1>
            <a href="{{ route('post_job') }}" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90 flex items-center">
                <i class="ri-add-line mr-1"></i>
                <span>Post New Job</span>
            </a>
        </div>
        <p class="text-gray-600">Manage all your posted jobs in one place</p>
    </div>

    <!-- Filtering and Status Tabs -->
    <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
        <div class="flex flex-col md:flex-row justify-between mb-6">
            <!-- Status Tabs -->
            <div class="flex overflow-x-auto space-x-2 mb-4 md:mb-0">
                <button wire:click="$set('status', 'all')" 
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'all' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    All Jobs ({{ $stats['total'] }})
                </button>
                <button wire:click="$set('status', 'active')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'active' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Active ({{ $stats['active'] }})
                </button>
                <button wire:click="$set('status', 'in_progress')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'in_progress' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    In Progress ({{ $stats['in_progress'] }})
                </button>
                <button wire:click="$set('status', 'completed')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'completed' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Completed ({{ $stats['completed'] }})
                </button>
                <button wire:click="$set('status', 'drafts')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'drafts' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Drafts ({{ $stats['drafts'] }})
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search jobs..." 
                           class="w-full md:w-64 px-4 py-2 pr-10 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jobs Cards (Mobile) / Table (Desktop) -->
        <div class="block md:hidden">
            <!-- Mobile Cards View -->
            <div class="space-y-4">
                @forelse($jobs as $job)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $job->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $job->platform->name }}</p>
                            </div>
                            <div class="ml-2">
                                @if(!$job->is_active)
                                    <span class="badge badge-secondary">Draft</span>
                                @elseif($job->workers->count() >= $job->number_of_people)
                                    <span class="badge badge-warning">Completed</span>
                                @elseif($job->workers->count() > 0)
                                    <span class="badge badge-info">In Progress</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <span class="text-gray-500">Budget:</span>
                                <span class="font-medium text-gray-900">{{ $job->user->country->currency_symbol }}{{ number_format($job->expected_budget, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Workers:</span>
                                <span class="font-medium text-gray-900">{{ $job->workers->count() }}/{{ $job->number_of_people }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Submissions:</span>
                                <span class="font-medium text-gray-900">{{ $job->workers->whereNotNull('submitted_at')->count() }}/{{ $job->workers->count() }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Posted:</span>
                                <span class="font-medium text-gray-900">{{ $job->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('my_jobs.view', $job) }}" class="flex-1 text-center bg-primary text-white px-3 py-2 rounded-button hover:bg-primary/90 text-sm">
                                <i class="ri-eye-line mr-1"></i> View
                            </a>
                            @if($job->can_be_edited !== 'none')
                                <a href="{{ route('my_jobs.edit', $job) }}" class="flex-1 text-center bg-gray-100 text-gray-700 px-3 py-2 rounded-button hover:bg-gray-200 text-sm">
                                    <i class="ri-edit-line mr-1"></i> Edit
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-briefcase-4-line text-4xl mb-2"></i>
                        <p>No jobs found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workers</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submissions</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $job->platform->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $job->user->country->currency_symbol }}{{ number_format($job->expected_budget, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $job->workers->count() }}/{{ $job->number_of_people }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $job->workers->whereNotNull('submitted_at')->count() }}/{{ $job->workers->count() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!$job->is_active)
                                    <span class="badge badge-secondary">Draft</span>
                                @elseif($job->workers->count() >= $job->number_of_people)
                                    <span class="badge badge-warning">Completed</span>
                                @elseif($job->workers->count() > 0)
                                    <span class="badge badge-info">In Progress</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('my_jobs.view', $job) }}" class="text-white bg-primary hover:bg-primary/90 px-3 py-1 rounded-button mr-2 inline-flex items-center">
                                    <i class="ri-eye-line mr-1"></i>
                                    <span>View</span>
                                </a>
                                @if($job->can_be_edited !== 'none')
                                    <a href="{{ route('my_jobs.edit', $job) }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-button inline-flex items-center">
                                        <i class="ri-edit-line mr-1"></i>
                                        <span>Edit</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No jobs found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">{{ $jobs->firstItem() }}</span> to <span class="font-medium">{{ $jobs->lastItem() }}</span> of <span class="font-medium">{{ $jobs->total() }}</span> results
            </div>
            <div class="flex space-x-1">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Jobs</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="ri-briefcase-4-line text-primary"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Active Jobs</h3>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="ri-check-double-line text-green-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['active'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Workers</h3>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="ri-user-3-line text-purple-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_workers'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Spent</h3>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-yellow-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['total_spent'], 2) }}</p>
        </div>
    </div>
</main>