<div>
    <!-- Dispute Header -->
    <section class="dispute-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.html" class="text-white">Dashboard</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Dispute Resolution</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning me-2">Under Review</span>
                        <span class="badge bg-light text-dark">Task: #TSK-784512</span>
                    </div>
                    <h1 class="h3 mb-2">Dispute: Work Quality Issues</h1>
                    <p class="mb-0">Social Media Content Creation - Mike Chen vs Sarah Johnson</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="h4 text-warning mb-1">$45</div>
                    <small class="text-white-50">Disputed Amount</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Left Column - Dispute Details & Communication -->
                <div class="col-lg-8">
                    <!-- Task Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Task Details</h5>
                        </div>
                        <div class="card-body">
                            <h6>Description</h6>
                            <p>{{ $task->description }}</p>

                            @if(is_array($task->requirements) && count($task->requirements))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>Requirements</h6>
                                    <ul class="list-unstyled">
                                        @foreach($task->requirements as $requirement)
                                        <li><i class="bi bi-check-circle text-success me-2"></i> {{ $requirement }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            @if($task->template_data && is_array($task->template_data) && count($task->template_data))
                            <div class="mt-4">
                                @foreach($task->template_data as $field)
                                <p class="">
                                <h6 class="fw-medium mb-2">{{ $field['title'] ?? 'Field' }}</h6>
                                @if(isset($field['type']) && $field['type'] === 'file')
                                @if(!empty($field['value']))
                                <a href="{{ asset('storage/' . $field['value']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i> {{ basename($field['value']) }}
                                </a>
                                @else
                                <span class="text-muted small">No file uploaded</span>
                                @endif
                                @else
                                @if(is_array($field['value'] ?? null))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($field['value'] as $item)
                                    <span class="badge bg-light text-dark">{{ $item }}</span>
                                    @endforeach
                                </div>
                                @else
                                <p class="mb-0 small">{{ $field['value'] ?? 'Not provided' }}</p>
                                @endif
                                @endif
                                </p>
                                @endforeach
                            </div>
                            @endif



                            <hr>

                            <div class="mt-4">
                                <h6>Parties Involved in this Dispute</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img src="https://placehold.co/60" alt="Poster" class="rounded-circle me-3">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $task->user->username }}</h6>
                                                <p class="text-muted mb-0">Task Poster</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img src="https://placehold.co/60" alt="Worker" class="rounded-circle me-3">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $taskSubmission->user->username }}</h6>
                                                <p class="text-muted mb-0">Worker</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Communication Thread -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Dispute Communication</h5>
                        </div>
                        <div class="card-body">
                            <!-- Response Form -->
                            <div class="mb-4">
                                <form id="disputeResponseForm">
                                    <div class="mb-3">
                                        <label class="form-label">Add to Discussion</label>
                                        <textarea class="form-control" rows="3" placeholder="Type your response..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Add Evidence (Optional)</label>
                                        <input type="file" class="form-control" multiple>
                                        <div class="form-text">Upload additional screenshots or files to support your case</div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-primary">Send Response</button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#resolutionModal">
                                            Suggest Resolution
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Messages -->
                            <div class="messages-container" style="max-height: 400px; overflow-y: auto;">
                                <div class="message-card message-user p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>Mike Chen (Poster)</strong>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                    <p class="mb-2">The submitted images are only 500x500px instead of the required 1080x1080px. Also, the brand colors were not used as specified in the guidelines.</p>
                                    <div class="evidence-section">
                                        <h6>Evidence</h6>
                                        <div class="d-flex gap-3">
                                            <div class="border rounded p-3 text-center">
                                                <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                                                <div class="small">submitted_work.zip</div>
                                                <button class="btn btn-sm btn-outline-primary mt-2">Download</button>
                                            </div>
                                            <div class="border rounded p-3 text-center">
                                                <i class="bi bi-image fs-1 text-muted"></i>
                                                <div class="small">screenshot_1.png</div>
                                                <button class="btn btn-sm btn-outline-primary mt-2">View</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-card message-other p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>Sarah Johnson (Worker)</strong>
                                        <small class="text-muted">1 hour ago</small>
                                    </div>
                                    <p class="mb-2">I used the correct dimensions but the files might have been compressed during upload. I can provide higher resolution versions. Regarding colors, I used shades close to the specified ones as they worked better visually.</p>
                                    <div class="evidence-section">
                                        <h6>Evidence</h6>
                                        <div class="d-flex gap-3">
                                            <div class="border rounded p-3 text-center">
                                                <i class="bi bi-image fs-1 text-muted"></i>
                                                <div class="small">screenshot_2.png</div>
                                                <button class="btn btn-sm btn-outline-primary mt-2">View</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-card message-admin p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>Admin (Support Team)</strong>
                                        <small class="text-muted">30 minutes ago</small>
                                    </div>
                                    <p class="mb-0">We're reviewing the submitted work against the task requirements. Both parties, please provide any additional evidence or clarification within 24 hours.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Timeline & Actions -->
                <div class="col-lg-4">
                    <!-- Dispute Timeline -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Dispute Timeline</h6>
                        </div>
                        <div class="card-body">
                            <div class="dispute-timeline">
                                <div class="timeline-item">
                                    <strong>Dispute Raised</strong>
                                    <p class="text-muted mb-0 small">Mike Chen raised dispute for poor quality work</p>
                                    <small class="text-muted">Oct 15, 2023 • 2:30 PM</small>
                                </div>
                                <div class="timeline-item">
                                    <strong>Under Review</strong>
                                    <p class="text-muted mb-0 small">Admin team started reviewing the case</p>
                                    <small class="text-muted">Oct 15, 2023 • 3:15 PM</small>
                                </div>
                                <div class="timeline-item">
                                    <strong>Response Requested</strong>
                                    <p class="text-muted mb-0 small">Both parties asked to provide additional information</p>
                                    <small class="text-muted">Oct 15, 2023 • 4:00 PM</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolution Options -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Possible Resolutions</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resolutionOption" id="option1">
                                    <label class="form-check-label" for="option1">
                                        Full refund to poster ($45)
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resolutionOption" id="option2">
                                    <label class="form-check-label" for="option2">
                                        Partial refund ($25 to poster, $20 to worker)
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resolutionOption" id="option3">
                                    <label class="form-check-label" for="option3">
                                        Worker revises work (3-day extension)
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resolutionOption" id="option4">
                                    <label class="form-check-label" for="option4">
                                        Full payment to worker ($45)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions (Visible only to admin) -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Admin Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-download"></i> Download All Files
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-clock"></i> Extend Response Time
                                </button>
                                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#resolveModal">
                                    <i class="bi bi-check-circle"></i> Resolve Dispute
                                </button>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Escalate to Senior
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <!-- Suggest Resolution Modal -->
    <div class="modal fade" id="resolutionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suggest Resolution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>What resolution would you suggest for this dispute?</p>
                    <div class="mb-3">
                        <label class="form-label">Your Suggestion</label>
                        <select class="form-select">
                            <option value="">Select a resolution</option>
                            <option value="refund">Full refund to me</option>
                            <option value="partial">Partial refund</option>
                            <option value="revision">Allow revision of work</option>
                            <option value="payment">Full payment to worker</option>
                            <option value="other">Other solution</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Exboosteration</label>
                        <textarea class="form-control" rows="3" placeholder="Explain why you think this is the fair resolution..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Submit Suggestion</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Resolve Dispute Modal (Admin Only) -->
    <div class="modal fade" id="resolveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resolve Dispute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Final Resolution</label>
                        <select class="form-select">
                            <option value="">Select resolution</option>
                            <option value="full-refund">Full refund to poster</option>
                            <option value="partial-refund">Partial refund</option>
                            <option value="revision">Worker revises work</option>
                            <option value="full-payment">Full payment to worker</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Resolution Details</label>
                        <textarea class="form-control" rows="4" placeholder="Explain the decision and reasoning..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount to Poster</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" value="25">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount to Worker</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" value="20">
                        </div>
                    <div class="form-text">Total: $45 (Platform fee waived for disputes)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">Finalize Resolution</button>
                </div>
            </div>
        </div>
    </div>
</div>
