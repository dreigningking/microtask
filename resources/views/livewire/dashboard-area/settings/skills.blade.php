<div>
    <h5 class="mb-4">Skills Management</h5>
    
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" 
               type="text" 
               placeholder="Search skills..." 
               class="form-control">
    </div>

    <div class="row g-3">
        @foreach($skills as $skill)
            <div class="col-6 col-md-4 col-lg-3">
                <div wire:click="toggleSkill({{ $skill->id }})"
                     class="card cursor-pointer h-100 {{ in_array($skill->id, $userSkills) ? 'border-primary bg-primary text-white' : 'border-secondary' }}"
                     style="cursor: pointer;">
                    <div class="card-body text-center py-3">
                        <span class="fw-medium">{{ $skill->name }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
