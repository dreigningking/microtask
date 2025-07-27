<div class="content-wrapper">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">My Tasks</h1>
        </div>
        <div class="card-footer bg-white border-0">
            <p class="mb-0 text-muted">Manage all your signed-up tasks in one place</p>
        </div>
    </div>

    <!-- Filtering and Status Tabs -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <!-- Status Tabs -->
                <div class="col-md-8 mb-2 mb-md-0">
                    <div class="btn-group" role="group">
                        <button wire:click="$set('status', 'all')" type="button" class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            All Tasks ({{ $stats['total'] }})
                        </button>
                        <button wire:click="$set('status', 'accepted')" type="button" class="btn btn-sm {{ $status === 'accepted' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Accepted ({{ $stats['accepted'] }})
                        </button>
                        <button wire:click="$set('status', 'saved')" type="button" class="btn btn-sm {{ $status === 'saved' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Saved ({{ $stats['saved'] }})
                        </button>
                        <button wire:click="$set('status', 'submitted')" type="button" class="btn btn-sm {{ $status === 'submitted' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Submitted ({{ $stats['submitted'] }})
                        </button>
                        <button wire:click="$set('status', 'completed')" type="button" class="btn btn-sm {{ $status === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Completed ({{ $stats['completed'] }})
                        </button>
                        <button wire:click="$set('status', 'cancelled')" type="button" class="btn btn-sm {{ $status === 'cancelled' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            Cancelled ({{ $stats['cancelled'] }})
                        </button>
                    </div>
                </div>
                <!-- Search and Sort -->
                <div class="col-md-4 d-flex gap-2">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search tasks...">
                        <span class="input-group-text bg-white border-0"><i class="ri-search-line text-muted"></i></span>
                    </div>
                    <select wire:model.live="sortBy" class="form-select form-select-sm w-auto">
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="budget_desc">Budget (High to Low)</option>
                        <option value="budget_asc">Budget (Low to High)</option>
                    </select>
                </div>
            </div>

            <!-- Mobile Cards View -->
            <div class="d-md-none">
                <div class="row g-3">
                    @forelse($tasks as $taskWorker)
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">{{ $taskWorker->task->title }}</h5>
                                            <div class="text-muted small">{{ $taskWorker->task->platform->name ?? 'N/A' }}</div>
                                        </div>
                                        <div>
                                            @if($taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                                <span class="badge bg-primary">Accepted</span>
                                            @elseif($taskWorker->saved_at && !$taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                                <span class="badge bg-warning">Saved</span>
                                            @elseif($taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                                <span class="badge bg-purple">Submitted</span>
                                            @elseif($taskWorker->completed_at)
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($taskWorker->cancelled_at)
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 small"><span class="text-muted">Budget:</span> <span class="fw-semibold">{{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}</span></div>
                                        <div class="col-6 small"><span class="text-muted">Signed Up:</span> <span class="fw-semibold">{{ $taskWorker->created_at->format('M d, Y') }}</span></div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.view', $taskWorker->task) }}" class="btn btn-primary btn-sm flex-fill"><i class="ri-eye-line me-1"></i> View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-4">
                            <i class="ri-task-line display-4 mb-2"></i>
                            <p>No tasks found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="d-none d-md-block table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Task Title</th>
                            <th>Platform</th>
                            <th>Signed Up Date</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $taskWorker)
                            <tr>
                                <td>{{ $taskWorker->task->title }}</td>
                                <td>{{ $taskWorker->task->platform->name ?? 'N/A' }}</td>
                                <td>{{ $taskWorker->created_at->format('M d, Y') }}</td>
                                <td>{{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}</td>
                                <td>
                                    @if($taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                        <span class="badge bg-primary">Accepted</span>
                                    @elseif($taskWorker->saved_at && !$taskWorker->accepted_at && !$taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                        <span class="badge bg-warning">Saved</span>
                                    @elseif($taskWorker->submitted_at && !$taskWorker->completed_at && !$taskWorker->cancelled_at)
                                        <span class="badge bg-purple">Submitted</span>
                                    @elseif($taskWorker->completed_at)
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($taskWorker->cancelled_at)
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('tasks.view', $taskWorker->task) }}" class="btn btn-primary btn-sm me-1"><i class="ri-eye-line me-1"></i> View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No tasks found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing <span class="fw-semibold">{{ $tasks->firstItem() }}</span> to <span class="fw-semibold">{{ $tasks->lastItem() }}</span> of <span class="fw-semibold">{{ $tasks->total() }}</span> results
                </div>
                <div>
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Total Tasks</h6>
                        <span class="bg-primary bg-opacity-10 rounded-circle p-2"><i class="ri-briefcase-4-line text-primary"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Accepted Tasks</h6>
                        <span class="bg-success bg-opacity-10 rounded-circle p-2"><i class="ri-check-double-line text-success"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['accepted'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Completed Tasks</h6>
                        <span class="bg-purple bg-opacity-10 rounded-circle p-2"><i class="ri-task-line text-purple"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['completed'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
