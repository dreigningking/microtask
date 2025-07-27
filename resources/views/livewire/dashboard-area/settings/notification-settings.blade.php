<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-lg font-semibold mb-4">Notification Settings</h2>
    <form>
        <div class="mb-6">
            <h3 class="font-bold mb-2">As Worker</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Email Notifications</h4>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.new_jobs">
                            New jobs in my interests and locations
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.submission_review">
                            My submission review
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.settlement_updates">
                            Settlement updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.blog_updates">
                            Blog updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.withdrawal_payment">
                            Withdrawal payment
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.referral">
                            Referral bonus/updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.task_invitation">
                            Task invitation
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_email.followed_taskmaster_task">
                            Task posted by task masters I follow
                        </label>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">In-app Notifications</h4>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.new_jobs">
                            New jobs in my interests and locations
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.submission_review">
                            My submission review
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.settlement_updates">
                            Settlement updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.blog_updates">
                            Blog updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.withdrawal_payment">
                            Withdrawal payment
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.referral">
                            Referral bonus/updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.task_invitation">
                            Task invitation
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="worker_inapp.followed_taskmaster_task">
                            Task posted by task masters I follow
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-6">
            <h3 class="font-bold mb-2">As Task Master</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold mb-1">Email Notifications</h4>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_email.job_approval">
                            Job approval
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_email.blog_updates">
                            Blog updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_email.task_started">
                            Task started by worker
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_email.task_submitted">
                            Task submitted by worker
                        </label>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-1">In-app Notifications</h4>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_inapp.job_approval">
                            Job approval
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_inapp.blog_updates">
                            Blog updates
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_inapp.task_started">
                            Task started by worker
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" wire:model="taskmaster_inapp.task_submitted">
                            Task submitted by worker
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add more notification settings as needed for the project -->
        <div class="mt-6">
            <button type="button" class="bg-primary text-white px-6 py-2 rounded-button shadow hover:bg-primary/90 transition-colors" wire:click="saveSettings">
                Save
            </button>
            @if($successMessage)
                <div class="text-green-600 mt-2">{{ $successMessage }}</div>
            @endif
        </div>
    </form>
</div>
