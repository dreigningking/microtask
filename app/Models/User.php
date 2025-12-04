<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Models\Setting;
use App\Models\Support;
use App\Models\Platform;
use App\Models\TaskWorker;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Observers\UserObserver;
use App\Models\PreferredLocation;
use Illuminate\Support\Facades\Auth;
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
        'username',
        'email',
        'phone',
        'country_id',
        'role_id',
        'state_id',
        'city_id',
        'address',
        'dob',
        'gender',
        'phone_verified_at',
        'email_verified_at',
        'password',
        'is_active',
        'dashboard_view',
        'two_factor_enabled',
        'notification_settings',
        'is_banned_from_tasks',
        'banned_at',
        'ban_expires_at',
        'ban_reason',
        'banned_by',
        'created_at',
        'updated_at'
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
            'phone_verified_at' => 'datetime',
            'banned_at' => 'datetime',
            'ban_expires_at' => 'datetime',
            'password' => 'hashed',
            'notification_settings' => 'array',
            'two_factor_enabled' => 'boolean',
            'is_active' => 'boolean',
            'is_banned_from_tasks' => 'boolean',
        ];
    }

    public static function boot(){
        parent::boot();
        parent::observe(new UserObserver);
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
        return $this->hasMany(PreferredLocation::class,);
    }

    public function preferred_platforms(){
        return $this->belongsToMany(PreferredPlatform::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
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
    public function taskWorkers()
    {
        return $this->hasMany(TaskWorker::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
    

    public function referrals(){
        //people i have referred
        return $this->hasMany(Referral::class);
    }

    public function referrers(){
        //all the places where I have been referred
        return $this->hasMany(Referral::class,'referree_id');
    }

    public function invitations(){
        return $this->hasMany(Invitation::class);
    }

    public function settlements(){
        return $this->hasMany(Settlement::class);
    }

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
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

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Self-referential relationship for banned_by
     */
    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    /**
     * Self-referential relationship for banned users
     */
    public function bannedUsers()
    {
        return $this->hasMany(User::class, 'banned_by');
    }

    /**
     * User verification documents
     */
    public function userVerifications()
    {
        return $this->hasMany(UserVerification::class);
    }

    /**
     * Login activities
     */
    public function loginActivities()
    {
        return $this->hasMany(LoginActivity::class);
    }

    /**
     * Posts created by user
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Comments made by user (polymorphic)
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Announcements sent by user
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'sent_by');
    }

    /**
     * User notifications (polymorphic)
     */
    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }

    /**
     * Moderations for this user (polymorphic)
     */
    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    /**
     * Moderations done by this user as moderator
     */
    public function moderatedItems()
    {
        return $this->hasMany(Moderation::class, 'moderator_id');
    }

    /**
     * Blocked users relationship (through blocklists)
     */
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocklists', 'user_id', 'enemy_id');
    }

    /**
     * Users who blocked this user
     */
    public function blockedByUsers()
    {
        return $this->belongsToMany(User::class, 'blocklists', 'enemy_id', 'user_id');
    }

    /**
     * Carts relationship
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Orders relationship
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Payments relationship
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Withdrawals relationship
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Bank accounts relationship
     */
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Task promotions created by user
     */
    public function taskPromotions()
    {
        return $this->hasMany(TaskPromotion::class);
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
        $approvedVerifications = $this->hasMany(UserVerification::class)
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
        if($this->userVerifications()->count() == 0){
            return false;
        }
        $userVerifications = $this->userVerifications();
        foreach($userVerifications as $uv){
            if(!$uv->moderations->isEmpty()){
                return false;
            }
            if($uv->moderations->where('status','approved')->isEmpty()){
                return false;
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
        if($this->role && $this->role->permissions->contains('slug', $permissionName)){
            return true;
        }
        return false;
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
     * Check if the user is active
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Scope to only include active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to only include inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function scopeLocalize($query)
    {
        if (Auth::user()->role->name == 'super-admin') {
            return $query;
        }

        return $query->where('country_id', Auth::user()->country_id);
    }

    /**
     * Scope for users with admin roles
     */
    public function scopeAdminUsers($query)
    {
        return $query->whereNotNull('role_id');
    }

    /**
     * Scope for verified users
     */
    public function scopeVerified($query)
    {
        return $query->whereHas('userVerifications', function ($verificationQuery) {
                $verificationQuery->whereHas('moderation',function($mod){
                    $mod->where('status', 'approved');
                });               

        });
    }

    /**
     * Scope for users who posted tasks within specified days
     */
    public function scopeRecentTaskPosters($query, $days = 30)
    {
        return $query->whereHas('tasks', function ($q) use ($days) {
            $q->where('created_at', '>=', now()->subDays($days));
        });
    }

    /**
     * Scope for users who worked on tasks within specified days
     */
    public function scopeRecentTaskWorkers($query, $days = 30)
    {
        return $query->whereHas('taskWorkers', function ($q) use ($days) {
            $q->where('created_at', '>=', now()->subDays($days));
        });
    }

    /**
     * Scope for users banned from tasks
     */
    public function scopeBannedFromTasks($query)
    {
        return $query->where('is_banned_from_tasks', true);
    }

    /**
     * Scope for users from specific countries
     */
    public function scopeFromCountries($query, $countryIds)
    {
        if (!is_array($countryIds)) {
            $countryIds = [$countryIds];
        }
        
        return $query->whereIn('country_id', $countryIds);
    }

    /**
     * Scope for users registered within specified days
     */
    public function scopeRecentlyRegistered($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for users with high task completion rates
     */
    public function scopeHighCompletionRate($query, $minRate = 80, $minTasks = 5)
    {
        return $query->whereHas('taskSubmissions', function ($q) use ($minRate, $minTasks) {
            // This is a complex query that would need to be implemented based on your business logic
            // For now, we'll use a simple approach based on accepted submissions
            $q->selectRaw('user_id,
                COUNT(*) as total_submissions,
                SUM(CASE WHEN accepted = 1 THEN 1 ELSE 0 END) as accepted_submissions,
                CASE
                    WHEN COUNT(*) > 0 THEN (SUM(CASE WHEN accepted = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*))
                    ELSE 0
                END as completion_rate
            ')
            ->groupBy('user_id')
            ->havingRaw('completion_rate >= ? AND total_submissions >= ?', [$minRate, $minTasks]);
        });
    }

    /**
     * Scope for users with earnings above threshold
     */
    public function scopeHighEarning($query, $minEarnings = 100, $currency = 'USD')
    {
        return $query->whereHas('settlements', function ($q) use ($minEarnings, $currency) {
            $q->selectRaw('user_id, SUM(amount) as total_earnings')
              ->where('currency', $currency)
              ->groupBy('user_id')
              ->havingRaw('total_earnings >= ?', [$minEarnings]);
        });
    }

    /**
     * Get users by segment configuration
     */
    public function scopeBySegment($query, string $segment, array $criteria = [])
    {
        $segments = config('settings.announcement_segments');
        $segmentConfig = $segments[$segment] ?? null;

        if (!$segmentConfig) {
            return $query;
        }

        $filters = $segmentConfig['filters'] ?? [];
        $type = $filters['type'] ?? 'all';
        $conditions = $filters['conditions'] ?? [];

        // Apply specific conditions from criteria parameter
        foreach ($criteria as $key => $value) {
            $conditions[$key] = $value;
        }

        switch ($type) {
            case 'all':
                // Return all users, no additional filtering
                break;

            case 'active_users':
                $query->where('is_active', true)
                      ->where('is_banned_from_tasks', false);
                break;

            case 'relationship':
                if (($conditions['has_task_workers'] ?? false)) {
                    $query->has('taskWorkers');
                }
                if (($conditions['has_tasks'] ?? false)) {
                    $query->has('tasks');
                }
                break;

            case 'role':
                if (!empty($conditions['roles'])) {
                    $query->adminUsers();
                }
                break;

            case 'verification':
                if (($conditions['is_verified'] ?? false)) {
                    $query->verified();
                } else {
                    $query->unverified();
                }
                break;

            case 'activity':
                if (($conditions['has_tasks_within_days'] ?? false)) {
                    $query->recentTaskPosters($conditions['has_tasks_within_days']);
                }
                if (($conditions['has_task_workers_within_days'] ?? false)) {
                    $query->recentTaskWorkers($conditions['has_task_workers_within_days']);
                }
                break;

            case 'subscription':
                if (($conditions['has_active_subscription'] ?? false)) {
                    $subscriptionType = $conditions['subscription_type'] ?? null;
                    if ($subscriptionType === 'premium') {
                        $query->premiumUsers();
                    } elseif ($subscriptionType === 'worker') {
                        $query->workerSubscriptionUsers();
                    } elseif ($subscriptionType === 'creator') {
                        $query->creatorSubscriptionUsers();
                    }
                } else {
                    $query->noSubscription();
                }
                break;

            case 'status':
                if (($conditions['is_banned_from_tasks'] ?? false)) {
                    $query->bannedFromTasks();
                }
                if (($conditions['is_active'] ?? true) === false) {
                    $query->where('is_active', false);
                }
                break;

            case 'geographic':
                if (($conditions['country_id'] ?? false)) {
                    $query->fromCountries($conditions['country_id']);
                }
                break;

            case 'registration':
                if (($conditions['registered_within_days'] ?? false)) {
                    $query->recentlyRegistered($conditions['registered_within_days']);
                }
                break;

            case 'performance':
                if (($conditions['min_completion_rate'] ?? false)) {
                    $query->highCompletionRate(
                        $conditions['min_completion_rate'],
                        $conditions['min_total_tasks'] ?? 5
                    );
                }
                break;

            case 'earnings':
                if (($conditions['min_earnings'] ?? false)) {
                    $query->highEarning(
                        $conditions['min_earnings'],
                        $conditions['currency'] ?? 'USD'
                    );
                }
                break;
        }

        return $query;
    }

    /**
     * Check if user belongs to a specific segment
     */
    public function belongsToSegment(string $segment, array $criteria = []): bool
    {
        return self::where('id', $this->id)->bySegment($segment, $criteria)->exists();
    }

    /**
     * Get all available user segments
     */
    public static function getAvailableSegments(): array
    {
        return config('settings.announcement_segments', []);
    }

    /**
     * Get segment display name
     */
    public static function getSegmentName(string $segment): string
    {
        $segments = config('settings.announcement_segments');
        return $segments[$segment]['name'] ?? $segment;
    }

    /**
     * Get segment description
     */
    public static function getSegmentDescription(string $segment): string
    {
        $segments = config('settings.announcement_segments');
        return $segments[$segment]['description'] ?? '';
    }
}