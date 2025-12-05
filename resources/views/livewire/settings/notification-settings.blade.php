<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h4 mb-0">Profile Settings</h1>
                    <p class="mb-0">Manage your account information, security, and preferences</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="earnings.html" class="btn btn-outline-light">Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    @include('livewire.settings.menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-notification-3-line me-2"></i>Notification Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <h5 class="mb-4">Notification Settings</h5>

                                <form wire:submit.prevent="saveSettings">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="ri-user-line me-2"></i>As Worker
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="fw-semibold mb-3">Email Notifications</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.new_jobs" class="form-check-input ms-0" id="worker_email_new_jobs">
                                                            <label class="form-check-label ms-2" for="worker_email_new_jobs">
                                                                New jobs in my interests and locations
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.submission_review" class="form-check-input ms-0" id="worker_email_submission_review">
                                                            <label class="form-check-label ms-2" for="worker_email_submission_review">
                                                                My submission review
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.settlement_updates" class="form-check-input ms-0" id="worker_email_settlement_updates">
                                                            <label class="form-check-label ms-2" for="worker_email_settlement_updates">
                                                                Settlement updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.blog_updates" class="form-check-input ms-0" id="worker_email_blog_updates">
                                                            <label class="form-check-label ms-2" for="worker_email_blog_updates">
                                                                Blog updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.withdrawal_payment" class="form-check-input ms-0" id="worker_email_withdrawal_payment">
                                                            <label class="form-check-label ms-2" for="worker_email_withdrawal_payment">
                                                                Withdrawal payment
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.referral" class="form-check-input ms-0" id="worker_email_referral">
                                                            <label class="form-check-label ms-2" for="worker_email_referral">
                                                                Referral bonus/updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.task_invitation" class="form-check-input ms-0" id="worker_email_task_invitation">
                                                            <label class="form-check-label ms-2" for="worker_email_task_invitation">
                                                                Task invitation
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_email.followed_taskmaster_task" class="form-check-input ms-0" id="worker_email_followed_taskmaster_task">
                                                            <label class="form-check-label ms-2" for="worker_email_followed_taskmaster_task">
                                                                Task posted by task masters I follow
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="fw-semibold mb-3">In-app Notifications</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.new_jobs" class="form-check-input ms-0" id="worker_inapp_new_jobs">
                                                            <label class="form-check-label ms-2" for="worker_inapp_new_jobs">
                                                                New jobs in my interests and locations
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.submission_review" class="form-check-input ms-0" id="worker_inapp_submission_review">
                                                            <label class="form-check-label ms-2" for="worker_inapp_submission_review">
                                                                My submission review
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.settlement_updates" class="form-check-input ms-0" id="worker_inapp_settlement_updates">
                                                            <label class="form-check-label ms-2" for="worker_inapp_settlement_updates">
                                                                Settlement updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.blog_updates" class="form-check-input ms-0" id="worker_inapp_blog_updates">
                                                            <label class="form-check-label ms-2" for="worker_inapp_blog_updates">
                                                                Blog updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.withdrawal_payment" class="form-check-input ms-0" id="worker_inapp_withdrawal_payment">
                                                            <label class="form-check-label ms-2" for="worker_inapp_withdrawal_payment">
                                                                Withdrawal payment
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.referral" class="form-check-input ms-0" id="worker_inapp_referral">
                                                            <label class="form-check-label ms-2" for="worker_inapp_referral">
                                                                Referral bonus/updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.task_invitation" class="form-check-input ms-0" id="worker_inapp_task_invitation">
                                                            <label class="form-check-label ms-2" for="worker_inapp_task_invitation">
                                                                Task invitation
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="worker_inapp.followed_taskmaster_task" class="form-check-input ms-0" id="worker_inapp_followed_taskmaster_task">
                                                            <label class="form-check-label ms-2" for="worker_inapp_followed_taskmaster_task">
                                                                Task posted by task masters I follow
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="ri-briefcase-line me-2"></i>As Task Master
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="fw-semibold mb-3">Email Notifications</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_email.job_approval" class="form-check-input ms-0" id="taskmaster_email_job_approval">
                                                            <label class="form-check-label ms-2" for="taskmaster_email_job_approval">
                                                                Job approval
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_email.blog_updates" class="form-check-input ms-0" id="taskmaster_email_blog_updates">
                                                            <label class="form-check-label ms-2" for="taskmaster_email_blog_updates">
                                                                Blog updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_email.task_started" class="form-check-input ms-0" id="taskmaster_email_task_started">
                                                            <label class="form-check-label ms-2" for="taskmaster_email_task_started">
                                                                Task started by worker
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_email.task_submitted" class="form-check-input ms-0" id="taskmaster_email_task_submitted">
                                                            <label class="form-check-label ms-2" for="taskmaster_email_task_submitted">
                                                                Task submitted by worker
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="fw-semibold mb-3">In-app Notifications</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_inapp.job_approval" class="form-check-input ms-0" id="taskmaster_inapp_job_approval">
                                                            <label class="form-check-label ms-2" for="taskmaster_inapp_job_approval">
                                                                Job approval
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_inapp.blog_updates" class="form-check-input ms-0" id="taskmaster_inapp_blog_updates">
                                                            <label class="form-check-label ms-2" for="taskmaster_inapp_blog_updates">
                                                                Blog updates
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_inapp.task_started" class="form-check-input ms-0" id="taskmaster_inapp_task_started">
                                                            <label class="form-check-label ms-2" for="taskmaster_inapp_task_started">
                                                                Task started by worker
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="taskmaster_inapp.task_submitted" class="form-check-input ms-0" id="taskmaster_inapp_task_submitted">
                                                            <label class="form-check-label ms-2" for="taskmaster_inapp_task_submitted">
                                                                Task submitted by worker
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Save Settings
                                        </button>
                                    </div>

                                    @if($successMessage)
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                        <i class="ri-check-line me-2"></i>{{ $successMessage }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>