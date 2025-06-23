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
        'is_active'
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
}