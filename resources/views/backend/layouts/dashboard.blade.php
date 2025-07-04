@extends('backend.layouts.app')

@section('content')
<div class="wrapper">
    <nav id="sidebar" class="sidebar">
        <a class="sidebar-brand py-2" href="{{ route('admin.dashboard') }}">
            <img src="{{asset('frontend/images/logo.png')}}" alt="" style="height:40px;">
        </a>
        <div class="sidebar-content">
            <div class="sidebar-user">
                <img src="{{ auth()->user()->image }}" class="img-fluid rounded-circle mb-2" alt="Linda Miller" />
                <div class="font-weight-bold">{{ auth()->user()->name }}</div>
                <small>{{ auth()->user()->email }}</small>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Main
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle mr-2 fas fa-fw fa-home"></i> 
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#tasks" data-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle mr-2 fas fa-fw fa-check-square"></i> <span class="align-middle">Tasks</span>
                    </a>
                    <ul id="tasks" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.tasks.index') }}">Task List</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.tasks.promotions') }}">Task Promotions</a></li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#finance" data-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle mr-2 fas fa-fw fa-credit-card"></i> <span class="align-middle">Finance</span>
                    </a>
                    <ul id="finance" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.earnings.index') }}">Earnings</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.payments.index') }}">Payments</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.exchanges.index') }}">Exchanges</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.withdrawals.index') }}">Withdrawals</a></li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#users" data-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle mr-2 fas fa-fw fa-users"></i> <span class="align-middle">User Management</span>
                    </a>
                    <ul id="users" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.users.verifications') }}">Verifications</a></li>
                    </ul>
                </li>
                
                <li class="sidebar-item">
                    <a href="#users" data-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle mr-2 fas fa-fw fa-book"></i> <span class="align-middle">Blog Management</span>
                    </a>
                    <ul id="users" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.blog.index') }}">All Posts</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.blog.create') }}">Create Post</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.blog.comments.index') }}">Comments</a></li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#dashboards" data-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle mr-2 fas fa-fw fa-cog"></i> 
                        <span class="align-middle">Settings</span>
                    </a>
                    <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.index') }}">General</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.plans') }}">Plans</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.platforms') }}">Platforms</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.templates') }}">Templates</a></li>                       
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.countries') }}">Countries</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main">
        <nav class="navbar navbar-expand navbar-theme">
            <a class="sidebar-toggle d-flex mr-2">
                <i class="hamburger align-self-center"></i>
            </a>

            <form class="form-inline d-none d-sm-inline-block">
                <input class="form-control form-control-lite" type="text" placeholder="Search tasks...">
            </form>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="messagesDropdown" data-toggle="dropdown">
                            <i class="align-middle fas fa-envelope-open"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="messagesDropdown">
                            <div class="dropdown-menu-header">
                                <div class="position-relative">
                                    4 New Messages
                                </div>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('backend/img/avatars/avatar-5.jpg') }}" class="avatar img-fluid rounded-circle" alt="Michelle Bilodeau">
                                        </div>
                                        <div class="col-10 pl-2">
                                            <div class="text-dark">Michelle Bilodeau</div>
                                            <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
                                            <div class="text-muted small mt-1">5m ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('backend/img/avatars/avatar-3.jpg') }}" class="avatar img-fluid rounded-circle" alt="Kathie Burton">
                                        </div>
                                        <div class="col-10 pl-2">
                                            <div class="text-dark">Kathie Burton</div>
                                            <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
                                            <div class="text-muted small mt-1">30m ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('backend/img/avatars/avatar-2.jpg') }}" class="avatar img-fluid rounded-circle" alt="Alexander Groves">
                                        </div>
                                        <div class="col-10 pl-2">
                                            <div class="text-dark">Alexander Groves</div>
                                            <div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
                                            <div class="text-muted small mt-1">2h ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('backend/img/avatars/avatar-4.jpg') }}" class="avatar img-fluid rounded-circle" alt="Daisy Seger">
                                        </div>
                                        <div class="col-10 pl-2">
                                            <div class="text-dark">Daisy Seger</div>
                                            <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
                                            <div class="text-muted small mt-1">5h ago</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-menu-footer">
                                <a href="#" class="text-muted">Show all messages</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown ml-lg-2">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown" data-toggle="dropdown">
                            <i class="align-middle fas fa-bell"></i>
                            <span class="indicator"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
                            <div class="dropdown-menu-header">
                                4 New Notifications
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-danger fas fa-fw fa-bell"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Update completed</div>
                                            <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                                            <div class="text-muted small mt-1">2h ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-warning fas fa-fw fa-envelope-open"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Lorem ipsum</div>
                                            <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
                                            <div class="text-muted small mt-1">6h ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-primary fas fa-fw fa-building"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">Login from 192.186.1.1</div>
                                            <div class="text-muted small mt-1">8h ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <i class="ml-1 text-success fas fa-fw fa-bell-slash"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">New connection</div>
                                            <div class="text-muted small mt-1">Anna accepted your request.</div>
                                            <div class="text-muted small mt-1">12h ago</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-menu-footer">
                                <a href="#" class="text-muted">Show all notifications</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown ml-lg-2">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-toggle="dropdown">
                            <i class="align-middle fas fa-cog"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="align-middle mr-1 fas fa-fw fa-user"></i> View Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="align-middle mr-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>

        </nav>
        @yield('main')
        <svg width="0" height="0" style="position:absolute">
            <defs>
                <symbol viewBox="0 0 512 512" id="ion-ios-pulse-strong">
                    <path
                        d="M448 273.001c-21.27 0-39.296 13.999-45.596 32.999h-38.857l-28.361-85.417a15.999 15.999 0 0 0-15.183-10.956c-.112 0-.224 0-.335.004a15.997 15.997 0 0 0-15.049 11.588l-44.484 155.262-52.353-314.108C206.535 54.893 200.333 48 192 48s-13.693 5.776-15.525 13.135L115.496 306H16v31.999h112c7.348 0 13.75-5.003 15.525-12.134l45.368-182.177 51.324 307.94c1.229 7.377 7.397 11.92 14.864 12.344.308.018.614.028.919.028 7.097 0 13.406-3.701 15.381-10.594l49.744-173.617 15.689 47.252A16.001 16.001 0 0 0 352 337.999h51.108C409.973 355.999 427.477 369 448 369c26.511 0 48-22.492 48-49 0-26.509-21.489-46.999-48-46.999z">
                    </path>
                </symbol>
            </defs>
        </svg>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-8 text-left">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Support</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Privacy</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Terms of Service</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4 text-right">
                        <p class="mb-0">
                            &copy; {{ now()->format('Y') }} - <a href="{{ route('admin.dashboard') }}" class="text-muted">Wonegig</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection