<?php
use Illuminate\Support\Str;
?>

<div class="task-card card h-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <span class="badge bg-info">{{ $task->platform->name }}</span>
            <span class="price-tag">{{ $task->user->country->currency_symbol ?? '$' }}{{ $task->budget_per_submission }}</span>
        </div>
        <h5 class="card-title">
             <a href="{{ route('explore.task',$task) }}">{{ $task->title }}</a>  
        </h5>
        <p class="card-text text-muted">{{ Str::words($task->description, 10, '...') }}</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted"><i class="bi bi-clock"></i> {{ $task->estimated_time }} left</small>
            <small class="text-muted"><i class="bi bi-person"></i> 1/2 submissions</small>
        </div>
    </div>
    
    <div class="card-footer bg-transparent">
        @if(Auth::check())
        <a href="{{ route('explore.task',$task) }}" class="btn apply-btn w-100">Apply Now</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Sign in to Apply</a>
        @endif
    </div>
</div>