<div>
    <section class="jumbo-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Top Earners</h1>
                    <p class="lead mb-4">Meet our most successful task workers and get inspired by their achievements</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="tasks.html" class="btn btn-light">Start Earning</a>
                        <a href="register.html" class="btn btn-outline-light">Join Now</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-trophy-fill trophy-icon"></i>
                    <h4 class="text-warning">$1.2M+</h4>
                    <p class="mb-0">Total earned by our top performers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Earners Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title center-title">Top Performers This Month</h2>
                <p class="text-muted">These workers have earned the most completing micro-tasks</p>
            </div>

            <!-- Top 3 Earners -->
            <div class="row mb-5">
                @foreach($topEarners->take(3) as $index => $earner)
                <div class="col-lg-4 mb-4">
                    <div class="earner-card card h-100 position-relative">
                        <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                        <div class="card-body text-center p-4">
                            <img src="{{ $earner->image }}" alt="{{ $earner->username }}" class="earner-avatar mb-3">
                            <h4 class="mb-1">{{ $earner->username }}</h4>
                            <div class="verified-badge mb-2">
                                <i class="bi bi-patch-check-fill"></i> Verified Pro
                            </div>
                            <h3 class="text-success mb-3">{{ $currency }}{{ number_format($earner->wallets->first()?->getBalance() ?? 0, 2) }}</h3>
                            <div class="mb-3">
                                <div class="text-warning mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-muted ms-1">(4.9)</span>
                                </div>
                                <small class="text-muted">{{ $earner->task_workers_count }} tasks completed</small>
                            </div>
                            <div class="mb-3">
                                <span class="skill-tag">Skill 1</span>
                                <span class="skill-tag">Skill 2</span>
                                <span class="skill-tag">Skill 3</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Other Top Earners -->
            <div class="row">
                <div class="col-12 mb-4">
                    <h3 class="section-title">More Top Earners</h3>
                </div>

                @foreach($topEarners->skip(3)->take(4) as $index => $earner)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="earner-card card h-100 position-relative">
                        <div class="rank-badge rank-other">{{ $index + 4 }}</div>
                        <div class="card-body text-center p-4">
                            <img src="{{ $earner->image }}" alt="{{ $earner->username }}" class="earner-avatar mb-3">
                            <h5 class="mb-1">{{ $earner->username }}</h5>
                            <div class="verified-badge mb-2">
                                <i class="bi bi-patch-check-fill"></i> Verified Pro
                            </div>
                            <h4 class="text-success mb-2">{{ $currency }}{{ number_format($earner->wallets->first()?->getBalance() ?? 0, 2) }}</h4>
                            <div class="mb-3">
                                <div class="text-warning mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="text-muted ms-1">(4.9)</span>
                                </div>
                                <small class="text-muted">{{ $earner->task_workers_count }} tasks completed</small>
                            </div>
                            <div class="mb-3">
                                <span class="skill-tag">Skill 1</span>
                                <span class="skill-tag">Skill 2</span>
                                <span class="skill-tag">Skill 3</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title center-title">Platform Earnings Insights</h2>
                <p class="text-muted">See how our community is earning through micro-tasks</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stats-item">
                        <div class="stats-value">{{ number_format($totalTasks) }}</div>
                        <div class="stats-label">Total Tasks</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-item">
                        <div class="stats-value">{{ number_format($totalTaskCompleted) }}</div>
                        <div class="stats-label">Task Completed</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-item">
                        <div class="stats-value">{{ number_format($totalWorkers) }}</div>
                        <div class="stats-label">Total Workers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-item">
                        <div class="stats-value">{{ number_format($totalCreators) }}</div>
                        <div class="stats-label">Total Creators</div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-6">
                    <h4 class="mb-3">Top Earning Categories</h4>
                    @foreach($topCategories as $index => $category)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $category['name'] }}</span>
                            <span>{{ $category['percentage'] }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: {{ $category['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-lg-6">
                    <h4 class="mb-3">Success Tips from Top Earners</h4>
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-lightbulb"></i> Pro Tips</h5>
                            <ul class="mb-0">
                                <li class="mb-2">Specialize in high-demand skills</li>
                                <li class="mb-2">Build a strong portfolio with quality work</li>
                                <li class="mb-2">Communicate clearly with task posters</li>
                                <li class="mb-2">Deliver work before deadlines</li>
                                <li>Ask for reviews and build your reputation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="mb-3">Ready to Start Earning?</h3>
                    <p class="mb-0">Join our community of top earners and start making money with your skills today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="register.html" class="btn btn-light btn-lg me-2">Sign Up Now</a>
                    <a href="tasks.html" class="btn btn-outline-light btn-lg">Browse Tasks</a>
                </div>
            </div>
        </div>
    </section>
</div>