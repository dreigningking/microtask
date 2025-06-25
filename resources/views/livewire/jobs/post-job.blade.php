<main class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Post a Job</h1>
        <p class="text-gray-600 mt-2">Create a job posting to find skilled professionals for your tasks. Fill in the details below.</p>
    </div>

    <!-- Progress Steps -->
    <div class="mb-10">
        <div class="flex items-center justify-between">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">1</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 1 ? 'text-primary' : 'text-gray-500' }}">Job Details</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200">
                <div class="h-full bg-primary progress-width-{{ $currentStep == 1 ? '0' : '100' }}"></div>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">2</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 2 ? 'text-primary' : 'text-gray-500' }}">Payment</span>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form wire:submit.prevent="{{ $currentStep == 1 ? 'nextStep' : 'submitJob' }}" id="post-job-form">
            <!-- Step 1: Job Details -->
            <div x-data="{ 
                showSkillSuggestions: false,
                currentSkill: '',
                handleKeydown(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        this.addSkill();
                    }
                },
                addSkill() {
                    if (this.currentSkill.trim()) {
                        @this.addSkill(this.currentSkill.trim());
                        this.currentSkill = '';
                    }
                }
            }" class="{{ $currentStep != 1 ? 'hidden' : '' }} space-y-8">
                <!-- Basic Information Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" wire:model="title" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Social Media Content Writer" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="platform_id" class="block text-sm font-medium text-gray-700 mb-1">Platform <span class="text-red-500">*</span></label>
                            <div class="relative" wire:ignore>
                                <select id="platform_id" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    <option value="" selected>Select a platform</option>
                                    @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                    @endforeach
                                </select>
                                @error('platform_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-1">Task Template</label>
                            <div class="relative" wire:ignore>
                                <select id="template_id" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    <option value="" selected>Select a template</option>
                                    @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                    @endforeach
                                </select>
                                @error('template_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Job Expiry Date</label>
                            <input type="date" id="expiry_date" wire:model="expiry_date" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" min="{{ now()->addDay()->format('Y-m-d') }}">
                            @error('expiry_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Optional. The date this job will no longer be visible to workers.</p>
                        </div>
                        <div>
                            <label for="expected_completion_minutes" class="block text-sm font-medium text-gray-700 mb-1">Expected Completion Time <span class="text-red-500">*</span></label>
                            <div class="flex items-center space-x-4">
                                <input type="number" id="expected_completion_minutes" wire:model="expected_completion_minutes" min="1" class="w-1/3 px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. 3" required>
                                <div class="relative w-2/3">
                                    <select id="time_unit" wire:model="time_unit" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                        <option value="minutes" selected>Minutes</option>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('expected_completion_minutes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Description Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Description</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Detailed Description <span class="text-red-500">*</span></label>
                            <div class="border border-gray-300 rounded-button overflow-hidden">
                                <div class="bg-gray-50 border-b border-gray-300 px-3 py-2 flex items-center space-x-2">
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-bold"></i>
                                        </div>
                                    </button>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-italic"></i>
                                        </div>
                                    </button>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-underline"></i>
                                        </div>
                                    </button>
                                    <span class="h-4 w-px bg-gray-300 mx-1"></span>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-list-unordered"></i>
                                        </div>
                                    </button>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-list-ordered"></i>
                                        </div>
                                    </button>
                                    <span class="h-4 w-px bg-gray-300 mx-1"></span>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-link"></i>
                                        </div>
                                    </button>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-image-add-line"></i>
                                        </div>
                                    </button>
                                </div>
                                <textarea id="description" wire:model="description" rows="6" class="w-full px-4 py-2 border-none focus:ring-0 outline-none" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required></textarea>
                            </div>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <div class="mt-2 text-xs text-gray-500 flex items-center">
                                <div class="w-4 h-4 flex items-center justify-center mr-1">
                                    <i class="ri-information-line"></i>
                                </div>
                                <span>Tip: Use bullet points for better readability and include examples where possible.</span>
                            </div>
                        </div>
                        
                        <!-- Template Fields Component -->
                        <livewire:jobs.template-fields />
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Attachments</label>
                            <div class="border border-dashed border-gray-300 rounded-button p-4 text-center"
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="w-10 h-10 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                                    <div class="w-6 h-6 flex items-center justify-center text-gray-500">
                                        <i class="ri-upload-2-line"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Drag and drop files here, or <label for="file-upload" class="text-primary font-medium cursor-pointer">browse</label></p>
                                <p class="text-xs text-gray-500">Maximum file size: 10MB (PDF, DOC, JPG, PNG)</p>
                                <input type="file" id="file-upload" wire:model="files" class="hidden" multiple>

                                <!-- Upload Progress Bar -->
                                <div x-show="isUploading" class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-primary h-2.5 rounded-full progress-width" x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Uploading... <span x-text="progress"></span>%</p>
                                </div>

                                <!-- Preview Uploaded Files -->
                                @if(count($files) > 0)
                                <div class="mt-3">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Uploaded Files:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($files as $index => $file)
                                        <div class="flex items-center bg-gray-100 rounded-full px-3 py-1 text-sm">
                                        <span class="truncate max-w-[150px]">{{ $file['name'] ?? 'Uploaded file' }}</span>
                                            <button type="button" wire:click="removeFile({{ $index }})" class="ml-1 text-gray-500 hover:text-red-500 focus:outline-none">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    <i class="ri-close-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if ($errors->has('files.*'))
                                @foreach ($errors->get('files.*') as $messages)
                                    @foreach ($messages as $message)
                                        <span class="text-red-500 text-sm block">{{ $message }}</span>
                                    @endforeach
                                @endforeach
                            @endif
                            @error('files.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Requirements Section -->
                <div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Requirements</h2>
                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Required Skills</label>
                                <div class="relative">
                                    <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-button min-h-[42px]" id="skillsContainer">
                                        @foreach($requirements as $index => $skill)
                                        <div class="flex items-center bg-primary/10 text-primary px-2 py-1 rounded-full text-sm">
                                            <span>{{ $skill }}</span>
                                            <button type="button" wire:click="removeSkill({{ $index }})" class="ml-1 focus:outline-none">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    <i class="ri-close-line"></i>
                                                </div>
                                            </button>
                                        </div>
                                        @endforeach
                                        <input type="text"
                                            x-model="currentSkill"
                                            x-on:keydown="handleKeydown"
                                            class="flex-grow min-w-[100px] border-none focus:ring-0 outline-none text-sm"
                                            placeholder="Type a skill and press Enter">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Add skills or qualifications required for this job (optional)</p>
                                @error('requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Visibility</h2>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Visibility <span class="text-red-500">*</span></label>
                            <div class="flex space-x-6">
                                <div class="flex items-center">
                                    <input id="public" name="visibility" type="radio" wire:model="visibility" value="public" class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                    <label for="public" class="ml-3 block text-sm font-medium text-gray-700">
                                        Public <span class="text-xs text-gray-500">(Visible to all users)</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="private" name="visibility" type="radio" wire:model="visibility" value="private" class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                    <label for="private" class="ml-3 block text-sm font-medium text-gray-700">
                                        Private <span class="text-xs text-gray-500">(Only visible to invited users)</span>
                                    </label>
                                </div>
                            </div>
                            @error('visibility') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Add Country Restrictions to Budget & Capacity Section -->
                <div class="mt-4 bg-gray-50 p-4 rounded-button border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-800 mb-2">Country Restrictions</h3>
                    <p class="text-xs text-gray-500 mb-3">Optionally, you can restrict workers from specific countries from applying to this job.</p>
                    
                    <div wire:ignore>
                        <select id="restricted_countries" wire:model="restricted_countries" class="form-control w-full" multiple>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Monitoring Preferences Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Monitoring Preferences</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Monitoring Type <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                                    <input type="radio" id="selfMonitored" wire:model.live="monitoring_type" value="self_monitoring" class="peer absolute opacity-0 w-0 h-0" checked>
                                    <label for="selfMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                            <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                <i class="ri-user-settings-line"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-gray-800">Self-Monitored (Free)</span>
                                        <span class="text-xs text-gray-500 text-center mt-1">You'll review and approve all work</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="adminMonitored" wire:model.live="monitoring_type" value="admin_monitoring" class="peer absolute opacity-0 w-0 h-0">
                                    <label for="adminMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                            <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                <i class="ri-admin-line"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-gray-800">Admin-Monitored ({{ $currency_symbol }}{{ number_format($countrySetting->admin_monitoring_cost ?? 0, 2) }})</span>
                                        <span class="text-xs text-gray-500 text-center mt-1">Our team will review work quality</span>
                                    </label>
                                </div>
                                @if($enable_system_monitoring)
                                <div class="relative">
                                    <input type="radio" id="systemMonitored" wire:model.live="monitoring_type" value="system_monitoring" class="peer absolute opacity-0 w-0 h-0">
                                    <label for="systemMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                            <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                <i class="ri-robot-line"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-gray-800">System-Automated ({{ $currency_symbol }}{{ number_format($countrySetting->system_monitoring_cost ?? 0, 2) }})</span>
                                        <span class="text-xs text-gray-500 text-center mt-1">Automated verification system</span>
                                    </label>
                                </div>
                                @endif
                            </div>
                            @error('monitoring_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div id="monitoringFrequencyContainer" class="bg-gray-50 p-4 rounded-button border border-gray-200" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monitoring Frequency</label>
                            <div class="flex space-x-4">
                                <div class="relative flex items-center">
                                    <input type="radio" id="daily" wire:model="monitoring_frequency" value="daily" class="w-4 h-4 text-primary focus:ring-primary border-gray-300" checked>
                                    <label for="daily" class="ml-2 text-sm text-gray-700">Daily</label>
                                </div>
                                <div class="relative flex items-center">
                                    <input type="radio" id="weekly" wire:model="monitoring_frequency" value="weekly" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                    <label for="weekly" class="ml-2 text-sm text-gray-700">Weekly</label>
                                </div>
                                <div class="relative flex items-center">
                                    <input type="radio" id="completion" wire:model="monitoring_frequency" value="completion" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                    <label for="completion" class="ml-2 text-sm text-gray-700">Upon Completion</label>
                                </div>
                                <div class="relative flex items-center">
                                    <input type="radio" id="custom" wire:model="monitoring_frequency" value="custom" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                    <label for="custom" class="ml-2 text-sm text-gray-700">Custom</label>
                                </div>
                            </div>
                            @error('monitoring_frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Combined Budget & Capacity and Promotion Options Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Budget & Promotion Options</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Budget & Capacity Column -->
                        <div class="space-y-4">
                            <!-- Budget Per Person -->
                            <div>
                                <label for="budget_per_person" class="block text-sm font-medium text-gray-700 mb-1">Budget Per Person <span class="text-red-500">*</span></label>
                                <div class="flex">
                                    <div class="flex items-center px-4 py-2 rounded-l-button border border-r-0 border-gray-300 bg-gray-50">
                                        <span class="text-gray-700">{{ $currency_symbol }}</span>
                                    </div>
                                    <input type="number" id="budget_per_person" wire:model="budget_per_person" wire:input="updateTotals" min="{{ $min_budget_per_person }}" step="0.01" class="w-40 rounded-r-button border-l-0 px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="0.00" required>
                                </div>
                                @if($min_budget_per_person > 0)
                                    <div class="text-xs text-gray-500 mt-1">Minimum allowed: {{ $currency_symbol }}{{ number_format($min_budget_per_person, 2) }} per person (based on template & country)</div>
                                @endif
                                @if($budget_per_person < $min_budget_per_person)
                                    <div class="text-xs text-red-500 mt-1">Budget per person cannot be less than the minimum allowed.</div>
                                @endif
                            </div>
                            
                            <!-- Number of People -->
                            <div>
                                <label for="number_of_people" class="block text-sm font-medium text-gray-700 mb-1">Number of People <span class="text-red-500">*</span></label>
                                <div class="flex items-center">
                                    <button type="button" wire:click="decreasePeople" class="flex items-center justify-center w-10 h-10 rounded-l-button bg-gray-100 border border-gray-300 hover:bg-gray-200">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-subtract-line"></i>
                                        </div>
                                    </button>
                                    <input type="number" id="number_of_people" wire:model="number_of_people" wire:input="updateTotals" min="1" class="w-32 px-4 py-2 border-t border-b border-gray-300 text-center focus:ring-0 focus:border-gray-300 outline-none">
                                    <button type="button" wire:click="increasePeople" class="flex items-center justify-center w-10 h-10 rounded-r-button bg-gray-100 border border-gray-300 hover:bg-gray-200">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-add-line"></i>
                                        </div>
                                    </button>
                                </div>
                                @error('number_of_people') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Promotion Options Column -->
                        <div class="space-y-4">
                            <!-- Featured Job Option - Inline Days -->
                            <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-button">
                                <div class="flex items-center min-w-[250px]">
                                    <input id="featured" type="checkbox" wire:model="featured" wire:change="updateTotals" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <div class="ml-3">
                                        <label for="featured" class="block text-sm font-medium text-gray-700">Featured Job</label>
                                        <p class="text-xs text-gray-500">Display prominently in search results</p>
                                    </div>
                                </div>
                                
                                @if($featured)
                                <div class="flex items-center gap-3 ml-auto">
                                    <div>
                                        <label for="featured_days" class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                                        <select id="featured_days" wire:model="featured_days" wire:change="updateTotals" class="w-full appearance-none px-3 py-1 text-sm pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                            <option value="1">1 Day</option>
                                            <option value="3">3 Days</option>
                                            <option value="7">7 Days</option>
                                            <option value="14">14 Days</option>
                                            <option value="30">30 Days</option>
                                        </select>
                                    </div>
                                    <div class="text-center min-w-[80px]">
                                        <span class="block text-xs text-gray-500">Cost</span>
                                        <span class="text-sm font-medium text-primary">{{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Urgent Badge Option - Remove duration dropdown, just show cost per number of people -->
                            <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-button">
                                <div class="flex items-center min-w-[250px]">
                                    <input id="urgent" type="checkbox" wire:model="urgent" wire:change="updateTotals" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <div class="ml-3">
                                        <label for="urgent" class="block text-sm font-medium text-gray-700">Urgent Badge</label>
                                        <p class="text-xs text-gray-500">Add badge to attract immediate attention</p>
                                    </div>
                                </div>
                                @if($urgent)
                                <div class="flex items-center gap-3 ml-auto">
                                    <div class="text-center min-w-[80px]">
                                        <span class="block text-xs text-gray-500">Cost</span>
                                        <span class="text-sm font-medium text-primary">{{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Combined Pricing Summary -->
                    <div class="bg-gray-50 rounded-button p-3 border border-gray-200 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Total Budget Summary -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Total Budget</h3>
                                <div class="text-xl font-semibold text-primary">
                                    {{ $currency_symbol }} {{ number_format($expected_budget, 2) }}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">For {{ $number_of_people }} {{ $number_of_people > 1 ? 'people' : 'person' }}</p>
                            </div>
                            
                            <!-- Pricing Summary -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Posting Fees</h3>
                                <div class="space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Job Budget:</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                                    </div>
                                    @if($featured)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Featured ({{ $featured_days }} days):</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}</span>
                                    </div>
                                    @endif
                                    @if($urgent)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Urgent Badge ({{ $number_of_people }} people):</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}</span>
                                    </div>
                                    @endif
                                    @if($monitoring_fee > 0)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Monitoring Fee:</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Platform Service Charge:</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-300 mt-2">
                                        <span class="text-sm font-semibold text-gray-800">Subtotal:</span>
                                        <span class="text-sm font-bold text-primary">{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Tax ({{ $tax_rate }}%):</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-300 mt-2">
                                        <span class="text-sm font-semibold text-gray-800">Total:</span>
                                        <span class="text-sm font-bold text-primary">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 2: Payment Details -->
            <div class="{{ $currentStep != 2 ? 'hidden' : '' }} space-y-8">
                <!-- Payment Summary -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Summary</h2>
                    <div class="bg-gray-50 rounded-button p-4 border border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Job Budget:</span>
                            <span>{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                        </div>
                        @if($featured)
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium">Featured Job ({{ $featured_days }} days):</span>
                            <span>{{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}</span>
                        </div>
                        @endif
                        @if($urgent)
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium">Urgent Badge ({{ $number_of_people }} people):</span>
                            <span>{{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}</span>
                        </div>
                        @endif
                        @if($monitoring_fee > 0)
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium">Monitoring Fee:</span>
                            <span>{{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium">Platform Service Charge:</span>
                            <span>{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-t border-gray-300">
                            <span class="font-medium">Subtotal:</span>
                            <span>{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium">Tax ({{ $tax_rate }}%):</span>
                            <span>{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-t border-gray-300">
                            <span class="text-lg font-bold">Total:</span>
                            <span class="text-lg font-bold text-primary">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Information</h2>
                    <div class="bg-gray-50 rounded-button p-4 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                                <div class="w-5 h-5 flex items-center justify-center text-primary">
                                    <i class="ri-secure-payment-line"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Secure Payment</h3>
                                <p class="text-sm text-gray-600">After submitting your job, you'll be redirected to our secure payment gateway.</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-2">
                            <div class="w-5 h-5 flex items-center justify-center mr-2 mt-0.5 text-primary">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <p class="text-sm text-gray-600">Your job will be published immediately after successful payment.</p>
                        </div>
                        <div class="flex items-start">
                            <div class="w-5 h-5 flex items-center justify-center mr-2 mt-0.5 text-primary">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <p class="text-sm text-gray-600">We accept credit/debit cards, PayPal, and other payment methods.</p>
                        </div>
                    </div>
                </div>

                <!-- Authentication Check -->
                @if(!$isLoggedIn)
                    <!-- Login Form (For guests) -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Login Required</h2>
                        <div class="bg-gray-50 rounded-button p-4 border border-gray-200">
                            <p class="text-sm text-gray-600 mb-4">Please login to continue with your job posting.</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="your@email.com" required>
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="remember" type="checkbox" wire:model="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Forgot password?</a>
                                </div>
                                
                                <button type="button" wire:click="login" class="w-full py-2 px-4 bg-primary text-white rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <div class="flex items-center justify-center">
                                        <span>Login</span>
                                    </div>
                                </button>
                                
                                <div class="text-center mt-4">
                                    <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-primary hover:underline">Register</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Terms & Conditions (For logged in users) -->
                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" type="checkbox" wire:model="terms" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a></label>
                                @error('terms') <span class="block text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Form Navigation Buttons -->
    <div class="flex justify-between mt-8 border-t border-gray-200 pt-6">
        <button type="button" wire:click="previousStep" class="{{ $currentStep == 1 ? 'hidden' : '' }} px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">
            <div class="flex items-center">
                <div class="w-5 h-5 flex items-center justify-center mr-1">
                    <i class="ri-arrow-left-line"></i>
                </div>
                <span>Back</span>
            </div>
        </button>
        <div class="flex space-x-4 ml-auto">
            <button type="button" wire:click="saveAsDraft" class="{{ $currentStep == 2 ? 'hidden' : '' }} px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">Save as Draft</button>
            <button type="{{ $currentStep == 1 ? 'button' : 'submit' }}" wire:click="{{ $currentStep == 1 ? 'nextStep' : 'submitJob' }}" class="px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap">
                <div class="flex items-center">
                    <span>{{ $currentStep == 1 ? 'Next Step' : ($isLoggedIn ? 'Proceed to Payment' : 'Login to Continue') }}</span>
                    <div class="w-5 h-5 flex items-center justify-center ml-1">
                        <i class="{{ $currentStep == 1 ? 'ri-arrow-right-line' : 'ri-secure-payment-line' }}"></i>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <!-- Mobile-only error display below navigation buttons -->
    @if ($errors->any())
        <div class="block md:hidden mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</main>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .progress-width-0 { width: 0%; }
    .progress-width-100 { width: 100%; }
    .progress-width { width: 0%; }
    /* Select2 Custom Styling */
    .select2-container .select2-selection--single{
        height: 40px !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        line-height: 40px !important;
    }
    .select2-container .select2-selection--single .select2-selection__arrow{
        top: 50% !important;
        transform: translateY(-50%) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder{
        line-height: 40px !important;
    }

    .select2-container--default .select2-selection--multiple {
        border-color: #e5e7eb;
        border-radius: 0.375rem;
        min-height: 42px;
        padding: 2px 8px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgba(var(--primary-rgb, 79, 70, 229), 0.1);
        border-color: rgba(var(--primary-rgb, 79, 70, 229), 0.2);
        color: var(--primary, #4F46E5);
        border-radius: 9999px;
        padding: 2px 8px;
        margin-top: 4px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: var(--primary, #4F46E5);
        margin-right: 5px;
        border:none !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script>
    // Wait for the document to be ready
    $(document).ready(function(){
        initializeSelect2();
    });
    
    function initializeSelect2() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            // Safely destroy existing Select2 instances first
            try {
                if (jQuery('#restricted_countries').hasClass('select2-hidden-accessible')) {
                    jQuery('#restricted_countries').select2('destroy');
                }
                if (jQuery('#platform_id').hasClass('select2-hidden-accessible')) {
                    jQuery('#platform_id').select2('destroy');
                }
                if (jQuery('#template_id').hasClass('select2-hidden-accessible')) {
                    jQuery('#template_id').select2('destroy');
                }
            } catch (e) {
                console.log('Select2 destroy error:', e);
            }
            
            // Initialize country restrictions select2
            if (jQuery('#restricted_countries').length) {
                jQuery('#restricted_countries').select2({
                    placeholder: "Select countries to restrict",
                    allowClear: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'restricted_countries'
                    });
                });
            }
            
            // Initialize platform select2
            if (jQuery('#platform_id').length) {
                jQuery('#platform_id').select2({
                    placeholder: "Select a platform",
                    allowClear: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'platform_id'
                    });
                });
            }
            
            // Initialize template select2
            if (jQuery('#template_id').length) {
                jQuery('#template_id').select2({
                    placeholder: "Select a template",
                    allowClear: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'template_id'
                    });
                });
            }
        }
    }
    
    // Listen for Livewire load event to reinitialize Select2 after component updates
    document.addEventListener('livewire:initialized', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
    
    // Listen for Livewire updates to reinitialize Select2
    document.addEventListener('livewire:updated', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
    
    // Listen for Livewire navigation to reinitialize Select2
    document.addEventListener('livewire:navigated', function() {
        // Small delay to ensure DOM is ready
        setTimeout(function() {
            initializeSelect2();
        }, 100);
    });
</script>
@endpush