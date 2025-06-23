<main class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <!-- Task Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 sm:mb-0">{{ $task->title }}</h1>
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-lg font-medium whitespace-nowrap">
                    {{ $task->user->country->currency_symbol ?? '$' }}{{ number_format($task->budget_per_person, 2) }}
                </span>
            </div>

            <!-- Task Meta -->
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-gray-600 text-sm mb-6 pb-6 border-b">
                <span class="flex items-center gap-2">
                    <i class="ri-building-line text-lg"></i>
                    <span>{{ $task->user->username }}</span>
                </span>
                <span class="flex items-center gap-2">
                    <i class="ri-task-line text-lg"></i>
                    <span>{{ $task->template->name ?? 'N/A' }}</span>
                </span>
                <span class="flex items-center gap-2">
                    <i class="ri-time-line text-lg"></i>
                    <span>{{ floor($task->expected_completion_minutes / 60) }} hours estimated</span>
                </span>
                <span class="flex items-center gap-2">
                    <i class="ri-folders-line text-lg"></i>
                    <span>Platform: {{ $task->platform->name ?? 'N/A' }}</span>
                </span>
            </div>

            <!-- Job Description -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Job Description</h3>
                <div class="prose max-w-none text-gray-700 whitespace-pre-line">{{ $task->description }}</div>
            </div>
            
            <!-- Requirements -->
            @if (!empty($task->requirements) && count($task->requirements) > 0)
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Requirements</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    @foreach($task->requirements as $requirement)
                        <li>{{ $requirement }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Submission Fields -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Submission Requirements</h3>
                @if($task->template && $task->template->submission_fields)
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        @foreach($task->template->submission_fields as $field)
                            <li>{{ $field['title'] }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No specific submission requirements provided.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if($hasStarted)
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="font-semibold text-green-800">You have already started this task.</p>
                        <a href="{{ route('my_tasks.view', $task) }}" class="mt-3 inline-block bg-primary text-white px-6 py-2 rounded-button hover:bg-primary/90">View My Progress</a>
                    </div>
                @else
                    <!-- Agreement Checkbox -->
                    <div class="mb-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="agreementAccepted" class="mt-1 h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm text-gray-600">
                                I agree to complete this task according to the requirements and submit my work within the estimated time frame.
                            </span>
                        </label>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        <button 
                            wire:click="startTask" 
                            class="w-full bg-primary text-white px-4 py-3 rounded-button hover:bg-primary/90 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed font-semibold"
                            @if(!$agreementAccepted) disabled @endif>
                            Start Now
                        </button>
                        @if($isSaved)
                            <button 
                                wire:click="unsaveTask" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-button text-gray-700 bg-gray-100 hover:bg-gray-200 whitespace-nowrap font-semibold">
                                <i class="ri-bookmark-fill"></i>
                                <span>Unsave Task</span>
                            </button>
                        @else
                            <button 
                                wire:click="saveTask" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 whitespace-nowrap font-semibold">
                                <i class="ri-bookmark-line"></i>
                                <span>Save for Later</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Task Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">People Enrolled:</span>
                        <span class="font-medium text-gray-800">{{ $task->workers->whereNotNull('accepted_at')->count() }} / {{ $task->number_of_people }}</span>
                    </div>
                    @if($task->expiry_date)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Expires:</span>
                        <span class="font-medium text-gray-800">{{ $task->expiry_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">About the Client</h3>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="ri-building-line text-2xl text-gray-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg">{{ $task->user->name }}</h4>
                        <div class="text-sm text-gray-500">
                            Member since {{ $task->user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 