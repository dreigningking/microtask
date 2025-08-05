<div>
    @if(count($templateFields) > 0)
    <div class="template-fields">
        <h3 class="h5 fw-semibold mb-4">Template Fields</h3>
        <div class="row g-3">
            @foreach($templateFields as $field)
                @php
                    $hasError = isset($validationErrors["templateData.{$field['name']}.value"]);
                @endphp


                @switch($field['type'])
                    @case('text')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                            wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                            @if($field['required'] ?? false) required @endif>
                    </div>
                    @break

                    @case('textarea')
                    <div class="col-12 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <textarea class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                            wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                            @if($field['required'] ?? false) required @endif></textarea>

                    </div>
                    @break

                    @case('number')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="number"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                                wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>

                    </div>
                    @break

                    @case('email')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="email"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                                wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>
                    </div>
                    @break

                    @case('url')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="url"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                                wire:model="templateData.{{ $field['name'] }}.value"
                                wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>
                    </div>
                    @break

                    @case('date')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="date"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                                wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>
                    </div>
                    @break

                    @case('time')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="time"
                            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                                wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>
                    </div>
                    @break

                    @case('select')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <select class="form-select {{ $hasError ? 'is-invalid' : '' }}"
                            wire:model="templateData.{{ $field['name'] }}.value"
                            wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                @if($field['required'] ?? false) required @endif>
                                <option value="">Select {{ $field['title'] }}</option>
                                @foreach($field['options'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                    </div>
                    @break

                    @case('checkbox')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>  
                            @endif
                        </label>
                        @foreach($field['options'] as $option)
                        <div class="form-check">
                            <input type="checkbox"
                                    class="form-check-input {{ $hasError ? 'is-invalid' : '' }}"
                                    wire:model="templateData.{{ $field['name'] }}.value"
                                    wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                    value="{{ $option }}"
                                    @if($field['required'] ?? false) required @endif>
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                            @endforeach
                    </div>
                    @break

                    @case('radio')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        @foreach($field['options'] as $option)
                        <div class="form-check">
                            <input type="radio"
                                    class="form-check-input {{ $hasError ? 'is-invalid' : '' }}"
                                    wire:model="templateData.{{ $field['name'] }}.value"
                                    wire:change="updateField('{{ $field['name'] }}', $event.target.value)"
                                    value="{{ $option }}"
                                    @if($field['required'] ?? false) required @endif>
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                            @endforeach
                    </div>
                    @break

                    @case('file')
                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-medium mb-1">
                            {{ $field['title'] }}
                            @if($field['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="file"
                            accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.mp4,.mov,.avi,.wmv,.mkv"
                                class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                                wire:model="templateData.{{ $field['name'] }}.value"
                                @if($field['required'] ?? false) required @endif>
                            @if(isset($templateData[$field['name']]['value']) && is_string($templateData[$field['name']]['value']) && Str::startsWith($templateData[$field['name']]['value'], 'storage/'))
                            <a href="{{ asset($templateData[$field['name']]['value']) }}" target="_blank" class="text-primary text-decoration-underline small mt-1 d-inline-block">View Uploaded File</a>
                            @endif
                    </div>
                    @break
                @endswitch

                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['name']}.value"][0] }}
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>