<main class="container mx-auto px-4 py-8 max-w-6xl">
    @if($serviceUnavailable)
    <div class="max-w-3xl mx-auto mb-8">
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-6 text-center">
            <div class="flex flex-col items-center">
                <i class="ri-error-warning-line text-4xl mb-2 text-red-500"></i>
                <h2 class="text-xl font-bold mb-2">Service Unavailable</h2>
                <p class="text-base">Sorry, our job posting service is not available in {{ $unavailableCountryName ?? 'your country' }} at this time.</p>
                <p class="text-sm mt-2 text-red-600">Please check back later or contact support for more information.</p>
            </div>
        </div>
    </div>
    @else
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Job</h1>
        <p class="text-gray-600 mt-2">Update your job details and proceed to payment.</p>
    </div>

    @if($canEditNone)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-6" role="alert">
            <strong class="font-bold">This job can no longer be edited.</strong>
            <span class="block sm:inline">You cannot edit any fields because the job has been paid for and has at least one worker.</span>
        </div>
    @endif

    <form wire:submit.prevent="submitJob" class="space-y-8">
                <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" wire:model="title" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Social Media Content Writer" required @if($canEditNone) readonly disabled @endif>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                    <label for="platform_id" class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                    <input type="text" value="{{ $task->platform->name ?? 'N/A' }}" class="w-full px-4 py-2 border border-gray-300 rounded-button bg-gray-50" readonly>
                    <p class="text-xs text-gray-500 mt-1">Platform cannot be changed</p>
                        </div>
                        <div>
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-1">Task Template</label>
                    <input type="text" value="{{ $task->template->name ?? 'N/A' }}" class="w-full px-4 py-2 border border-gray-300 rounded-button bg-gray-50" readonly>
                    <p class="text-xs text-gray-500 mt-1">Template cannot be changed</p>
                        </div>
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Job Expiry Date</label>
                    <input type="date" id="expiry_date" wire:model="expiry_date" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" min="{{ now()->addDay()->format('Y-m-d') }}" @if($canEditNone) readonly disabled @endif>
                            @error('expiry_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Optional. The date this job will no longer be visible to workers.</p>
                        </div>
                        <div>
                            <label for="expected_completion_minutes" class="block text-sm font-medium text-gray-700 mb-1">Expected Completion Time <span class="text-red-500">*</span></label>
                            <div class="flex items-center space-x-4">
                        <input type="number" id="expected_completion_minutes" wire:model="expected_completion_minutes" min="1" class="w-1/3 px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. 3" required @if($canEditNone) readonly disabled @endif>
                                <div class="relative w-2/3">
                            <select id="time_unit" wire:model="time_unit" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" @if($canEditNone) disabled @endif>
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
        <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Description</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Detailed Description <span class="text-red-500">*</span></label>
                    <textarea id="description" wire:model="description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required @if($canEditNone) readonly disabled @endif></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Template Fields Component -->
                @livewire('dashboard-area.jobs.template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
                    </div>
                </div>

                <!-- Requirements Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
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
                                    @if(!$canEditNone)
                                            <button type="button" wire:click="removeSkill({{ $index }})" class="ml-1 focus:outline-none">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    <i class="ri-close-line"></i>
                                                </div>
                                            </button>
                                    @endif
                                        </div>
                                        @endforeach
                                @if(!$canEditNone)
                                        <input type="text"
                                    x-data="{ currentSkill: '' }"
                                    x-on:keydown="if (event.key === 'Enter' || event.key === ',') { event.preventDefault(); if (currentSkill.trim()) { $wire.addSkill(currentSkill.trim()); currentSkill = ''; } }"
                                            x-model="currentSkill"
                                            class="flex-grow min-w-[100px] border-none focus:ring-0 outline-none text-sm"
                                            placeholder="Type a skill and press Enter">
                                @endif
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
                            <input id="public" name="visibility" type="radio" wire:model="visibility" value="public" class="h-4 w-4 text-primary focus:ring-primary border-gray-300" @if($canEditNone) disabled @endif>
                                    <label for="public" class="ml-3 block text-sm font-medium text-gray-700">
                                        Public <span class="text-xs text-gray-500">(Visible to all users)</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                            <input id="private" name="visibility" type="radio" wire:model="visibility" value="private" class="h-4 w-4 text-primary focus:ring-primary border-gray-300" @if($canEditNone) disabled @endif>
                                    <label for="private" class="ml-3 block text-sm font-medium text-gray-700">
                                        Private <span class="text-xs text-gray-500">(Only visible to invited users)</span>
                                    </label>
                                </div>
                            </div>
                            @error('visibility') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

        <!-- Country Restrictions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="bg-red-50 p-4 rounded-button border border-red-200">
                <h3 class="text-sm font-medium text-red-800 mb-2">Restricted Countries</h3>
                <p class="text-xs text-red-500 mb-3">Optionally, you can restrict workers from specific countries from applying to this job.</p>
                    <div wire:ignore>
                    <select id="restricted_countries" class="form-control w-full select2" multiple @if($canEditNone) disabled @endif>
                            @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ in_array($country->id, $restricted_countries) ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                </div>
                    </div>
                </div>

                <!-- Monitoring Preferences Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Monitoring Preferences</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Monitoring Type <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                            <input type="radio" id="selfMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="self_monitoring" class="peer absolute opacity-0 w-0 h-0" @if($canEditNone) disabled @endif>
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
                            <input type="radio" id="adminMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="admin_monitoring" class="peer absolute opacity-0 w-0 h-0" @if($canEditNone) disabled @endif>
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
                            <input type="radio" id="systemMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="system_monitoring" class="peer absolute opacity-0 w-0 h-0" @if($canEditNone) disabled @endif>
                                    <label for="systemMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                            <div class="w-5 h-5 flex items-center justify-center text-primary">
                                        <i class="ri-robot-2-line"></i>
                                            </div>
                                        </div>
                                        <span class="font-medium text-gray-800">System-Automated ({{ $currency_symbol }}{{ number_format($countrySetting->system_monitoring_cost ?? 0, 2) }})</span>
                                <span class="text-xs text-gray-500 text-center mt-1">Automated checks for task completion</span>
                                    </label>
                                </div>
                                @endif
                            </div>
                            @error('monitoring_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

        <!-- Budget & Promotion Options Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
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
                            <input type="number" id="budget_per_person" wire:model="budget_per_person" wire:input="updateTotals" min="{{ $min_budget_per_person }}" step="0.01" class="w-40 rounded-r-button border-l-0 px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="0.00" required @if($canEditNone) readonly disabled @endif>
                                </div>
                                @if($min_budget_per_person > 0)
                                    <div class="text-xs text-gray-500 mt-1">Minimum allowed: {{ $currency_symbol }}{{ number_format($min_budget_per_person, 2) }} per person (based on template & country)</div>
                                @endif
                                @if($budget_per_person < $min_budget_per_person)
                                    <div class="text-xs text-red-500 mt-1">Budget per person cannot be less than the minimum allowed.</div>
                                @endif
                        @error('budget_per_person') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Number of People -->
                            <div>
                                <label for="number_of_people" class="block text-sm font-medium text-gray-700 mb-1">Number of People <span class="text-red-500">*</span></label>
                                <div class="flex items-center">
                            <button type="button" wire:click="decreasePeople" class="flex items-center justify-center w-10 h-10 rounded-l-button bg-gray-100 border border-gray-300 hover:bg-gray-200" @if($canEditNone) disabled @endif>
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-subtract-line"></i>
                                        </div>
                                    </button>
                            <input type="number" id="number_of_people" wire:model="number_of_people" wire:input="updateTotals" min="1" class="w-32 px-4 py-2 border-t border-b border-gray-300 text-center focus:ring-0 focus:border-gray-300 outline-none" @if($canEditNone) readonly disabled @endif>
                            <button type="button" wire:click="increasePeople" class="flex items-center justify-center w-10 h-10 rounded-r-button bg-gray-100 border border-gray-300 hover:bg-gray-200" @if($canEditNone) disabled @endif>
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
                    <!-- Featured Job Option -->
                            <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-button">
                                <div class="flex items-center min-w-[250px]">
                            <input id="featured" type="checkbox" wire:model="featured" wire:change="updateTotals" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" @if($canEditNone) disabled @endif>
                                    <div class="ml-3">
                                        <label for="featured" class="block text-sm font-medium text-gray-700">Featured Job</label>
                                        <p class="text-xs text-gray-500">Display prominently in search results</p>
                                    </div>
                                </div>
                                
                                @if($featured)
                                <div class="flex items-center gap-3 ml-auto">
                                    <div>
                                        <label for="featured_days" class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                                <select id="featured_days" wire:model="featured_days" wire:change="updateTotals" class="w-full appearance-none px-3 py-1 text-sm pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" @if($canEditNone) disabled @endif>
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
                            
                    <!-- Urgent Badge Option -->
                            <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-button">
                                <div class="flex items-center min-w-[250px]">
                            <input id="urgent" type="checkbox" wire:model="urgent" wire:change="updateTotals" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" @if($canEditNone) disabled @endif>
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
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Posting Fees</h3>
                                <div class="space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Job Budget:</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                                    </div>
                                    @if($featured)
                                    <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Featured Promotion:</span>
                                <span class="text-sm font-medium">
                                    @if($featuredPrice == 0)
                                    Included
                                    @else
                                    {{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }}
                                    @endif
                                </span>
                            </div>
                                    @endif
                                    @if($urgent)
                                    <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Urgent Promotion:</span>
                                <span class="text-sm font-medium">
                                    @if($urgentPrice == 0)
                                    Included
                                    @else
                                    {{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }}
                                    @endif
                                </span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Platform Service Charge:</span>
                                        <span class="text-sm font-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                                    </div>
                            @if($monitoring_fee > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Monitoring Fee:</span>
                                <span class="text-sm font-medium">
                                    {{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}
                                    @if($monitoring_type === 'admin_monitoring' || $monitoring_type === 'system_monitoring')
                                    <span class="text-xs text-gray-500">({{ $currency_symbol }}{{ number_format($monitoring_fee / $number_of_people, 2) }} x {{ $number_of_people }} people)</span>
                                    @endif
                                </span>
                            </div>
                            @if($showSelfMonitoringRefundNote)
                                <div class="text-xs text-blue-600 mt-1 ml-2">This fee will be refunded if no admin intervention is required to review job submissions.</div>
                            @endif
                            @endif
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
            
        <!-- Terms & Conditions -->
        <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" type="checkbox" wire:model="terms" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" @if($canEditNone) disabled @endif>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a></label>
                                @error('terms') <span class="block text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
    </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-primary text-white rounded-button hover:bg-primary/90 font-semibold text-lg" @if($canEditNone) disabled @endif>
                <div class="flex items-center">
                    <span>Proceed to Payment</span>
                    <div class="w-5 h-5 flex items-center justify-center ml-2">
                        <i class="ri-secure-payment-line"></i>
                    </div>
                </div>
            </button>
        </div>
    </form>
    @endif
</main>

@push('styles')
<link href="{{asset('frontend/css/select2.min.css')}}" rel="stylesheet" />
<style>
    /* Select2 Custom Styling */
    .select2-container .select2-selection--single {
        height: 40px !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
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
        border: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script>
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