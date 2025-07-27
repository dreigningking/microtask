<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Skill;
use App\Models\Platform;
use App\Models\TaskWorker;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\UserLocation;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'dob',
        'gender',
        'is_active',
        'dashboard_view', // Added for dashboard preference
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function sluggable(): array
    {
        return [
            'username' => [
                'source' => 'encrypted_name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function getEncryptedNameAttribute()
    {
        // Otherwise, generate a unique identifier (e.g., 'user' + 8 random alphanumeric chars)
        // You can adjust the length or prefix as needed
        $unique = 'user' . substr(bin2hex(random_bytes(5)), 0, 8);
        return $unique;
    }

    public function getImageAttribute(){
        return "https://ui-avatars.com/api/?name=".urlencode($this->name)."&background=random";
    }

    public function preferred_locations()
    {
        return $this->hasMany(UserLocation::class);
    }

    public function preferred_platforms(){
        return $this->belongsToMany(Platform::class);
    }

    public function country()
    {
        return $this->setConnection('sqlite_countries')->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->setConnection('sqlite_states')->belongsTo(State::class);
    }
    public function city()
    {
        return $this->setConnection('sqlite_cities')->belongsTo(City::class);   
    }
    public function bank_account()
    {
        return $this->hasOne(BankAccount::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function task_promotions()
    {
        return $this->hasMany(TaskPromotion::class);
    }
    public function task_workers()
    {
        return $this->hasMany(TaskWorker::class);
    }
    

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function getFirstRoleAttribute()
    {
        return $this->roles->first();
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class)->where('starts_at','<',now())->where('expires_at', '>', now());
    }

    public function pendingSubscriptions(){
        return $this->hasMany(Subscription::class)->where('starts_at','>',now())->where('expires_at', '>', now());
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Check if the user has completed and approved all required verifications for their country.
     */
    public function isVerified(): bool
    {
        // Get the verification requirements from country settings
        $countrySetting = $this->country && $this->country->setting ? $this->country->setting : null;
        if (!$countrySetting || empty($countrySetting->verification_fields)) {
            // If no requirements, treat as not verified
            return false;
        }

        $requirements = $countrySetting->verification_fields;
        if (!is_array($requirements)) {
            $requirements = json_decode($requirements, true);
        }
        if (!$requirements || !is_array($requirements)) {
            return false;
        }

        // Fetch all user verifications (approved) and key by document_name
        $approvedVerifications = $this->hasMany(\App\Models\UserVerification::class)
            ->where('status', 'approved')
            ->get()
            ->keyBy('document_name');

        foreach ($requirements as $docType => $req) {
            $docs = $req['docs'] ?? [];
            $mode = $req['mode'] ?? 'all';

            if ($mode === 'all') {
                // All docs in this group must be approved
                foreach ($docs as $docName) {
                    if (!isset($approvedVerifications[$docName])) {
                        return false;
                    }
                }
            } elseif ($mode === 'one') {
                // At least one doc in this group must be approved
                $hasOne = false;
                foreach ($docs as $docName) {
                    if (isset($approvedVerifications[$docName])) {
                        $hasOne = true;
                        break;
                    }
                }
                if (!$hasOne) {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * Attribute: getIsVerifiedAttribute
     * Usage: $user->is_verified
     */
    public function getIsVerifiedAttribute(): bool
    {
        // Get the verification requirements from country settings
        $countrySetting = $this->country && $this->country->setting ? $this->country->setting : null;
        if (!$countrySetting || empty($countrySetting->verification_fields)) {
            // If no requirements, treat as not verified
            return false;
        }

        $requirements = $countrySetting->verification_fields;
        if (!is_array($requirements)) {
            $requirements = json_decode($requirements, true);
        }
        if (!$requirements || !is_array($requirements)) {
            return false;
        }

        // Fetch all user verifications (approved) and key by document_name
        $approvedVerifications = $this->hasMany(\App\Models\UserVerification::class)
            ->where('status', 'approved')
            ->get()
            ->keyBy('document_name');

        foreach ($requirements as $docType => $req) {
            $docs = $req['docs'] ?? [];
            $mode = $req['mode'] ?? 'all';

            if ($mode === 'all') {
                // All docs in this group must be approved
                foreach ($docs as $docName) {
                    if (!isset($approvedVerifications[$docName])) {
                        return false;
                    }
                }
            } elseif ($mode === 'one') {
                // At least one doc in this group must be approved
                $hasOne = false;
                foreach ($docs as $docName) {
                    if (isset($approvedVerifications[$docName])) {
                        $hasOne = true;
                        break;
                    }
                }
                if (!$hasOne) {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * Check if the user (via any of their roles) has a given permission.
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        // Assumes Role has a permissions() relationship returning Permission models with a 'name' attribute
        foreach ($this->roles as $role) {
            if (
                method_exists($role, 'permissions') &&
                $role->permissions->contains('slug', $permissionName)
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Task reports submitted by this user
     */
    public function taskReports()
    {
        return $this->hasMany(TaskReport::class);
    }

    /**
     * Tasks hidden by this user (don't show)
     */
    public function hiddenTasks()
    {
        return $this->belongsToMany(Task::class, 'task_hidden');
    }

    /**
     * Check if user is currently banned from taking tasks
     */
    public function isBannedFromTasks(): bool
    {
        if (!$this->is_banned_from_tasks) {
            return false;
        }

        // Check if ban has expired
        if ($this->ban_expires_at && $this->ban_expires_at->isPast()) {
            $this->update([
                'is_banned_from_tasks' => false,
                'ban_reason' => null,
                'banned_by' => null,
                'banned_at' => null,
                'ban_expires_at' => null
            ]);
            return false;
        }

        return true;
    }

    /**
     * Ban user from taking tasks
     */
    public function banFromTasks(string $reason, ?User $bannedBy = null, ?int $days = null): void
    {
        $this->update([
            'is_banned_from_tasks' => true,
            'ban_reason' => $reason,
            'banned_by' => $bannedBy?->id,
            'banned_at' => now(),
            'ban_expires_at' => $days ? now()->addDays($days) : null
        ]);
    }

    /**
     * Unban user from taking tasks
     */
    public function unbanFromTasks(): void
    {
        $this->update([
            'is_banned_from_tasks' => false,
            'ban_reason' => null,
            'banned_by' => null,
            'banned_at' => null,
            'ban_expires_at' => null
        ]);
    }

    /**
     * Check if user can take tasks based on subscription limits
     */
    public function canTakeTask(): bool
    {
        // Check if banned
        if ($this->isBannedFromTasks()) {
            return false;
        }

        // Check subscription limits
        $activeSubscription = $this->activeSubscriptions()
            ->whereHas('plan', function($q) {
                $q->where('type', 'worker');
            })
            ->first();

        if (!$activeSubscription) {
            return false; // No active worker subscription
        }

        $plan = $activeSubscription->plan;
        $activeTasksPerHour = $plan->active_tasks_per_hour ?? 1;

        // Count ongoing tasks in the last hour
        $ongoingTasksCount = $this->task_workers()
            ->whereNotNull('accepted_at')
            ->whereNull('submitted_at')
            ->whereNull('completed_at')
            ->whereNull('cancelled_at')
            ->where('accepted_at', '>=', now()->subHour())
            ->count();

        return $ongoingTasksCount < $activeTasksPerHour;
    }

    /**
     * Check if user can submit tasks based on subscription limits
     */
    public function canSubmitTask(): bool
    {
        // Check if banned
        if ($this->isBannedFromTasks()) {
            return false;
        }

        // Check subscription limits
        $activeSubscription = $this->activeSubscriptions()
            ->whereHas('plan', function($q) {
                $q->where('type', 'worker');
            })
            ->first();

        if (!$activeSubscription) {
            return false; // No active worker subscription
        }

        $plan = $activeSubscription->plan;
        $activeTasksPerHour = $plan->active_tasks_per_hour ?? 1;

        // Count submitted tasks in the last hour
        $submittedTasksCount = $this->task_workers()
            ->whereNotNull('submitted_at')
            ->whereNull('completed_at')
            ->whereNull('cancelled_at')
            ->where('submitted_at', '>=', now()->subHour())
            ->count();

        return $submittedTasksCount < $activeTasksPerHour;
    }
}