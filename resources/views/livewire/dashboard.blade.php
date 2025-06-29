<main class="container mx-auto px-4 py-6">
    <!-- Dashboard Header -->
    <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
        <div class="md:flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <div class="text-sm text-gray-600">Welcome back, <span class="font-semibold">{{ $userData->name }}</span></div>
        </div>
    </div>

    <!-- Role Toggle -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <div class="flex justify-center">
            <div class="inline-flex rounded-md shadow-sm bg-gray-100 p-1" role="group">
                <button wire:click="switchView('tasks')" type="button" class="px-6 py-2 rounded-md text-sm font-medium {{ $activeView === 'tasks' ? 'bg-primary text-white shadow-sm' : 'text-gray-700 hover:bg-gray-200' }}">
                    <i class="ri-task-line mr-2"></i>My Work (Tasks)
                </button>
                <button wire:click="switchView('jobs')" type="button" class="px-6 py-2 rounded-md text-sm font-medium {{ $activeView === 'jobs' ? 'bg-primary text-white shadow-sm' : 'text-gray-700 hover:bg-gray-200' }}">
                    <i class="ri-briefcase-line mr-2"></i>My Business (Jobs)
                </button>
            </div>
        </div>
    </div>

    <!-- Subscription Info (Worker) -->
    @if($activeView === 'tasks')
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 border-l-4 border-blue-500">
        <div class="md:flex justify-between items-center">
            @if ($workerSubscription)
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Current Plan: <span class="text-blue-600">{{ $workerSubscription->plan->name }}</span></h2>
                    <p class="text-sm text-gray-500">Expires on: {{ \Carbon\Carbon::parse($workerSubscription->expires_at)->format('F d, Y') }}</p>
                </div>
                @if($workerUpgradeSuggestion)
                <div class="text-md-right mt-3 md:mt-0">
                    <a href="{{ route('subscriptions') }}" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90">Upgrade to {{ $workerUpgradeSuggestion->name }}</a>
                </div>
                @endif
            @else
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">No Active Worker Subscription</h2>
                    <p class="text-sm text-gray-500">Choose a plan to start working on tasks.</p>
                </div>
                @if($workerUpgradeSuggestion)
                <div class="text-right mt-3 md:mt-0">
                    <a href="{{ route('subscriptions') }}" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90">Get {{ $workerUpgradeSuggestion->name }} Plan</a>
                </div>
                @endif
            @endif
        </div>
    </div>
    @endif

    @if($workerPendingSubscription)
    <div class="bg-yellow-50 p-4 rounded-lg shadow-sm mb-6 border-l-4 border-yellow-400">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="ri-time-line text-yellow-500 text-2xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Pending Subscription</h3>
                <div class="text-sm text-yellow-700 mt-1">
                    Your <strong>{{ $workerPendingSubscription->plan->name }}</strong> plan will become active on {{ \Carbon\Carbon::parse($workerPendingSubscription->starts_at)->format('F d, Y') }}.
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Subscription Info (Task Master) -->
    @if($activeView === 'jobs')
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 border-l-4 border-green-500">
        <div class="md:flex justify-between items-center">
            @if ($taskmasterSubscription)
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Current Plan: <span class="text-green-600">{{ $taskmasterSubscription->plan->name }}</span></h2>
                    <p class="text-sm text-gray-500">Expires on: {{ \Carbon\Carbon::parse($taskmasterSubscription->expires_at)->format('F d, Y') }}</p>
                </div>
                @if($taskmasterUpgradeSuggestion)
                <div class="text-md-right mt-3 md:mt-0">
                    <a href="{{ route('subscriptions') }}" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90">Upgrade to {{ $taskmasterUpgradeSuggestion->name }}</a>
                </div>
                @endif
            @else
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">No Active Taskmaster Subscription</h2>
                    <p class="text-sm text-gray-500">Choose a plan to start posting jobs.</p>
                </div>
                @if($taskmasterUpgradeSuggestion)
                <div class="text-md-right mt-3 md:mt-0">
                    <a href="{{ route('subscriptions') }}" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90">Get {{ $taskmasterUpgradeSuggestion->name }} Plan</a>
                </div>
                @endif
            @endif
        </div>
    </div>
    @endif

    @if($taskmasterPendingSubscription)
    <div class="bg-yellow-50 p-4 rounded-lg shadow-sm mb-6 border-l-4 border-yellow-400">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="ri-time-line text-yellow-500 text-2xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Pending Subscription</h3>
                <div class="text-sm text-yellow-700 mt-1">
                    Your <strong>{{ $taskmasterPendingSubscription->plan->name }}</strong> plan will become active on {{ \Carbon\Carbon::parse($taskmasterPendingSubscription->starts_at)->format('F d, Y') }}.
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tasks View -->
    <div class="{{ $activeView === 'tasks' ? 'block' : 'hidden' }}">
        <!-- Task Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Earnings -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Earnings</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $userData->country->currency_symbol }}{{ number_format($earnings, 2) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-green-600 flex items-center">
                        <i class="ri-arrow-up-line mr-1"></i>
                        12.5%
                    </span>
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Completed Tasks</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $completedTasks->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="ri-task-line text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-green-600 flex items-center">
                        <i class="ri-arrow-up-line mr-1"></i>
                        8.2%
                    </span>
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Ongoing Tasks -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Ongoing Tasks</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $ongoingTasks->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="ri-time-line text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-yellow-600 flex items-center">
                        <i class="ri-time-line mr-1"></i>
                        {{ $ongoingTasks->filter(function($task) { 
                            return $task->task->expected_completion_minutes < 180; 
                        })->count() }} due soon
                    </span>
                </div>
            </div>

            <!-- Saved Tasks -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Saved Tasks</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $savedTasks->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="ri-bookmark-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <a href="{{route('my_tasks')}}?status=saved" class="text-primary flex items-center">
                        <span>View all</span>
                        <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Task Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Task Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Saved Tasks -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-blue-500">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Saved Tasks</h2>
                        <a href="#" class="text-primary text-sm flex items-center">
                            Find more tasks
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                    
                    <!-- Task List -->
                    <div class="space-y-4">
                        @forelse($savedTasks as $taskWorker)
                        <div class="border-b border-gray-100 pb-4 mb-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-800">{{ $taskWorker->task->title }}</h3>
                                <div class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">{{ $userData->country->currency_symbol }}{{ $taskWorker->task->budget_per_person }}</div>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                <span class="flex items-center gap-1">
                                    <i class="ri-building-line"></i>
                                    <span>{{ optional($taskWorker->task->user)->name ?? 'Anonymous' }}</span>
                                </span>
                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                <span class="flex items-center gap-1">
                                    <i class="ri-time-line"></i>
                                    <span>Posted {{ $taskWorker->task->created_at->diffForHumans() }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ optional($taskWorker->task->platform)->name ?? 'General' }}</span>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">{{ $taskWorker->task->expected_completion_minutes }} mins</span>
                            </div>
                            <div class="mt-2">
                                <button class="text-sm bg-primary text-white px-3 py-1 rounded-full hover:bg-primary/90">Apply Now</button>
                                <button class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded-full hover:bg-red-200 ml-2">
                                    <i class="ri-delete-bin-line"></i> Unsave
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>No saved tasks found. Browse jobs and save the ones you're interested in!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- My Ongoing Tasks -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-yellow-500">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">My Ongoing Tasks</h2>
                        <a href="{{route('my_tasks')}}?status=accepted" class="text-primary text-sm flex items-center">
                            View all
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                    
                    <!-- Task List -->
                    <div class="space-y-4">
                        @forelse($ongoingTasks as $taskWorker)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-2 h-10 bg-{{ $taskWorker->task->expected_completion_minutes < 180 ? 'red' : ($taskWorker->task->expected_completion_minutes < 300 ? 'yellow' : 'green') }}-400 rounded-l-full mr-4"></div>
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $taskWorker->task->title }}</h3>
                                    <div class="text-sm text-gray-600 {{ $taskWorker->task->expected_completion_minutes < 180 ? 'flex items-center' : '' }}">
                                        @if($taskWorker->task->expected_completion_minutes < 180)
                                            <i class="ri-alarm-warning-line text-red-500 mr-1"></i>
                                        @endif
                                        Accepted {{ $taskWorker->accepted_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                    $timeElapsed = now()->diffInMinutes($taskWorker->accepted_at);
                                    $totalTime = $taskWorker->task->expected_completion_minutes;
                                    $completionPercentage = min(95, round(($timeElapsed / $totalTime) * 100));
                                @endphp
                                <div class="text-xs bg-{{ $completionPercentage < 50 ? 'red' : ($completionPercentage < 80 ? 'yellow' : 'green') }}-100 text-{{ $completionPercentage < 50 ? 'red' : ($completionPercentage < 80 ? 'yellow' : 'green') }}-800 px-2 py-1 rounded-full">{{ $completionPercentage }}% Complete</div>
                                <button class="text-gray-500 hover:text-gray-700">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>You don't have any ongoing tasks.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Recently Completed Tasks -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-green-500">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Recently Completed Tasks</h2>
                        <a href="{{route('my_tasks')}}?status=completed" class="text-primary text-sm flex items-center">
                            View all
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($completedTasks as $taskWorker)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="ri-file-text-line text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $taskWorker->task->title }}</h3>
                                    <div class="text-xs text-gray-500">Submitted {{ $taskWorker->submitted_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="font-medium text-green-600">+{{ $userData->country->currency_symbol }}{{ $taskWorker->task->budget_per_person }}</div>
                                <div class="text-xs text-gray-500 text-right">
                                    @if($taskWorker->paid_at)
                                        <span class="text-green-600">Paid {{ $taskWorker->paid_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-yellow-600">Pending Payment</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>You haven't completed any tasks yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Task Sidebar -->
            <div class="space-y-6">
                <!-- Earnings Summary -->
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Earnings Summary</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($earningsSummary as $earning)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-{{ $earning->icon_color }}-100 flex items-center justify-center mr-3">
                                    <i class="{{ $earning->icon }} text-{{ $earning->icon_color }}-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $earning->description }}</h3>
                                    <div class="text-xs text-gray-500">{{ $earning->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="font-medium text-green-600">+{{ $userData->country->currency_symbol }}{{ $earning->amount }}</div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>No recent earnings.</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="#" class="text-primary text-sm flex items-center justify-center">
                            View all transactions
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Referral Program -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-primary">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Refer & Earn</h2>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4 mb-5">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="ri-user-add-line text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800 mb-1">Invite people and earn rewards</h3>
                                <p class="text-gray-600 text-sm">Use the invitation system on jobs and tasks to invite others. You will earn a commission when your invitee signs up and completes their first task.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-4">
                        <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600 mb-1">{{ $userData->country->currency_symbol }}{{ number_format($referralEarnings, 2) }}</div>
                            <div class="text-gray-600 text-sm">Referral Earnings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs View -->
    <div class="{{ $activeView === 'jobs' ? 'block' : 'hidden' }}">
        <!-- Job Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Spent -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Spent</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $userData->country->currency_symbol }}{{ number_format($jobStats['total_spent'] ?? 0, 2) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-gray-500">This month</span>
                </div>
            </div>

            <!-- Active Jobs -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Active Jobs</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $jobStats['active_jobs'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ri-briefcase-line text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-gray-500">Currently running</span>
                </div>
            </div>

            <!-- Total Workers -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Workers</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $jobStats['total_applicants'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="ri-user-line text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-gray-500">Across all jobs</span>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Completion Rate</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($jobStats['completion_rate'] ?? 0, 0) }}%</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="ri-line-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <span class="text-gray-500">Of all posted jobs</span>
                </div>
            </div>
        </div>

        <!-- Job Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Job Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- My Posted Jobs -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-green-500">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">My Posted Jobs</h2>
                        <a href="{{route('post_job')}}" class="text-primary text-sm flex items-center">
                            Post a new job
                            <i class="ri-add-line ml-1"></i>
                        </a>
                    </div>
                    
                    <!-- Job List -->
                    <div class="space-y-4">
                        @forelse($postedJobs as $job)
                        <div class="border-b border-gray-100 pb-4 mb-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-800">{{ $job->title }}</h3>
                                <div class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">{{ $userData->country->currency_symbol }}{{ $job->expected_budget }}</div>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                <span class="flex items-center gap-1">
                                    <i class="ri-time-line"></i>
                                    <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                </span>
                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $job->task_workers_count ?? 0 }} Workers</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <div class="text-xs bg-{{ $job->status === 'open' ? 'yellow' : ($job->status === 'ongoing' ? 'green' : 'gray') }}-100 text-{{ $job->status === 'open' ? 'yellow' : ($job->status === 'in_progress' ? 'green' : 'gray') }}-800 px-2 py-1 rounded-full">{{ ucfirst(str_replace('_', ' ', $job->status)) }}</div>
                                <div class="space-x-2">
                                    <button class="text-sm bg-primary text-white px-3 py-1 rounded-full hover:bg-primary/90">View Details</button>
                                    <button class="text-sm bg-gray-100 text-gray-800 px-3 py-1 rounded-full hover:bg-gray-200">Edit</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>You haven't posted any jobs yet.</p>
                            <a href="{{route('post_job')}}" class="text-primary mt-2 inline-block">Post your first job</a>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Recent Submissions -->
                <div class="bg-white p-5 rounded-lg shadow-sm border-t-4 border-blue-500">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Recent Submissions</h2>
                        <a href="#" class="text-primary text-sm flex items-center">
                            View all
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                    
                    <!-- Submissions List -->
                    <div class="space-y-4">
                        @forelse($recentSubmissions as $submission)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3 overflow-hidden">
                                    <img src="{{ $submission->user->image }}" alt="{{ $submission->user->username }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $submission->user->name }}</h3>
                                    <div class="text-xs text-gray-500">Submitted for: {{ $submission->task->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Submitted {{ $submission->submitted_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="space-x-2">
                                <a href="{{route('my_jobs.view',$submission->task)}}" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full hover:bg-green-200">Review Submission</a>
                                
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">
                            <p>No submissions to review yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Job Sidebar -->
            <div class="space-y-6">
                <!-- Job Stats -->
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Job Statistics</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4 mb-5">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-xl font-bold text-gray-800">{{ number_format($jobStats['average_rating'] ?? 0, 1) }}/5</div>
                            <div class="text-sm text-gray-600">Average Rating</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-xl font-bold text-gray-800">{{ $jobStats['avg_completion_time'] ?? 0 }} days</div>
                            <div class="text-sm text-gray-600">Avg. Time to Completion</div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-800 mb-3">Monthly Jobs Posted</h3>
                        <div class="h-20 flex items-end justify-between px-2">
                            @foreach($jobStats['monthly'] ?? [] as $value)
                            <div class="w-1/12 bg-primary rounded-t" @style(["height" => $value . '%'])></div>
                            @endforeach
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 pt-2">
                            <div>Jan</div>
                            <div>Feb</div>
                            <div>Mar</div>
                            <div>Apr</div>
                            <div>May</div>
                            <div>Jun</div>
                            <div>Jul</div>
                            <div>Aug</div>
                            <div>Sep</div>
                            <div>Oct</div>
                            <div>Nov</div>
                            <div>Dec</div>
                        </div>
                    </div>
                </div>
                
                <!-- Trending Platforms -->
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold text-gray-800">Trending Platforms</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach($trendingPlatforms as $platform)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-{{ $platform['color'] }}-100 flex items-center justify-center mr-3">
                                    <i class="{{ $platform['icon'] }} text-{{ $platform['color'] }}-600"></i>
                                </div>
                                <span class="text-gray-800">{{ $platform['name'] }}</span>
                            </div>
                            <span class="text-xs bg-{{ $platform['color'] }}-100 text-{{ $platform['color'] }}-800 px-2 py-1 rounded-full">{{ $platform['count'] }} Jobs</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="#" class="text-primary text-sm flex items-center justify-center">
                            Explore all platforms
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>