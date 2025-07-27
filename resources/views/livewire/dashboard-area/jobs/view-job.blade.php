<main class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h1>
                <p class="text-gray-600 mt-1">Posted {{ $task->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if(!$task->is_active)
                    <span class="badge badge-secondary">Draft</span>
                @elseif($task->workers->count() >= $task->number_of_people)
                    <span class="badge badge-warning">Completed</span>
                @elseif($task->workers->count() > 0)
                    <span class="badge badge-info">In Progress</span>
                @else
                    <span class="badge badge-success">Active</span>
                @endif
                <a href="{{ route('jobs.edit', $task) }}" class="btn btn-secondary">
                    <i class="ri-edit-line mr-1"></i> Edit Job
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Job Details -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Job Details</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-1 text-gray-900">{{ $task->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Budget per Person</h3>
                            <p class="mt-1 text-gray-900">{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Total Budget</h3>
                            <p class="mt-1 text-gray-900">{{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person * $task->number_of_people, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Expected Completion Time</h3>
                            <p class="mt-1 text-gray-900">{{ $task->expected_completion_minutes }} minutes</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Number of People Required</h3>
                            <p class="mt-1 text-gray-900">{{ $task->number_of_people }}</p>
                        </div>
                    </div>

                    @if($task->files)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Attached Files</h3>
                            <div class="mt-2 space-y-2">
                                @foreach($task->files as $file)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 flex items-center justify-center bg-primary/10 rounded-lg mr-3">
                                                @if(str_starts_with($file['mime_type'], 'image/'))
                                                    <i class="ri-image-line text-primary"></i>
                                                @elseif(str_starts_with($file['mime_type'], 'application/pdf'))
                                                    <i class="ri-file-pdf-line text-primary"></i>
                                                @elseif(str_starts_with($file['mime_type'], 'application/msword') || str_starts_with($file['mime_type'], 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
                                                    <i class="ri-file-word-line text-primary"></i>
                                                @elseif(str_starts_with($file['mime_type'], 'application/vnd.ms-excel') || str_starts_with($file['mime_type'], 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
                                                    <i class="ri-file-excel-line text-primary"></i>
                                                @else
                                                    <i class="ri-file-line text-primary"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ asset($file['path']) }}" target="_blank" class="text-primary hover:text-primary/80 font-medium">
                                                    {{ $file['name'] }}
                                                </a>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ number_format($file['size'] / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset($file['path']) }}" target="_blank" class="text-gray-400 hover:text-gray-600">
                                            <i class="ri-download-line"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($task->requirements)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Requirements</h3>
                            <div class="mt-2 prose prose-sm max-w-none">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($task->requirements as $requirement)
                                        <li>{{ $requirement }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Monitoring Settings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Monitoring Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Monitoring Type</h3>
                        <p class="mt-1 text-gray-900">{{ ucfirst($task->monitoring_type) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Monitoring Frequency</h3>
                        <p class="mt-1 text-gray-900">{{ ucfirst($task->monitoring_frequency) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Restricted Countries</h3>
                        <p class="mt-1 text-gray-900">
                            @if($task->restricted_countries)
                                {{ implode(', ', $task->restricted_countries) }}
                            @else
                                No restrictions
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Visibility</h3>
                        <p class="mt-1 text-gray-900">{{ $task->is_private ? 'Private' : 'Public' }}</p>
                    </div>
                </div>
            </div>

            <!-- Promotions -->
            @if($task->promotions->isNotEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Active Promotions</h2>
                    <div class="space-y-4">
                        @foreach($task->promotions as $promotion)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $promotion->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ $promotion->description }}</p>
                                    </div>
                                    <span class="badge badge-primary">{{ $promotion->type }}</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Expires: {{ $promotion->expires_at->format('M d, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Stats Overview -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Current Workers</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['total_workers'] }}/{{ $task->number_of_people }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Submissions</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['submissions'] }}/{{ $stats['total_workers'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Completed</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['completed'] }}/{{ $stats['total_workers'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Amount Disbursed</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ $task->user->country->currency_symbol }}{{ number_format($stats['amount_disbursed'], 2) }}
                            <span class="text-sm text-gray-500">/ {{ $task->user->country->currency_symbol }}{{ number_format($stats['total_budget'], 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Invite Workers -->
            @if($task->visibility)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Invite Workers</h2>
                    <button wire:click="openInviteModal" class="btn btn-primary w-full">
                        <i class="ri-user-add-line mr-2"></i> Invite Worker
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Workers Table -->
    <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Workers</h2>
            <div class="w-full md:w-64">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search workers..." 
                           class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Worker</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submission</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($workers as $worker)
                        <tr wire:key="{{$worker->id}}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $worker->user->image }}" alt="{{ $worker->user->username }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $worker->user->username }}</div>
                                        <div class="text-sm text-gray-500">{{ $worker->user->country->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $worker->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($worker->completed_at)
                                    <span class="badge badge-success">Completed</span>
                                @elseif($worker->submitted_at)
                                    <span class="badge badge-warning">Submitted</span>
                                @else
                                    <span class="badge badge-info">In Progress</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($worker->submitted_at)
                                    <button wire:click="viewSubmission({{ $worker->id }})" class="text-primary hover:text-primary/80">
                                        <i class="ri-eye-line mr-1"></i> View Submission
                                    </button>
                                @else
                                    <span class="text-gray-500">No submission yet</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($worker->paid_at)
                                    <span class="text-green-600">
                                        <i class="ri-check-line mr-1"></i> Paid
                                    </span>
                                @elseif($worker->submitted_at)
                                    <button wire:click="confirmDisburse({{ $worker->id }})" class="text-primary hover:text-primary/80">
                                        <i class="ri-money-dollar-circle-line mr-1"></i> Disburse
                                    </button>
                                @else
                                    <span class="text-gray-500">Not eligible</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewWorkerDetails({{ $worker->id }})" class="text-gray-600 hover:text-gray-900">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No workers found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $workers->links() }}
        </div>
    </div>

    <!-- Invite Modal -->
    <div x-data="{ show: @entangle('showInviteModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Invite Worker
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="inviteEmail" class="block text-sm font-medium text-gray-700">Email Addresses</label>
                                    <textarea id="inviteEmail" wire:model="inviteEmail" rows="3" placeholder="Enter one or more emails, separated by commas or new lines" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
                                    @error('inviteEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @if($inviteSummary)
                                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 rounded p-2">
                                            {{ $inviteSummary }}
                                        </div>
                                    @endif
                                </div>
                                {{-- <div>
                                    <label for="inviteMessage" class="block text-sm font-medium text-gray-700">Message</label>
                                    <textarea id="inviteMessage" wire:model="inviteMessage" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
                                    @error('inviteMessage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="inviteUser" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Send Invitation
                    </button>
                    <button type="button" wire:click="closeInviteModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disburse Confirmation Modal -->
    <div x-data="{ show: @entangle('showDisburseConfirmModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="ri-money-dollar-circle-line text-primary text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirm Payment Disbursement
                            </h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to disburse payment of {{ $task->user->country->currency_symbol }}{{ number_format($task->budget_per_person, 2) }} to {{ $selectedWorker->user->username ?? '' }}?
                                </p>
                                <p class="mt-2 text-sm text-gray-500">
                                    This action will create a settlement record and mark the task as paid for this worker.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="disbursePayment({{ $selectedWorker->id ?? '' }})" class="btn btn-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Disburse Payment
                    </button>
                    <button type="button" wire:click="closeDisburseConfirmModal" class="btn btn-secondary mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Modal -->
    <div x-data="{ show: @entangle('showSubmissionModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    @if($selectedWorker)
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <img class="h-12 w-12 rounded-full" src="{{ $selectedWorker->user->profile_photo_url }}" alt="{{ $selectedWorker->user->username }}">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $selectedWorker->user->username }}</h3>
                                    <p class="text-sm text-gray-500">Submitted {{ $selectedWorker->submitted_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Accepted At</h4>
                                        <p class="mt-1 text-gray-900">{{ $selectedWorker->accepted_at ? $selectedWorker->accepted_at->format('M d, Y H:i') : 'Not accepted yet' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Submitted At</h4>
                                        <p class="mt-1 text-gray-900">{{ $selectedWorker->submitted_at ? $selectedWorker->submitted_at->format('M d, Y H:i') : 'Not submitted yet' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Submission Data</h3>
                                <div class="space-y-6">
                                    @foreach($selectedWorker->submissions as $field => $value)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700">{{ ucfirst($field) }}</h4>
                                            @if(is_array($value))
                                                <div class="mt-2">
                                                    @foreach($value as $item)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 mr-2 mb-2">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @elseif(str_starts_with($value, 'storage/'))
                                                <a href="{{ Storage::url(str_replace('storage/', '', $value)) }}" target="_blank" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary bg-primary/10 hover:bg-primary/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    <i class="ri-file-line mr-2"></i>
                                                    View File
                                                </a>
                                            @else
                                                <p class="mt-2 text-gray-900 bg-gray-50 rounded-md p-3">{{ $value }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(!$selectedWorker->paid_at)
                                <div class="border-t border-gray-200 pt-4">
                                    <button wire:click="confirmDisburse({{ $selectedWorker->id }})" class="btn btn-primary w-full">
                                        <i class="ri-money-dollar-circle-line mr-2"></i> Disburse Payment
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeSubmissionModal" class="btn btn-secondary sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Worker Details Modal -->
    <div x-data="{ show: @entangle('showWorkerDetailsModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    @if($selectedWorker)
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full" src="{{ $selectedWorker->user->profile_photo_url }}" alt="{{ $selectedWorker->user->username }}">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $selectedWorker->user->username }}</h3>
                                    <p class="text-sm text-gray-500">{{ $selectedWorker->user->country->name }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Joined</h4>
                                        <p class="mt-1 text-gray-900">{{ $selectedWorker->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                        <p class="mt-1">
                                            @if($selectedWorker->completed_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="ri-check-line mr-1"></i> Completed
                                                </span>
                                            @elseif($selectedWorker->submitted_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="ri-time-line mr-1"></i> Submitted
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="ri-loader-4-line mr-1"></i> In Progress
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Accepted At</h4>
                                        <p class="mt-1 text-gray-900">{{ $selectedWorker->accepted_at ? $selectedWorker->accepted_at->format('M d, Y H:i') : 'Not accepted yet' }}</p>
                                    </div>
                                    @if($selectedWorker->submitted_at)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Submitted At</h4>
                                            <p class="mt-1 text-gray-900">{{ $selectedWorker->submitted_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    @endif
                                    @if($selectedWorker->paid_at)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Paid At</h4>
                                            <p class="mt-1 text-gray-900">{{ $selectedWorker->paid_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($selectedWorker->submitted_at && !$selectedWorker->paid_at)
                                <div class="border-t border-gray-200 pt-4">
                                    <button wire:click="confirmDisburse({{ $selectedWorker->id }})" class="btn btn-primary w-full">
                                        <i class="ri-money-dollar-circle-line mr-2"></i> Disburse Payment
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeWorkerDetailsModal" class="btn btn-secondary sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
