<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">Settings Menu</h6>
    </div>
    <div class="p-0">
        <div class="list-group list-group-flush">
            <a href="{{route('profile')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile') ? 'active' : '' }}">
                <i class="ri-user-line me-3"></i>
                <span>Basic Information</span>
            </a>
            <a href="{{route('profile.bank-account')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile.bank-account') ? 'active' : '' }}">
                <i class="ri-bank-line me-3"></i>
                <span>Bank Accounts</span>
            </a>
            <a href="{{route('profile.verifications')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile.verifications') ? 'active' : '' }}">
                <i class="ri-shield-check-line me-3"></i>
                <span>Verifications</span>
            </a>
            <a href="{{route('profile.interests')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile.interests') ? 'active' : '' }}">
                <i class="ri-heart-line me-3"></i>
                <span>Interests</span>
            </a>
            <a href="{{route('profile.security')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile.security') ? 'active' : '' }}">
                <i class="ri-lock-password-line me-3"></i>
                <span>Security</span>
            </a>
            <a href="{{route('profile.notifications')}}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('profile.notifications')  ? 'active' : '' }}">
                <i class="ri-notification-3-line me-3"></i>
                <span>Notification Settings</span>
            </a>
            <a href="{{route('profile.delete')}}"
                class="list-group-item list-group-item-action d-flex align-items-center text-danger {{ Route::is('profile.delete') ? 'active' : '' }}">
                <i class="ri-delete-bin-line me-3"></i>
                <span>Delete Account</span>
            </a>
        </div>
    </div>
</div>