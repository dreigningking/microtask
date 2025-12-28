@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Admin Dashboard
            </h1>
            <p class="header-subtitle">Overview of key metrics and pending items.</p>
        </div>

        <div class="row">
            <!-- Pending Moderations Table -->
            <div class="col-md-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pending Moderations</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingModerations as $mod)
                                <tr>
                                    <td>{{ $mod['type'] }}</td>
                                    <td>{{ $mod['count'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Country Statistics Table -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Countries</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                <i class="align-middle" data-feather="map"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($totalCountries) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Active Countries</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-success">
                                                <i class="align-middle" data-feather="check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($readyForProductionCountries) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Open Support Tickets</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-warning">
                                                <i class="align-middle" data-feather="help-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($openSupportTickets) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Pending Support Tickets</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-danger">
                                                <i class="align-middle" data-feather="clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($pendingSupportTickets) }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Active Featured Subscriptions</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                <i class="align-middle" data-feather="star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ $activeFeaturedPromotions }}</h1>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <!-- Currency Tables -->
        <div class="row">
            <div class="col-md-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Currency Wallets Total</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Currency</th>
                                    <th>Wallets Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currencyWallets as $wallet)
                                <tr>
                                    <td>{{ $wallet['currency'] }}</td>
                                    <td>{{ $wallet['total'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Currency Payments & Revenue</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Currency</th>
                                    <th>Payments</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currencyPayments as $payment)
                                <tr>
                                    <td>{{ $payment['currency'] }}</td>
                                    <td>{{ $payment['payments'] }}</td>
                                    <td>{{ $payment['revenue'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Featured Subscriptions -->


        <!-- Task Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Tasks</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="clipboard"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($totalTasks) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Completed Tasks</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-success">
                                        <i class="align-middle" data-feather="check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($completedTasks) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Draft Tasks</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-warning">
                                        <i class="align-middle" data-feather="edit"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($draftTasks) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Ongoing Tasks</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-info">
                                        <i class="align-middle" data-feather="play-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($ongoingTasks) }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Country Statistics</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Users</th>
                                    <th>Tasks</th>
                                    <th>Booster Subscriptions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countryStats as $stat)
                                <tr>
                                    <td>{{ $stat['country'] }}</td>
                                    <td>{{ $stat['users'] }}</td>
                                    <td>{{ $stat['tasks'] }}</td>
                                    <td>{{ $stat['booster_subscriptions'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Platforms</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                <i class="align-middle" data-feather="globe"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($totalPlatforms) }}</h1>
                                <div class="mb-0">
                                    <span class="text-success">Most used: {{ $mostUsedPlatform ? $mostUsedPlatform->name : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Templates</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <div class="avatar-title rounded-circle bg-success">
                                                <i class="align-middle" data-feather="layout"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="display-5 mt-1 mb-3">{{ number_format($totalTemplates) }}</h1>
                                <div class="mb-0">
                                    <span class="text-success">Most popular: {{ $mostPopularTemplate ? $mostPopularTemplate->name : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Statistics -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Blog Posts</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="file-text"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($totalBlogPosts) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Views</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-success">
                                        <i class="align-middle" data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($totalViews) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Comments</h5>
                            </div>
                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-info">
                                        <i class="align-middle" data-feather="message-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3">{{ number_format($totalComments) }}</h1>
                    </div>
                </div>
            </div>
        </div>



        <!-- Platforms and Templates -->


        <!-- Countries and Production Ready -->


    </div>
</main>
@endsection