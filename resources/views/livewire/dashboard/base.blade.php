<div>
    <section class="bg-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-2">Dashboard</h1>
                    <p class="mb-0 text-muted">Welcome back, John! Here's your activity overview.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <a href="my-tasks.html" class="btn btn-outline-primary">Tasks Monitor Dashboard</a>
                        <a href="applied-tasks.html" class="btn btn-outline-primary">Tasks Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Quick Stats -->
                <div class="col-12 mb-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="stat-card p-4 text-center">
                                <i class="bi bi-wallet2 fs-1 mb-2"></i>
                                <h3>$247.50</h3>
                                <p class="mb-0">Total Earnings</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-4 text-center">
                                <i class="bi bi-check-circle fs-1 mb-2"></i>
                                <h3>8</h3>
                                <p class="mb-0">Tasks Completed</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-4 text-center">
                                <i class="bi bi-people fs-1 mb-2"></i>
                                <h3>5</h3>
                                <p class="mb-0">Invitees</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-4 text-center">
                                <i class="bi bi-star fs-1 mb-2"></i>
                                <h3>4.8</h3>
                                <p class="mb-0">Your Rating</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-lg-8">
                    <!-- Subscription Status -->
                    <div class="dashboard-card card mb-4 position-relative">
                        <span class="subscription-badge badge bg-warning text-dark">Basic Booster</span>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="card-title">Current Subscription: Basic Booster</h5>
                                    <p class="card-text text-muted">You can apply for up to 10 tasks per month. Upgrade to unlock more features.</p>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 70%"></div>
                                    </div>
                                    <small class="text-muted">7 of 10 tasks applied this month</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="subscriptions.html" class="btn btn-primary">Upgrade Booster</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="quick-action-card card h-100 text-center p-4" onclick="location.href='tasks.html'">
                                <i class="bi bi-search text-primary fs-1 mb-3"></i>
                                <h5>Find Tasks</h5>
                                <p class="text-muted small">Browse available tasks to earn money</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="quick-action-card card h-100 text-center p-4" onclick="location.href='invitees.html'">
                                <i class="bi bi-person-plus text-success fs-1 mb-3"></i>
                                <h5>Invite Friends</h5>
                                <p class="text-muted small">Earn rewards when friends join</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Recommended For You</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Recommended Task 1 -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">Social Media Content Creation</h6>
                                            <p class="text-muted mb-0 small">Create 10 engaging posts for Instagram</p>
                                            <div class="mt-2">
                                                <span class="badge bg-success">Social Media</span>
                                                <span class="badge bg-warning text-dark">$75</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-sm">Apply Now</button>
                                    </div>
                                </div>
                                <!-- Recommended Task 2 -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">Data Analysis Report</h6>
                                            <p class="text-muted mb-0 small">Analyze sales data and create insights report</p>
                                            <div class="mt-2">
                                                <span class="badge bg-primary">Data Entry</span>
                                                <span class="badge bg-warning text-dark">$120</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-sm">Apply Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="dashboard-card card">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Activity</h5>
                            <a href="notifications.html" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <span>Your application for "Logo Design" was accepted</span>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="bi bi-currency-dollar text-primary me-2"></i>
                                        <span>You earned $45 for "Social Media Posts"</span>
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

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Profile Summary -->
                    <div class="dashboard-card card mb-4">
                        <div class="card-body text-center">
                            <img src="https://via.placeholder.com/80" alt="John Doe" class="rounded-circle mb-3">
                            <h5>John Doe</h5>
                            <p class="text-muted">Freelance Designer & Writer</p>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted">(4.5)</span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>

                    <!-- Invite & Earn -->
                    <div class="dashboard-card card mb-4">
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
                            <div class="d-flex justify-content-between small">
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

                    <!-- Support Quick Links -->
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
                                    <span>Recent Response:</span>
                                    <span class="text-success">24 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>