<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="tasks.html" class="text-white">Browse Tasks</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Task Details</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2">Active</span>
                        <span class="badge bg-light text-dark">Social Media</span>
                    </div>
                    <h1 class="h3 mb-2">Create 5 Instagram Posts for Coffee Shop</h1>
                    <div class="d-flex align-items-center text-white-50">
                        <span class="me-3"><i class="bi bi-people"></i> 12 submissions received</span>
                        <span><i class="bi bi-clock"></i> 3 days left</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="h2 text-warning mb-1">$45</div>
                    <small class="text-white-50">Per approved submission • Multiple submissions allowed</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <!-- Left Column - Task Details -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Task Details</h5>
                        </div>
                        <div class="card-body">
                            <h6>Description</h6>
                            <p>I need 5 engaging Instagram posts created for my coffee shop "Brew & Bean". The posts should reflect our brand aesthetic - minimalist, warm, and inviting.</p>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>Requirements</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-check-circle text-success me-2"></i> Image size: 1080x1080px</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i> Format: JPEG or PNG</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i> Brand colors: #8B4513, #DEB887</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i> Include caption & hashtags</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>Submission Information</h6>
                                <div class="d-flex justify-content-between">
                                    <span>Submissions Needed:</span>
                                    <strong>5 total</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Multiple Submissions:</span>
                                    <strong>Allowed</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Your Submissions:</span>
                                    <strong>2 (1 pending, 1 approved)</strong>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>Attachments</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> brand_guidelines.pdf
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> logo.png
                                    </button>
                                </div>
                            </div>


                            <div class="mt-4">
                                <h6>About the Poster</h6>
                                <div class="d-flex align-items-center">
                                    <img src="https://placehold.co/60" alt="Poster" class="rounded-circle me-3">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Mike Chen</h5>
                                        <div class="text-warning mb-2">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <span class="text-muted">(4.0) • 12 tasks posted</span>
                                        </div>
                                        <p class="text-muted mb-0">Member since {{ $task->user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- My Submissions -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">My Submissions</h5>
                            <span class="badge bg-primary">2 submissions</span>
                        </div>
                        <div class="card-body">
                            <!-- Submission 1 - Approved -->
                            <div class="submission-history-card status-approved p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">Submission #1</h6>
                                        <p class="text-muted mb-2">Submitted: October 12, 2023</p>
                                    </div>
                                    <span class="badge bg-success">Approved & Paid</span>
                                </div>

                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle"></i> This submission was approved and you received $45.
                                    <div class="mt-2">
                                        <strong>Client Rating:</strong>
                                        <span class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <strong>Client Review:</strong> "Excellent work! Exactly what I was looking for. Will hire again!"
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View Submission Details
                                </button>
                            </div>

                            <!-- Submission 2 - Pending -->
                            <div class="submission-history-card status-pending p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">Submission #2</h6>
                                        <p class="text-muted mb-2">Submitted: October 15, 2023 (2 hours ago)</p>
                                    </div>
                                    <span class="badge bg-warning">Pending Review</span>
                                </div>

                                <p class="mb-2"><strong>Submission Notes:</strong> "I've created 5 Instagram posts following your brand guidelines. Each post includes high-quality images, engaging captions about coffee culture, and relevant hashtags."</p>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View Submission
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit Submission
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Withdraw
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">
                    <!-- BEFORE APPLYING -->
                    <div class="card mb-4" id="beforeApplySection">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Apply for this Task</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" wire:model.live="agreementAccepted" class="form-check-input" id="agreement">
                                <label class="form-check-label text-muted" for="agreement" style="text-align: justify;">
                                    I agree to complete this task according to the requirements and submit my work within the estimated time frame.
                                </label>
                            </div>
                            <button
                                wire:click="startTask"
                                class="btn btn-primary w-100 mt-3"
                                @if(!$agreementAccepted) disabled @endif>
                                <i class="fas fa-play me-2"></i>
                                Submit Application
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> Your have applied for this task! Please submit your work before the deadline.
                            </div>
                            <button class="btn btn-outline-secondary w-100 mt-3">
                                Withdraw Application
                            </button>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Report Task</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Find something inappropriate in this task?
                                Kindly report to admin immediately</p>

                            <button class="btn btn-warning w-100">
                                Report
                            </button>
                        </div>
                    </div>

                    <!-- AFTER ACCEPTANCE (Hidden by default) -->
                    <div class="card" id="afterAcceptanceSection">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Submit Your Work</h5>
                        </div>
                        <div class="card-body">

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Multiple submissions are allowed for this task. You can submit different versions or improvements.
                            </div>

                            <div class="submission-form-card p-3">
                                <form id="workSubmissionForm">
                                    <div class="mb-3">
                                        <label class="form-label">Work Submission *</label>
                                        <div class="upload-area p-4 text-center" id="uploadArea">
                                            <i class="bi bi-cloud-arrow-up fs-1 text-muted d-block mb-2"></i>
                                            <p class="mb-2">Drag & drop your files here or click to browse</p>
                                            <small class="text-muted">Max file size: 50MB • Supported formats: ZIP, PDF, JPG, PNG, PSD</small>
                                            <input type="file" class="d-none" id="fileInput" multiple>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="document.getElementById('fileInput').click()">
                                                Select Files
                                            </button>
                                        </div>
                                        <div id="fileList" class="mt-3"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Submission Notes *</label>
                                        <textarea class="form-control" rows="3" placeholder="Describe what you've delivered and any important information..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Links (Optional)</label>
                                        <input type="url" class="form-control mb-2" placeholder="https://example.com">
                                        <input type="url" class="form-control" placeholder="https://example.com">
                                        <div class="form-text">Add links to online work, Google Drive, Dropbox, etc.</div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <h6><i class="bi bi-exclamation-triangle"></i> Before Submitting</h6>
                                        <ul class="mb-0 small">
                                            <li>Ensure all requirements are met</li>
                                            <li>Double-check file formats and sizes</li>
                                            <li>Verify links are accessible</li>
                                            <li>You can't edit submission after sending</li>
                                        </ul>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-send"></i> Submit Work
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Task Stats -->

                </div>


            </div>
        </div>
    </section>
</div>
@push('scripts')
<script>
    // File upload functionality
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadArea.classList.add('dragover');
        }

        function unhighlight() {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'd-flex justify-content-between align-items-center border rounded p-2 mb-2';
                fileItem.innerHTML = `
                        <div>
                            <i class="bi bi-file-earmark me-2"></i>
                            ${file.name}
                            <small class="text-muted d-block">(${(file.size / (1024 * 1024)).toFixed(2)} MB)</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                fileList.appendChild(fileItem);
            }
        }

        // Form submission
        document.getElementById('workSubmissionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Work submitted successfully! The task poster will review your submission.');
            // In real implementation, this would send data to server
        });
    });
</script>
@endpush