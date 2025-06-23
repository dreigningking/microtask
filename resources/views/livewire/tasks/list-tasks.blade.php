<main class="container mx-auto px-4 py-6">
    <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">My Tasks</h1>
        </div>
        <p class="text-gray-600">Manage all your signed-up tasks in one place</p>
    </div>

    <!-- Filtering and Status Tabs -->
    <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
        <div class="flex flex-col md:flex-row justify-between mb-6">
            <!-- Status Tabs -->
            <div class="flex overflow-x-auto space-x-2 mb-4 md:mb-0">
                <button wire:click="$set('status', 'all')" 
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'all' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    All Tasks ({{ $stats['total'] }})
                </button>
                <button wire:click="$set('status', 'accepted')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'accepted' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Accepted ({{ $stats['accepted'] }})
                </button>
                <button wire:click="$set('status', 'saved')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'saved' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Saved ({{ $stats['saved'] }})
                </button>
                <button wire:click="$set('status', 'submitted')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'submitted' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Submitted ({{ $stats['submitted'] }})
                </button>
                <button wire:click="$set('status', 'completed')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'completed' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Completed ({{ $stats['completed'] }})
                </button>
                <button wire:click="$set('status', 'cancelled')"
                        class="tab-button whitespace-nowrap px-4 py-2 rounded-button {{ $status === 'cancelled' ? 'bg-primary text-white' : 'text-gray-600 bg-gray-100 hover:bg-gray-200' }}">
                    Cancelled ({{ $stats['cancelled'] }})
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search tasks..." 
                           class="w-full md:w-64 px-4 py-2 pr-10 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                </div>
                <select wire:model.live="sortBy" class="w-32 px-4 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                    <option value="budget_desc">Budget (High to Low)</option>
                    <option value="budget_asc">Budget (Low to High)</option>
                </select>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Signed Up Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $taskWorker)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $taskWorker->task->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $taskWorker->task->platform->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $taskWorker->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Accepted</span>
                                @elseif($taskWorker->saved_at && !$taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Saved</span>
                                @elseif($taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Submitted</span>
                                @elseif($taskWorker->completed_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @elseif($taskWorker->cancelled_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('my_tasks.view', $taskWorker->task) }}" class="text-white bg-primary hover:bg-primary/90 px-3 py-1 rounded-button mr-2 inline-flex items-center">
                                    <i class="ri-eye-line mr-1"></i>
                                    <span>View</span>
                                </a>
                                <!-- Add more actions here if needed based on taskWorker status -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No tasks found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">{{ $tasks->firstItem() }}</span> to <span class="font-medium">{{ $tasks->lastItem() }}</span> of <span class="font-medium">{{ $tasks->total() }}</span> results
            </div>
            <div class="flex space-x-1">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Tasks</h3>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="ri-briefcase-4-line text-primary"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Accepted Tasks</h3>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="ri-check-double-line text-green-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['accepted'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Completed Tasks</h3>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="ri-task-line text-purple-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
        </div>
    </div>
</main>
