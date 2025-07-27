<main class="container mx-auto px-4 py-6">
    @if ($taskWorker && $taskWorker->task)
    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <!-- Task Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-2 sm:mb-0">{{ $taskWorker->task->title }}</h1>
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap">
                {{ $taskWorker->task->user->country->currency_symbol ?? '$' }}{{ number_format($taskWorker->task->budget_per_person, 2) }}
            </span>
        </div>

        <!-- Task Meta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-2 gap-x-4 text-gray-600 text-sm mb-6">
            <span class="flex items-center gap-1">
                <i class="ri-building-line"></i>
                <span>{{ $taskWorker->task->user->username }}</span>
            </span>
            <span class="flex items-center gap-1">
                <i class="ri-task-line"></i>
                <span>{{ $taskWorker->task->template->name ?? 'N/A' }}</span>
            </span>
            <span class="flex items-center gap-1">
                <i class="ri-time-line"></i>
                <span>{{ $requiredTime }} estimated time</span>
            </span>
            <span class="flex items-center gap-1">
                <i class="ri-folders-line"></i>
                <span>Platform: {{ $taskWorker->task->platform->name ?? 'N/A' }}</span>
            </span>
            @php
                $acceptedWorkersCount = $taskWorker->task->workers->whereNotNull('accepted_at')->count();
                $peopleRemaining = $taskWorker->task->number_of_people - $acceptedWorkersCount;
            @endphp
            <span class="flex items-center gap-1">
                <i class="ri-user-line"></i>
                <span>People Remaining: {{ $peopleRemaining > 0 ? $peopleRemaining : 'None' }}</span>
            </span>
        </div>

        

        <!-- Job Description -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Job Description</h3>
            <div class="text-gray-600 whitespace-pre-line">{{ $taskWorker->task->description }}</div>
        </div>

        <!-- Files -->
        @if (!empty($taskWorker->task->files) && count($taskWorker->task->files) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Attached Files</h3>
            <div class="space-y-2">
                
            </div>
        </div>
        @endif

        <!-- Requirements -->
        @if (!empty($taskWorker->task->requirements) && count($taskWorker->task->requirements) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Additional Requirements</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1">
                @foreach($taskWorker->task->requirements as $requirement)
                    <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Submission Fields -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Submission Requirements</h3>
            @if (!empty($submissionFields))
                <form wire:submit="submitTask" class="grid grid-cols-3 gap-4">
                    @foreach($submissionFields as $index => $field)
                    <div class="mb-4">
                        <label for="submission-field-{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $field['title'] }}</label>
                        
                        @if ($field['type'] === 'text')
                            <input type="text" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'textarea')
                            <textarea id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror"></textarea>
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'number')
                            <input type="number" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'email')
                            <input type="email" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'url')
                            <input type="url" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'date')
                            <input type="date" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'time')
                            <input type="time" id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'select')
                            <select id="submission-field-{{ $index }}" wire:model="submittedData.{{ $field['name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('submittedData.' . $field['name']) border-red-500 @enderror">
                                <option value="">Select {{ $field['title'] }}</option>
                                @foreach($field['options'] ?? [] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'checkbox')
                            <div class="mt-1">
                                @foreach($field['options'] ?? [] as $option)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="submission-field-{{ $index }}-{{ Str::slug($option) }}" 
                                               wire:model="submittedData.{{ $field['name'] }}" 
                                               value="{{ $option }}"
                                               class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary @error('submittedData.' . $field['name']) border-red-500 @enderror">
                                        <label for="submission-field-{{ $index }}-{{ Str::slug($option) }}" class="ml-2 block text-sm text-gray-900">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'radio')
                            <div class="mt-1">
                                @foreach($field['options'] ?? [] as $option)
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               id="submission-field-{{ $index }}-{{ Str::slug($option) }}" 
                                               wire:model="submittedData.{{ $field['name'] }}" 
                                               value="{{ $option }}"
                                               class="h-4 w-4 border-gray-300 text-primary focus:ring-primary @error('submittedData.' . $field['name']) border-red-500 @enderror">
                                        <label for="submission-field-{{ $index }}-{{ Str::slug($option) }}" class="ml-2 block text-sm text-gray-900">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @elseif ($field['type'] === 'file')
                            @if(isset($existingSubmissions[$field['name']]))
                                <div class="mb-2">
                                    <a href="{{ asset($existingSubmissions[$field['name']]) }}" target="_blank" class="text-primary hover:underline">
                                        <i class="ri-file-line mr-1"></i>View Current File
                                    </a>
                                </div>
                            @endif
                            <input type="file" 
                                   id="submission-field-{{ $index }}" 
                                   wire:model.live="submittedData.{{ $field['name'] }}" 
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 @error('submittedData.' . $field['name']) border-red-500 @enderror">
                            @error('submittedData.' . $field['name']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @endif
                        @if (isset($field['description']))
                            <p class="mt-2 text-sm text-gray-500">{{ $field['description'] }}</p>
                        @endif
                    </div>
                    @endforeach
                    <div class="col-span-3">
                        <button type="submit" class="w-full bg-primary text-white py-3 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                            Submit Task
                        </button>
                    </div>
                </form>
            @else
                <p class="text-gray-600">No specific submission requirements provided for this task template.</p>
            @endif
        </div>

        <!-- Invite People to do task -->
        @if ($peopleRemaining > 0)
        <div class="mb-6 p-4 bg-yellow-50 rounded-lg text-center">
            <h3 class="font-semibold text-yellow-800 mb-2">Want to help others earn?</h3>
            <p class="text-yellow-700 mb-4">There are still {{ $peopleRemaining }} spots left for this task. Share it with your friends and earn a commission when they complete it!</p>
            <button wire:click="openInviteModal" class="bg-yellow-600 text-white px-4 py-2 rounded-button hover:bg-yellow-700 whitespace-nowrap">
                <i class="ri-share-line mr-2"></i> Invite People to do Task
            </button>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            @if ($taskWorker->submitted_at)
                <button wire:click="editSubmission" class="flex-1 bg-blue-500 text-white py-3 px-4 rounded-button hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="ri-edit-line mr-2"></i> Edit Submission
                </button>
                <button wire:click="messageTaskMaster" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-button hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors">
                    <i class="ri-message-line mr-2"></i> Message Task Master
                </button>
                <button wire:click="raiseDispute" class="flex-1 bg-red-500 text-white py-3 px-4 rounded-button hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <i class="ri-alert-line mr-2"></i> Raise Dispute
                </button>
            @elseif ($taskWorker->completed_at)
                <button wire:click="reviewTask" class="w-full bg-green-500 text-white py-3 px-4 rounded-button hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <i class="ri-star-line mr-2"></i> Review Task
                </button>
            @endif
        </div>

        @if (session()->has('message'))
            <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

    </div>
    @else
    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Task Not Found or Accessible</h2>
        <p class="text-gray-600">The task you are trying to view does not exist or you do not have permission to view it.</p>
        <a href="{{ route('tasks.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            Go to My Tasks
        </a>
    </div>
    @endif

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
                                Invite People to do Task
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="inviteEmail" class="block text-sm font-medium text-gray-700">Email Addresses</label>
                                    <textarea id="inviteEmail" wire:model.live="inviteEmail" rows="3" placeholder="Enter one or more emails, separated by commas or new lines" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
                                    @error('inviteEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @if($inviteSummary)
                                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 rounded p-2">
                                            {{ $inviteSummary }}
                                        </div>
                                    @endif
                                </div>
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
</main>
