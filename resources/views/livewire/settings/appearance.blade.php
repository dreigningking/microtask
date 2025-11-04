<div>
    <h5 class="mb-4">Appearance Settings</h5>
    
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="ri-palette-line me-2"></i>Theme Selection
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Choose your preferred theme for the application.</p>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="theme" id="theme_light" value="light" wire:model="theme">
                        <label class="form-check-label d-flex align-items-center" for="theme_light">
                            <i class="ri-sun-line me-2"></i>Light
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="theme" id="theme_dark" value="dark" wire:model="theme">
                        <label class="form-check-label d-flex align-items-center" for="theme_dark">
                            <i class="ri-moon-line me-2"></i>Dark
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="theme" id="theme_system" value="system" wire:model="theme">
                        <label class="form-check-label d-flex align-items-center" for="theme_system">
                            <i class="ri-computer-line me-2"></i>System
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
