
<div class="content-wrapper">
    <!-- Task Ban Warning -->
    @if($userData->is_banned_from_tasks)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <i class="mdi mdi-alert-circle me-2"></i>
                <strong>Account Restriction:</strong> You are currently banned from taking tasks. Please contact support for more information.
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="font-weight-bold">Welcome {{ $userData->name }}</h3>
            <button wire:click="switchView('{{ $activeView === 'tasks' ? 'jobs' : 'tasks' }}')" class="btn btn-sm btn-outline-primary">
                <i class="mdi mdi-calendar"></i> Switch to {{ $activeView === 'tasks' ? 'Job' : 'Task' }} Dashboard
            </button>
        </div>
    </div>

    <!-- Tasks View -->
    <div class="{{ $activeView === 'tasks' ? '' : 'd-none' }}">
        @include('livewire.dashboard-area.dashboard.dashboard-tasks')
    </div>

    <!-- Jobs View -->
    <div class="{{ $activeView === 'jobs' ? '' : 'd-none' }}">
        @include('livewire.dashboard-area.dashboard.dashboard-jobs')
    </div>
</div>
