<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Dashboard</h1>
                    <p class="mb-0">Welcome back, John! Here's your dual-role activity overview.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>

                </div>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <!-- DUAL ROLE DASHBOARD SECTION - MOVED TO TOP -->
            <div class="row mb-4">
                <div class="col-lg-12 mb-4">
                    <div class="dashboard-card card">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-megaphone"></i> Announcements</h6>
                        </div>
                        <div class="card-body">
                            <div class="announcement-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-warning">Maintenance Scheduled</h6>
                                    <small class="text-muted">1 week ago</small>
                                </div>
                                <p class="mb-0 small text-muted">Scheduled maintenance on March 10th from 2-4 AM UTC. Platform may be briefly unavailable.</p>
                            </div>
                            <div class="announcement-item border rounded p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-success">Welcome Bonus Extended</h6>
                                    <small class="text-muted">2 weeks ago</small>
                                </div>
                                <p class="mb-0 small text-muted">New users now receive $25 welcome bonus instead of $10. Limited time offer!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Creator Dashboard (Left Column) -->
                <div class="col-lg-6">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-person-plus text-primary"></i> Creator Dashboard</h5>

                        </div>
                        <div class="card-body">
                            <!-- Creator Statistics -->
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-plus-circle text-primary fs-1 mb-2"></i>
                                        <h3>15</h3>
                                        <p class="mb-0">Tasks Posted</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                                        <h3>8</h3>
                                        <p class="mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-currency-dollar text-warning fs-1 mb-2"></i>
                                        <h3>$650</h3>
                                        <p class="mb-0">Money Spent</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-star text-warning fs-1 mb-2"></i>
                                        <h3>4.7</h3>
                                        <p class="mb-0">Active Workers</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-star text-warning fs-1 mb-2"></i>
                                        <h3>4.7</h3>
                                        <p class="mb-0">Review Pending</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card p-4 text-center">
                                        <i class="bi bi-star text-warning fs-1 mb-2"></i>
                                        <h3>4.7</h3>
                                        <p class="mb-0">Refundables</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Creator Actions -->
                            <div class="d-grid gap-2 mb-3">
                                <button class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-2"></i>Create New Task
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-gear me-2"></i>Manage Posted Tasks
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-people me-2"></i>View Applications
                                </button>
                            </div>

                            <!-- Creator Quick Insights -->
                            <div class="border rounded p-3">
                                <h6 class="mb-2">Creator Insights</h6>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Avg. Completion Time:</span>
                                    <strong>2.5 days</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Success Rate:</span>
                                    <strong>85%</strong>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span>Active Workers:</span>
                                    <strong>12</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Worker Dashboard (Right Column) -->
                <div class="col-lg-6">
                    <div class="dashboard-card card h-100">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-person-check text-success"></i> Worker Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <!-- Worker Statistics -->
                            <div class="row g-3 mb-4">
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-send text-success fs-1 mb-2"></i>
                                        <h3>23</h3>
                                        <p class="mb-0">Applied Task</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-check2-circle text-primary fs-1 mb-2"></i>
                                        <h3>18</h3>
                                        <p class="mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                                        <h3>$890</h3>
                                        <p class="mb-0">Money Earned</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-trophy text-warning fs-1 mb-2"></i>
                                        <h3>92%</h3>
                                        <p class="mb-0">Submissions</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                                        <h3>$890</h3>
                                        <p class="mb-0">Pending Review</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="stat-card worker p-4 text-center">
                                        <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                                        <h3>$890</h3>
                                        <p class="mb-0">Rejected</p>
                                    </div>
                                </div>


                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button class="btn btn-info text-white">
                                    <i class="bi bi-search me-2"></i>Browse Tasks
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-clock me-2"></i>Track Applications
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-card-list me-2"></i>Task History
                                </button>
                            </div>

                            <!-- Worker Quick Insights -->
                            <div class="border rounded p-3">
                                <h6 class="mb-2">Worker Insights</h6>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Avg. Task Value:</span>
                                    <strong>$49</strong>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Response Time:</span>
                                    <strong>1.2 hours</strong>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span>Specialization:</span>
                                    <strong>Design & Writing</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Sections Row -->
            <div class="row mb-4">
                <!-- Subscription Status -->
                <div class="col-lg-12">
                    <!-- Booster Subscriptions -->
                    <div class="dashboard-card card mb-4 position-relative">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-rocket"></i> Active Subscriptions</h5>
                            <div class="text-end">
                                <a href="subscriptions.html" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="bi bi-gear"></i> Manage
                                </a>
                                <a href="boosters.html" class="btn btn-primary btn-sm">
                                    <i class="bi bi-arrow-up"></i> Upgrade
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Worker Subscription -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0"><i class="bi bi-person-check text-success"></i> Worker Subscription</h6>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                        <p class="text-muted small mb-2">Basic Worker Plan - Unlimited task applications</p>
                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 70%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>7 of 10 tasks applied</span>
                                            <span>Expires: Mar 15, 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Taskmaster Subscription -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0"><i class="bi bi-person-plus text-primary"></i> Taskmaster Subscription</h6>
                                            <span class="badge bg-primary">Active</span>
                                        </div>
                                        <p class="text-muted small mb-2">Basic Taskmaster Plan - Up to 5 tasks per month</p>
                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: 40%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>2 of 5 tasks posted</span>
                                            <span>Expires: Mar 20, 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-5">
                            <div class="dashboard-card card">
                                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-bell"></i> Recent Notifications</h5>
                                    <a href="notifications.html" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="bi bi-plus-circle text-primary me-2"></i>
                                                <span>You posted "Logo Design Contest" - 5 applications received</span>
                                            </div>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <span>Your application for "Social Media Posts" was accepted</span>
                                            </div>
                                            <small class="text-muted">4 hours ago</small>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="bi bi-currency-dollar text-warning me-2"></i>
                                                <span>You earned $75 for "Data Analysis Report" (as worker)</span>
                                            </div>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="bi bi-people text-info me-2"></i>
                                                <span>Sarah joined using your referral link</span>
                                            </div>
                                            <small class="text-muted">2 days ago</small>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="bi bi-star text-warning me-2"></i>
                                                <span>You received a 5-star review from Mike Chen</span>
                                            </div>
                                            <small class="text-muted">3 days ago</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="dashboard-card card">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0"><i class="bi bi-gift"></i> Invite & Earn</h6>
                                </div>
                                <div class="card-body">
                                    <p class="small text-muted">Invite friends and earn 10% of their first 10 task earnings!</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="https://microtasker.com/ref/johndoe" id="referralLink" readonly>
                                        <button class="btn btn-outline-primary" type="button" id="copyLink">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Total Invites:</span>
                                        <strong>5</strong>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span>Earned from Referrals:</span>
                                        <strong class="text-success">$24.50</strong>
                                    </div>
                                    <a href="invitees.html" class="btn btn-sm btn-outline-success w-100 mt-2">View Invitees</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="dashboard-card card">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0"><i class="bi bi-headset"></i> Need Help?</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="support.html" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-question-circle"></i> Help Center
                                        </a>
                                        <a href="support.html?action=new" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> Create Support Ticket
                                        </a>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between small">
                                            <span>Open Tickets:</span>
                                            <strong>2</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>Open Dispute:</span>
                                            <strong>1</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>Recent Response:</span>
                                            <span class="text-success">24 hours ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>