@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
	<div class="container-fluid">

		<div class="header">
			<h1 class="header-title">
				Users
			</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="#">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">List</li>
				</ol>
			</nav>
		</div>

		<!-- Filters Section -->
		<div class="row mb-3">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Filters</h5>
					</div>
					<div class="card-body">
						<form method="GET" action="{{ route('admin.users.index') }}" id="userFiltersForm">
							<div class="row">
								<div class="col-md-2 mb-3">
									<label for="name" class="form-label">Name</label>
									<input type="text" class="form-control" id="name" name="name" 
										   value="{{ request('name') }}" placeholder="Search by name">
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" id="email" name="email" 
										   value="{{ request('email') }}" placeholder="Search by email">
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status" name="status">
										<option value="">All Statuses</option>
										<option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
										<option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="task_ban" class="form-label">Task Ban</label>
									<select class="form-select" id="task_ban" name="task_ban">
										<option value="">All</option>
										<option value="allowed" {{ request('task_ban') === 'allowed' ? 'selected' : '' }}>Allowed</option>
										<option value="banned" {{ request('task_ban') === 'banned' ? 'selected' : '' }}>Banned</option>
									</select>
								</div>
								
								<div class="col-md-2 mb-3">
									<label for="member_since" class="form-label">Member Since</label>
									<input type="date" class="form-control" id="member_since" name="member_since" 
										   value="{{ request('member_since') }}">
								</div>
							</div>
							
							@if(auth()->user()->role->name === 'super-admin' && $countries && $countries->count() > 0)
							<div class="row">
								<div class="col-md-3 mb-3">
									<label for="country_id" class="form-label">Country</label>
									<select class="form-select" id="country_id" name="country_id">
										<option value="">All Countries</option>
										@foreach($countries as $country)
											<option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
												{{ $country->name }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
							@endif
							
							<div class="row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary me-2" id="applyFiltersBtn">
										<i class="ri-search-line me-1"></i>Apply Filters
									</button>
									<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
										<i class="ri-refresh-line me-1"></i>Clear Filters
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Users</h5>
						<h6 class="card-subtitle text-muted">
							@if($users->total() > 0)
								Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
							@else
								No users found
							@endif
						</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Country</th>
										<th>Member since</th>
										<th>Status</th>
										<th>Task Ban</th>
										<th>Tasks Completed</th>
										<th>Jobs Posted</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@forelse($users as $user)
									<tr>
										<td>
											<strong>{{ $user->name }}</strong>
										</td>
										<td>
											<code class="text-primary">{{ $user->email }}</code>
										</td>
										<td>
											@if($user->country)
												<span class="badge bg-light text-dark">{{ $user->country->name }}</span>
											@else
												<span class="text-muted">-</span>
											@endif
										</td>
										<td>
											{{ $user->created_at->format('M d, Y') }}
										</td>
										<td>
											@if($user->is_active)
												<span class="badge bg-success">Active</span>
											@else
												<span class="badge bg-danger">Suspended</span>
											@endif
										</td>
										<td>
											@if($user->is_banned_from_tasks)
												<span class="badge bg-danger">Banned</span>
											@else
												<span class="badge bg-success">Allowed</span>
											@endif
										</td>
										<td>
											<span class="badge bg-info">{{ $user->tasks_completed ?? 0 }} / {{ $user->tasks_on_hand ?? 0 }}</span>
										</td>
										<td>
											<span class="badge bg-warning text-dark">{{ $user->jobs_completed ?? 0 }} / {{ $user->jobs_posted ?? 0 }}</span>
										</td>
										<td>
											<div class="btn-group" role="group">
												<a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm">
													<i class="ri-eye-line me-1"></i>View
												</a>
												
												@if(isset($user->is_active) && !$user->is_active)
													<form action="{{ route('admin.users.enable') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Enable this user?');">
														@csrf
														<input type="hidden" name="user_id" value="{{$user->id}}">
														<button type="submit" class="btn btn-success btn-sm">
															<i class="ri-check-line me-1"></i>Enable
														</button>
													</form>
												@else
													<form action="{{ route('admin.users.suspend') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Suspend this user?');">
														@csrf
														<input type="hidden" name="user_id" value="{{$user->id}}">
														<button type="submit" class="btn btn-warning btn-sm">
															<i class="ri-pause-line me-1"></i>Suspend
														</button>
													</form>
												@endif
												
												@if($user->is_banned_from_tasks)
													<form action="{{ route('admin.users.ban-from-tasks') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Unban this user from tasks?');">
														@csrf
														<input type="hidden" name="user_id" value="{{$user->id}}">
														<button type="submit" class="btn btn-success btn-sm">
															<i class="ri-check-line me-1"></i>Unban Tasks
														</button>
													</form>
												@else
													<form action="{{ route('admin.users.ban-from-tasks') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ban this user from tasks?');">
														@csrf
														<input type="hidden" name="user_id" value="{{$user->id}}">
														<button type="submit" class="btn btn-danger btn-sm">
															<i class="ri-close-line me-1"></i>Ban Tasks
														</button>
													</form>
												@endif
											</div>
										</td>
									</tr>
									@empty
										<tr>
											<td colspan="9" class="text-center py-4">
												<div class="text-muted">
													<i class="ri-inbox-line me-2"></i>No users found
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					@if($users->hasPages())
					<div class="card-footer">
						@include('backend.layouts.pagination', ['items' => $users])
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

@push('styles')
<style>
	.filter-loading {
		opacity: 0.7;
		pointer-events: none;
	}
	
	.badge {
		font-size: 0.75rem;
	}
	
	.table th {
		font-weight: 600;
		background-color: #f8f9fa;
	}
	
	code {
		font-size: 0.875rem;
		background-color: #f8f9fa;
		padding: 0.2rem 0.4rem;
		border-radius: 0.25rem;
	}
	
	.btn-group {
		flex-wrap: wrap;
		gap: 0.25rem;
	}
	
	.btn-group .btn {
		margin: 0;
	}
</style>
@endpush

@push('scripts')
<script>
	$(function() {
		// Auto-submit form when certain filters change
		$('#status, #task_ban, #country_id').on('change', function() {
			$('#userFiltersForm').submit();
		});

		// Add loading state to form
		function setFormLoading(loading) {
			const form = $('#userFiltersForm');
			if (loading) {
				form.addClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Loading...');
			} else {
				form.removeClass('filter-loading');
				$('#applyFiltersBtn').prop('disabled', false).html('<i class="ri-search-line me-1"></i>Apply Filters');
			}
		}

		// Show loading state when form is submitted
		$('#userFiltersForm').on('submit', function() {
			setFormLoading(true);
		});
	});
</script>
@endpush