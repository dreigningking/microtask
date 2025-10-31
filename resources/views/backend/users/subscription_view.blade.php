@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title">
                Subscription Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.subscriptions.index') }}">Subscriptions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription #{{ $subscription->id }}</li>
                </ol>
            </nav>
        </div>

        <!-- Subscription Summary Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="mb-1">
                                    {{ $subscription->plan->name }} Subscription
                                    <span class="badge
                                        @if($subscription->status == 'active') bg-success
                                        @elseif($subscription->status == 'expired') bg-warning
                                        @elseif($subscription->status == 'cancelled') bg-danger
                                        @elseif($subscription->status == 'suspended') bg-secondary
                                        @else bg-light text-dark
                                        @endif">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </h4>
                                <div class="mb-2">
                                    <strong>User:</strong> {{ $subscription->user->name }} ({{ $subscription->user->email }})
                                </div>
                                <div class="mb-2">
                                    <strong>Plan Type:</strong> {{ ucfirst($subscription->plan->type) }}
                                </div>
                                <div class="mb-2">
                                    <strong>Cost:</strong> {{ $subscription->currency }} {{ $subscription->cost }}
                                    <span class="badge bg-info">{{ ucfirst($subscription->billing_cycle) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Duration:</strong> {{ $subscription->duration_months }} months
                                </div>
                                @if($subscription->starts_at)
                                <div class="mb-2">
                                    <strong>Started:</strong> {{ $subscription->starts_at->format('M d, Y H:i') }}
                                </div>
                                @endif
                                @if($subscription->expires_at)
                                <div class="mb-2">
                                    <strong>Expires:</strong> {{ $subscription->expires_at->format('M d, Y H:i') }}
                                    @if($subscription->expires_at->isPast() && $subscription->status == 'active')
                                        <small class="text-danger">(Expired)</small>
                                    @endif
                                </div>
                                @endif
                                <div class="mb-2">
                                    <strong>Auto Renew:</strong> {{ $subscription->auto_renew ? 'Yes' : 'No' }}
                                </div>
                                <div class="mb-2">
                                    <strong>Created:</strong> {{ $subscription->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('admin.users.show', $subscription->user) }}" class="btn btn-primary btn-sm mb-2">
                                    <i class="ri-user-line me-1"></i>View User
                                </a>
                                <a href="{{ route('admin.users.subscriptions.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="ri-arrow-left-line me-1"></i>Back to Subscriptions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Details Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#tab-details" data-toggle="tab" role="tab">Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-features" data-toggle="tab" role="tab">Features</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-history" data-toggle="tab" role="tab">History</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Details Tab -->
                        <div class="tab-pane fade show active" id="tab-details" role="tabpanel">
                            <div class="card-body">
                                <h5>Subscription Information</h5>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item"><strong>ID:</strong> {{ $subscription->id }}</li>
                                    <li class="list-group-item"><strong>User:</strong> {{ $subscription->user->name }} ({{ $subscription->user->email }})</li>
                                    <li class="list-group-item"><strong>Plan:</strong> {{ $subscription->plan->name }}</li>
                                    <li class="list-group-item"><strong>Plan Type:</strong> {{ ucfirst($subscription->plan->type) }}</li>
                                    <li class="list-group-item"><strong>Status:</strong>
                                        <span class="badge
                                            @if($subscription->status == 'active') bg-success
                                            @elseif($subscription->status == 'expired') bg-warning
                                            @elseif($subscription->status == 'cancelled') bg-danger
                                            @elseif($subscription->status == 'suspended') bg-secondary
                                            @else bg-light text-dark
                                            @endif">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item"><strong>Cost:</strong> {{ $subscription->currency }} {{ $subscription->cost }}</li>
                                    <li class="list-group-item"><strong>Currency:</strong> {{ $subscription->currency }}</li>
                                    <li class="list-group-item"><strong>Billing Cycle:</strong> {{ ucfirst($subscription->billing_cycle) }}</li>
                                    <li class="list-group-item"><strong>Duration:</strong> {{ $subscription->duration_months }} months</li>
                                    <li class="list-group-item"><strong>Auto Renew:</strong> {{ $subscription->auto_renew ? 'Yes' : 'No' }}</li>
                                    @if($subscription->starts_at)
                                    <li class="list-group-item"><strong>Started At:</strong> {{ $subscription->starts_at->format('M d, Y H:i') }}</li>
                                    @endif
                                    @if($subscription->expires_at)
                                    <li class="list-group-item"><strong>Expires At:</strong> {{ $subscription->expires_at->format('M d, Y H:i') }}</li>
                                    @endif
                                    @if($subscription->cancelled_at)
                                    <li class="list-group-item"><strong>Cancelled At:</strong> {{ $subscription->cancelled_at->format('M d, Y H:i') }}</li>
                                    @endif
                                    @if($subscription->suspended_at)
                                    <li class="list-group-item"><strong>Suspended At:</strong> {{ $subscription->suspended_at->format('M d, Y H:i') }}</li>
                                    @endif
                                    <li class="list-group-item"><strong>Created At:</strong> {{ $subscription->created_at->format('M d, Y H:i') }}</li>
                                    <li class="list-group-item"><strong>Updated At:</strong> {{ $subscription->updated_at->format('M d, Y H:i') }}</li>
                                </ul>

                                <h5>Plan Information</h5>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item"><strong>Plan Name:</strong> {{ $subscription->plan->name }}</li>
                                    <li class="list-group-item"><strong>Slug:</strong> {{ $subscription->plan->slug ?? 'N/A' }}</li>
                                    <li class="list-group-item"><strong>Description:</strong> {{ $subscription->plan->description ?? 'N/A' }}</li>
                                    <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($subscription->plan->type) }}</li>
                                    <li class="list-group-item"><strong>Featured Promotion:</strong> {{ $subscription->plan->featured_promotion ? 'Yes (Taskmasters)' : 'No' }}</li>
                                    <li class="list-group-item"><strong>Urgency Promotion:</strong> {{ $subscription->plan->urgency_promotion ? 'Yes (Taskmasters)' : 'No' }}</li>
                                    @if($subscription->plan->type == 'worker')
                                    <li class="list-group-item"><strong>Active Tasks per Hour:</strong> {{ $subscription->plan->active_tasks_per_hour }}</li>
                                    <li class="list-group-item"><strong>Withdrawal Max Multiplier:</strong> x{{ $subscription->plan->withdrawal_maximum_multiplier }}</li>
                                    @endif
                                    <li class="list-group-item"><strong>Plan Status:</strong> {{ $subscription->plan->is_active ? 'Active' : 'Inactive' }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Features Tab -->
                        <div class="tab-pane fade" id="tab-features" role="tabpanel">
                            <div class="card-body">
                                <h5>Subscription Features</h5>
                                @if($subscription->features && is_array($subscription->features))
                                    <ul class="list-group mb-3">
                                        @foreach($subscription->features as $key => $value)
                                            <li class="list-group-item">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                @if(is_bool($value))
                                                    {{ $value ? 'Yes' : 'No' }}
                                                @elseif(is_array($value))
                                                    <ul class="mt-2">
                                                        @foreach($value as $item)
                                                            <li>{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info">No features data available for this subscription.</div>
                                @endif

                                <h5>Plan Features</h5>
                                @if($subscription->plan->type == 'taskmaster')
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Featured Promotion:</strong> {{ $subscription->plan->featured_promotion ? 'Available' : 'Not available' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Urgency Promotion:</strong> {{ $subscription->plan->urgency_promotion ? 'Available' : 'Not available' }}
                                        </li>
                                    </ul>
                                @elseif($subscription->plan->type == 'worker')
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Active Tasks per Hour:</strong> {{ $subscription->plan->active_tasks_per_hour }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Withdrawal Max Multiplier:</strong> x{{ $subscription->plan->withdrawal_maximum_multiplier }}
                                        </li>
                                    </ul>
                                @else
                                    <div class="alert alert-info">Plan type not recognized.</div>
                                @endif
                            </div>
                        </div>

                        <!-- History Tab -->
                        <div class="tab-pane fade" id="tab-history" role="tabpanel">
                            <div class="card-body">
                                <h5>Subscription Timeline</h5>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $subscription->created_at->format('M d, Y H:i') }}</h6>
                                            <p class="timeline-text">Subscription created</p>
                                        </div>
                                    </div>

                                    @if($subscription->starts_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $subscription->starts_at->format('M d, Y H:i') }}</h6>
                                            <p class="timeline-text">Subscription started</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($subscription->suspended_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-warning"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $subscription->suspended_at->format('M d, Y H:i') }}</h6>
                                            <p class="timeline-text">Subscription suspended</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($subscription->cancelled_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-danger"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $subscription->cancelled_at->format('M d, Y H:i') }}</h6>
                                            <p class="timeline-text">Subscription cancelled</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($subscription->expires_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker {{ $subscription->expires_at->isPast() ? 'bg-danger' : 'bg-info' }}"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $subscription->expires_at->format('M d, Y H:i') }}</h6>
                                            <p class="timeline-text">{{ $subscription->expires_at->isPast() ? 'Subscription expired' : 'Subscription expires' }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .timeline-content h6 {
        margin-bottom: 5px;
        font-size: 0.875rem;
        color: #495057;
    }

    .timeline-content p {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 0.875rem;
    }

    .badge {
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('a[data-toggle="tab"]'));
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
@endpush
