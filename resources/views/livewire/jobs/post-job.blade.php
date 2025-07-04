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
    <!-- Progress Steps -->
    <div class="mb-10">
        <div class="flex items-center justify-between">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">1</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 1 ? 'text-primary' : 'text-gray-500' }}">Template</span>
            </div>
            @php $step1Width = $currentStep > 1 ? '100%' : '0%'; @endphp
            <div class="flex-1 h-1 mx-2 bg-gray-200">
                <div class="h-full bg-primary" style="width: {{ $step1Width }};"></div>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">2</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 2 ? 'text-primary' : 'text-gray-500' }}">Details</span>
            </div>
            @php $step2Width = $currentStep > 2 ? '100%' : '0%'; @endphp
            <div class="flex-1 h-1 mx-2 bg-gray-200">
                <div class="h-full bg-primary" style="width: {{ $step2Width }};"></div>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 3 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">3</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 3 ? 'text-primary' : 'text-gray-500' }}">Budget</span>
            </div>
            @php $step3Width = $currentStep > 3 ? '100%' : '0%'; @endphp
            <div class="flex-1 h-1 mx-2 bg-gray-200">
                <div class="h-full bg-primary" style="width: {{ $step3Width }};"></div>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 {{ $currentStep == 4 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} rounded-full flex items-center justify-center font-bold">4</div>
                <span class="mt-2 text-sm font-medium {{ $currentStep == 4 ? 'text-primary' : 'text-gray-500' }}">Review</span>
            </div>
        </div>
    </div>

    {{-- Step 1: Template Selection --}}
    @if($currentStep == 1)
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Select a Task Template</h1>
        <p class="text-gray-600 mb-4">Choose a template that best matches your job. You can filter by platform.</p>
    </div>
    <div class="sticky top-20 z-20 bg-white py-3 mb-6 shadow-sm flex flex-wrap gap-2 items-center">
        <label class="font-medium text-gray-700 mr-2">Platform:</label>
        <button wire:click="$set('platform_id', null)" class="px-3 py-1 rounded-button text-sm {{ !$platform_id ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</button>
        @foreach($platforms as $platform)
        <button wire:click="$set('platform_id', {{ $platform->id }})" class="px-3 py-1 rounded-button text-sm {{ $platform_id == $platform->id ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            {{ $platform->name }}
        </button>
        @endforeach
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates->when($platform_id, fn($q) => $q->where('platform_id', $platform_id)) as $template)
        <div
            wire:key="template-{{ $template->id }}"
            wire:click="selectTemplate({{ $template->id }})"
            class="cursor-pointer border rounded-lg p-5 bg-white shadow-sm transition-all duration-150 {{ $template_id == $template->id ? 'border-primary ring-2 ring-primary' : 'border-gray-200 hover:border-primary' }}">
            <div class="flex items-center mb-3">
                @if($template->image_url)
                <img src="{{ $template->image_url }}" alt="{{ $template->name }}" class="w-12 h-12 rounded mr-3 object-cover">
                @else
                <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center mr-3">
                    <i class="ri-file-list-2-line text-2xl text-gray-400"></i>
                </div>
                @endif
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $template->name }}</h2>
                    <span class="text-xs text-gray-500">{{ $template->platform->name ?? '' }}</span>
                </div>
            </div>
            <div class="text-gray-700 text-sm mb-2 min-h-[48px]">{{ Str::limit($template->description, 100) }}</div>
            @php
            $fieldCount = is_array($template->task_fields) ? count($template->task_fields) : 0;
            @endphp
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs text-gray-500">Fields: {{ $fieldCount }}</span>
                @if($template_id == $template->id)
                <span class="inline-block px-2 py-1 bg-primary text-white text-xs rounded">Selected</span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-gray-500 py-8">
            <i class="ri-file-list-2-line text-4xl mb-2"></i>
            <p>No templates found for this platform.</p>
        </div>
        @endforelse
    </div>
    <div class="flex justify-end mt-8 flex-col items-end">
        @if($errors->has('platform_id'))
        <span class="text-red-500 text-sm mb-2">{{ $errors->first('platform_id') }}</span>
        @endif
        @if($errors->has('template_id'))
        <span class="text-red-500 text-sm mb-2">{{ $errors->first('template_id') }}</span>
        @endif
        <button type="button" wire:click="nextStep" class="px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap" @if(!$template_id) disabled @endif>
            <div class="flex items-center">
                <span>Next Step</span>
                <div class="w-5 h-5 flex items-center justify-center ml-1">
                    <i class="ri-arrow-right-line"></i>
                </div>
            </div>
        </button>
    </div>
    @endif

    {{-- Step 2: Job Details --}}
    @if($currentStep == 2)
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Job Details</h1>
        <p class="text-gray-600 mb-4">Fill in the details for your job. Required fields are marked with <span class="text-red-500">*</span>.</p>
    </div>
    <form wire:submit.prevent="nextStep" id="post-job-step2-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" wire:model="title" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Create content for social media" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

        <div class="mt-6">
        <label for="description-editor" class="block text-sm font-medium text-gray-700 mb-1">Write step by step instructions on what to do<span class="text-red-500">*</span></label>
        <div class=" linenumbered-textarea">
            <div class="line-numbers"></div>
            <textarea id="description-editor" rows="2" class="w-full px-4 py-2 border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required>{{ $description }}</textarea>
            <input type="hidden" wire:model="description" id="description-hidden">
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
        <div class="mt-6">
            @livewire('jobs.template-fields', ['templateId' => $template_id, 'templateData' => $templateData])
                                    </div>
        <div wire:ignore class="mt-6">
            <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Required Tools <span class="text-red-500">*</span></label>
                <div>
                <select id="requirements" class="form-control w-full select2" multiple>
                    @foreach($requirements as $tool)
                    <option value="{{ $tool }}" selected>{{ $tool }}</option>
                                        @endforeach
                </select>
                                    </div>
            <p class="text-xs text-gray-500 mt-1">Add tools or software required for this job (required)</p>
                                @error('requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
        <div wire:ignore class="mt-6 bg-red-50 p-4 rounded-button border border-red-200">
            <h3 class="text-sm font-medium text-red-800 mb-2">Restricted Countries</h3>
            <p class="text-xs text-red-500 mb-3">Optionally, you can restrict workers from specific countries from applying to this job.</p>
                        <div>
                <select id="restricted_countries" class="form-control w-full select2" multiple>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        <div class="flex justify-between mt-8 border-t border-gray-200 pt-6">
            <button type="button" wire:click="previousStep" class="px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-5 h-5 flex items-center justify-center mr-1">
                        <i class="ri-arrow-left-line"></i>
                    </div>
                    <span>Back</span>
                </div>
            </button>
            <button type="submit" class="px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap">
                <div class="flex items-center">
                    <span>Next Step</span>
                    <div class="w-5 h-5 flex items-center justify-center ml-1">
                        <i class="ri-arrow-right-line"></i>
                    </div>
                </div>
            </button>
        </div>
    </form>
    @endif

    {{-- Step 3: Budget, Expiry, Monitoring, Promotion --}}
    @if($currentStep == 3)
    <form wire:submit.prevent="nextStep" id="post-job-step3-form">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Monitoring Preferences</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Monitoring Type <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                            <input type="radio" id="selfMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="self_monitoring" class="peer absolute opacity-0 w-0 h-0">
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
                            <input type="radio" id="adminMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="admin_monitoring" class="peer absolute opacity-0 w-0 h-0">
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
                            <input type="radio" id="systemMonitored" wire:model="monitoring_type" wire:change="updateTotals" value="system_monitoring" class="peer absolute opacity-0 w-0 h-0">
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
                        </div>
                    </div>
                </div>

        <div class="mt-8">
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
                                    @error('budget_per_person') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                    <!-- Expiry Date -->
                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Job Expiry Date</label>
                        <input type="date" id="expiry_date" wire:model="expiry_date" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        @error('expiry_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                        <div class="flex items-center ml-4">
                            <input type="number" wire:model="featured_days" wire:input="updateTotals" min="1" class="w-20 px-2 py-1 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Days">
                            <span class="text-xs text-gray-500 ml-2">days</span>
                                </div>
                                @endif
                        <span class="ml-auto text-xs text-gray-500">
                            @if($featuredPrice == 0)
                            Included in your subscription
                            @else
                            {{ $currency_symbol }}{{ number_format($featuredPrice, 2) }} per day
                            @endif
                        </span>
                            </div>
                    <!-- Urgent Badge Option -->
                            <div class="flex flex-wrap items-center gap-3 p-3 border border-gray-200 rounded-button">
                                <div class="flex items-center min-w-[250px]">
                                    <input id="urgent" type="checkbox" wire:model="urgent" wire:change="updateTotals" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <div class="ml-3">
                                        <label for="urgent" class="block text-sm font-medium text-gray-700">Urgent Badge</label>
                                        <p class="text-xs text-gray-500">Add badge to attract immediate attention</p>
                                    </div>
                                </div>
                        <span class="ml-auto text-xs text-gray-500">
                            @if($urgentPrice == 0)
                            Included in your subscription
                            @else
                            {{ $currency_symbol }}{{ number_format($urgentPrice, 2) }} per person
                                @endif
                        </span>
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
                            {{ $currency_symbol }} {{ number_format($total, 2) }}
                                </div>
                        <p class="text-xs text-gray-500 mt-1">For {{ $number_of_people }} person{{ $number_of_people > 1 ? 's' : '' }}</p>
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
            <div class="mt-8 flex justify-between border-t border-gray-200 pt-6">
                <button type="button" wire:click="previousStep" class="px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-1">
                            <i class="ri-arrow-left-line"></i>
                </div>
                        <span>Back</span>
            </div>
                </button>
                <button type="submit" class="px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap">
                    <div class="flex items-center">
                        <span>Next Step</span>
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- Step 4: Login or Review & Confirmation --}}
    @if($currentStep == 4)
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Summary</h2>
            <div class="mb-6">
                <div class="border rounded-lg p-4 bg-gray-50">
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between">
                            <span>Job Budget:</span>
                            <span class="font-medium">{{ $currency_symbol }} {{ number_format($expected_budget, 2) }}</span>
                        </div>
                        @if($featured)
                        <div class="flex justify-between">
                            <span>Featured Job ({{ $featured_days }} day{{ $featured_days > 1 ? 's' : '' }}):</span>
                            <span class="font-medium">@if($featuredPrice == 0) Included @else {{ $currency_symbol }} {{ number_format($featuredPrice * $featured_days, 2) }} @endif</span>
                        </div>
                        @endif
                        @if($urgent)
                        <div class="flex justify-between">
                            <span>Urgent Badge ({{ $number_of_people }} people):</span>
                            <span class="font-medium">@if($urgentPrice == 0) Included @else {{ $currency_symbol }} {{ number_format($urgentPrice * $number_of_people, 2) }} @endif</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Platform Service Charge:</span>
                            <span class="font-medium">{{ $currency_symbol }} {{ number_format($serviceFee, 2) }}</span>
                        </div>
                        @if($monitoring_fee > 0)
                        <div class="flex justify-between">
                            <span>Monitoring Fee:</span>
                            <span class="font-medium">{{ $currency_symbol }} {{ number_format($monitoring_fee, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="font-medium">{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax ({{ $tax_rate }}%):</span>
                            <span class="font-medium">{{ $currency_symbol }} {{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-primary">{{ $currency_symbol }} {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                                </div>
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Payment Information</h3>
                <div class="bg-gray-50 border rounded-lg p-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                            <i class="ri-shield-check-line text-2xl text-primary"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 mb-1">Secure Payment</p>
                        <ul class="text-sm text-gray-600 list-disc ml-5">
                            <li>After submitting your job, you'll be redirected to our secure payment gateway.</li>
                            <li>Your job will be published immediately after successful payment.</li>
                            <li>We accept credit/debit cards, PayPal, and other payment methods.</li>
                        </ul>
                    </div>
                </div>
            </div>
                @if(!$isLoggedIn)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Login Required</h3>
                            <p class="text-sm text-gray-600 mb-4">Please login to continue with your job posting.</p>
                <form wire:submit.prevent="nextStep" class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                            <input type="checkbox" id="remember" wire:model="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Forgot password?</a>
                                </div>
                    <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-button hover:bg-primary/90 font-semibold">Login</button>
                </form>
                <div class="mt-4 text-center">
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline ml-1">Register</a>
                        </div>
                    </div>
                @else
            <div class="mb-6">
                <form wire:submit.prevent="nextStep" class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" wire:model="terms" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">I agree to the <a href="{{ route('legal.terms-conditions') }}" target="_blank" class="text-primary underline">Terms and Conditions</a> and <a href="{{ route('legal.privacy-policy') }}" target="_blank" class="text-primary underline">Privacy Policy</a></label>
                    </div>
                    @error('terms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-button hover:bg-primary/90 font-semibold">Proceed to Payment</button>
                </form>
            </div>
            @endif
    </div>
        <div class="mt-6 flex justify-between">
            <button type="button" wire:click="previousStep" class="px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">
            <div class="flex items-center">
                <div class="w-5 h-5 flex items-center justify-center mr-1">
                    <i class="ri-arrow-left-line"></i>
                </div>
                <span>Back</span>
                </div>
            </button>
        </div>
    </div>
    @endif

    @endif
</main>

@push('styles')
<link href="{{asset('frontend/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{ asset('frontend/css/textarea-linenumbers.css') }}" rel="stylesheet" />
<style>
    .progress-width-0 {
        width: 0%;
    }

    .progress-width-100 {
        width: 100%;
    }

    .progress-width {
        width: 0%;
    }

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
<script src="{{ asset('frontend/js/textarea-linenumbers.js') }}"></script>
<script>
    Livewire.on('step2-shown', function() {
        setTimeout(initializeSelect2, 100);
        setTimeout(window.initLineNumberedTextareas, 100);
    });
    
    function initializeSelect2() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            if (jQuery('#requirements').length) {
                if (jQuery('#requirements').hasClass('select2-hidden-accessible')) {
                    jQuery('#requirements').select2('destroy');
                }
                jQuery('#requirements').select2({
                    placeholder: "Select tools required",
                    allowClear: true,
                    tags: true,
                    width: '100%'
                }).on('change', function(e) {
                    // Get selected data
                    let data = jQuery(this).val();
                    window.Livewire.dispatch('updateSelect2', {
                        data: data,
                        element: 'requirements'
                    });
                });
            }
            if (jQuery('#restricted_countries').length) {
                if (jQuery('#restricted_countries').hasClass('select2-hidden-accessible')) {
                    jQuery('#restricted_countries').select2('destroy');
                }
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
</script>
@endpush