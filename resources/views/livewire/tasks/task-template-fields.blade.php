<div>
    @if(count($templateFields) > 0)
    <div class="template-fields">
        <!-- <h3 class="h5 fw-semibold mb-4">Template Fields</h3> -->
        <div class="row g-3">
            @foreach($templateFields as $field)
            @php
            $hasError = isset($validationErrors["templateData.{$field['slug']}.value"]);
            @endphp
            @switch($field['type'])
            @case('text')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="text"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('textarea')
            <div class="col-12 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <textarea class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif></textarea>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif

            </div>
            @break

            @case('number')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="number"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('email')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="email"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('url')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="url"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('date')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="date"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('time')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="time"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('select')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <select class="form-select {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model.live="templateData.{{ $field['slug'] }}.value"
                    @if($field['required'] ?? false) required @endif>
                    <option value="">Select {{ $field['title'] }}</option>
                    @foreach($field['options'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('checkbox')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                @foreach($field['options'] as $option)
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input {{ $hasError ? 'is-invalid' : '' }}"
                        wire:model.live="templateData.{{ $field['slug'] }}.value"
                        value="{{ $option }}"
                        @if($field['required'] ?? false) required @endif>
                    <label class="form-check-label">{{ $option }}</label>
                </div>
                @endforeach
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('radio')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                @foreach($field['options'] as $option)
                <div class="form-check">
                    <input type="radio"
                        class="form-check-input {{ $hasError ? 'is-invalid' : '' }}"
                        wire:model.live="templateData.{{ $field['slug'] }}.value"
                        value="{{ $option }}"
                        @if($field['required'] ?? false) required @endif>
                    <label class="form-check-label">{{ $option }}</label>
                </div>
                @endforeach
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break

            @case('file')
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label mb-1">
                    {{ $field['title'] }}
                    @if($field['required'] ?? false)
                    <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="file"
                    accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.mp4,.mov,.avi,.wmv,.mkv"
                    class="form-control {{ $hasError ? 'is-invalid' : '' }}"
                    wire:model="templateData.{{ $field['slug'] }}.value"
                    wire:change="updateFile('{{ $field['slug'] }}')"
                    @if($field['required'] ?? false) required @endif>

                <div wire:loading.class="d-block" wire:target="templateData.{{ $field['slug'] }}.value" class="mt-2" style="display: none;">
                    <div class="d-flex align-items-center">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <small class="text-muted">Uploading file...</small>
                    </div>
                </div>

                @if(isset($templateData[$field['slug']]['value']) && is_string($templateData[$field['slug']]['value']) && Str::startsWith($templateData[$field['slug']]['value'], 'storage/'))
                <div class="mt-2">
                    @php
                    $filePath = $templateData[$field['slug']]['value'];
                    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                    @endphp

                    @if($isImage)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset($filePath) }}" alt="Uploaded image" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <a href="{{ asset($filePath) }}" target="_blank" class="text-primary text-decoration-underline small d-block">View Image</a>
                            <small class="text-muted">{{ basename($filePath) }}</small>
                        </div>
                    </div>
                    @else
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="ri-file-line text-muted fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <a href="{{ asset($filePath) }}" target="_blank" class="text-primary text-decoration-underline small d-block">View File</a>
                            <small class="text-muted">{{ basename($filePath) }}</small>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                @if($hasError)
                <div class="invalid-feedback d-block">
                    {{ $validationErrors["templateData.{$field['slug']}.value"][0] }}
                </div>
                @endif
            </div>
            @break
            @endswitch
            @endforeach
        </div>
    </div>
    @endif
</div>