<div>
@if(count($templateFields) > 0)
    <div class="template-fields">
        <h3 class="text-lg font-semibold mb-4">Template Fields</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($templateFields as $field)
                @php
                    $hasError = isset($validationErrors["templateData.{$field['name']}.value"]);
                @endphp
                <div class="mb-4 col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $field['title'] }}
                        @if($field['required'] ?? false)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    
                    @switch($field['type'])
                        @case('text')
                            <input type="text" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('textarea')
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                      wire:model="templateData.{{ $field['name'] }}.value"
                                      wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                      @if($field['required'] ?? false) required @endif></textarea>
                            @break
                            
                        @case('number')
                            <input type="number" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('email')
                            <input type="email" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('url')
                            <input type="url" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('date')
                            <input type="date" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('time')
                            <input type="time" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                            
                        @case('select')
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none {{ $hasError ? 'border-red-500' : '' }}"
                                    wire:model="templateData.{{ $field['name'] }}.value"
                                    wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                    @if($field['required'] ?? false) required @endif>
                                <option value="">Select {{ $field['title'] }}</option>
                                @foreach($field['options'] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @break
                            
                        @case('checkbox')
                            <div class="mt-2">
                                @foreach($field['options'] as $option)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 {{ $hasError ? 'border-red-500' : '' }}"
                                               wire:model="templateData.{{ $field['name'] }}.value"
                                               wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                               value="{{ $option }}"
                                               @if($field['required'] ?? false) required @endif>
                                        <label class="ml-2 block text-sm text-gray-900">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @break
                            
                        @case('radio')
                            <div class="mt-2">
                                @foreach($field['options'] as $option)
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500 {{ $hasError ? 'border-red-500' : '' }}"
                                               wire:model="templateData.{{ $field['name'] }}.value"
                                               wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                               value="{{ $option }}"
                                               @if($field['required'] ?? false) required @endif>
                                        <label class="ml-2 block text-sm text-gray-900">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @break
                            
                        @case('file')
                            <input type="file" 
                                   class="mt-1 block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100
                                          {{ $hasError ? 'border-red-500' : '' }}"
                                   wire:model="templateData.{{ $field['name'] }}.value"
                                   wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                   @if($field['required'] ?? false) required @endif>
                            @break
                    @endswitch
                    
                    @if($hasError)
                        <p class="mt-1 text-sm text-red-600">{{ $validationErrors["templateData.{$field['name']}.value"][0] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>
