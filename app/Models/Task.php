<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\OrderItem;
use App\Models\Moderation;
use App\Models\Settlement;
use App\Observers\TaskObserver;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TaskObserver::class])]
class Task extends Model
{
    use Sluggable,HelperTrait;

    protected $fillable = [
        'title',
        'description',
        'status',
        'allow_multiple_submissions',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'requirements' => 'array',
        'template_data' => 'array',
        'restricted_countries' => 'array',
        'approved_at' => 'datetime',
        'expiry_date' => 'datetime'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function taskWorkers()
    {
        return $this->hasMany(TaskWorker::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function orderItem()
    {
        return $this->morphOne(OrderItem::class, 'orderable');
    }
    public function platformTemplate()
    {
        return $this->belongsTo(PlatformTemplate::class);
    }
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
    public function promotions()
    {
        return $this->hasMany(TaskPromotion::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function scopeCompleted($query)
    {
        return $query->whereRaw('number_of_submissions <= (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND accepted = true)');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
            })
            ->whereRaw('number_of_submissions > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND accepted = true)');
    }

    public function scopeListable($query, $countryId = null)
    {
        return $query->where('is_active', true)
            ->where('visibility', 'public')
            ->whereHas('latestModeration',function($mod){
                $mod->where('status','approved');
            })
            ->where(function ($q) use ($countryId) {
                if ($countryId) {
                    $q->whereNull('restricted_countries')
                        ->orWhereJsonDoesntContain('restricted_countries', $countryId);
                } else {
                    $q->whereNull('restricted_countries');
                }
            })
            ->where(function ($q) {
                $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
            })
            ->whereHas('user', function($q) {
                $q->where('is_banned_from_tasks', false)
                  ->orWhereNull('is_banned_from_tasks');
            })
            ->whereRaw('number_of_submissions > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND accepted = true)')
            ->whereDoesntHave('user.blockedByUsers', function($q) {
                if (Auth::check()) {
                    $q->where('users.id', Auth::id());
                }
            });
    }

    public function getAvailableAttribute(){
        // 3. Task is_active is true
        if(!$this->is_active)
            return false;
        
        // 4. Task moderation status is approved
        if(!$this->latestModeration || $this->latestModeration->status !== 'approved')
            return false;
        
        // 2. Task is not expired
        if($this->expiry_date && $this->expiry_date < now())
            return false;
        
        // 5. Task is not yet completed - number of paid submissions is less than task->number_of_submissions
        $acceptedSubmissions = $this->taskSubmissions()->where('accepted', true)->count();
        if($acceptedSubmissions >= $this->number_of_submissions)
            return false;
        
        // 6. User is not logged in or user is logged in and he has not blocked the task creator or the task creator has not blocked him
        if(Auth::check()) {
            $currentUser = Auth::user();
            // Check if current user has blocked the task creator
            $userBlockedCreator = $currentUser->blockedUsers->where('id', $this->user_id)->isNotEmpty();
            // Check if task creator has blocked the current user
            $creatorBlockedUser = $this->user->blockedUsers->where('id', $currentUser->id)->isNotEmpty();
            
            if($userBlockedCreator || $creatorBlockedUser)
                return false;
            if($this->restricted_countries && in_array($currentUser->country_id, $this->restricted_countries))
                return false;
            if($currentUser->is_banned_from_tasks)
                return false;
        }
        
        return true;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'draft';
        }

        $workerCount = $this->taskWorkers()->whereNotNull('accepted_at')->count();

        if ($workerCount >= $this->number_of_submissions) {
            return 'closed';
        }

        $submittedCount = $this->taskSubmissions()->where('accepted', true)->count();
        if ($submittedCount >= $this->number_of_submissions) {
            return 'completed';
        }

        return 'ongoing';
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Determine if the task can be edited (all, some, or none)
     * Returns 'all', 'some', or 'none'
     */
    public function getCanBeEditedAttribute()
    {
        $orderItem = $this->orderItem;
        $order = $orderItem ? $orderItem->order : null;
        $payment = $order ? $order->payment : null;
        $isPaid = $payment && $payment->status === 'success';

        return !$isPaid;
    }

    public function scopeLocalize($query)
    {
        if (Auth::user()->first_role->name == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }

    public function getRemainingTimeAttribute(){
        if($this->expiry_date < now())
            return null;
        $minutes = abs($this->expiry_date->diffInMinutes(now()));
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $weeks = floor($days / 7);
        $months = floor($days / 30);
        
        if ($minutes < 60) {
            return $minutes . ' mins';
        } elseif ($hours < 24) {
            return $hours . ' hr' . ($hours > 1 ? 's' : '');
        } elseif ($days < 7) {
            return $days . ' day' . ($days > 1 ? 's' : '');
        } elseif ($weeks < 4) {
            return $weeks . ' week' . ($weeks > 1 ? 's' : '');
        } else {
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
    }
}
