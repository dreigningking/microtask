<?php

namespace App\Models;

use App\Http\Traits\HelperTrait;
use App\Models\OrderItem;
use App\Models\Settlement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;


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
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workers()
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
    public function template()
    {
        return $this->belongsTo(TaskTemplate::class);
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

    public function reports()
    {
        return $this->hasMany(TaskReport::class);
    }

    public function hiddenByUsers()
    {
        return $this->belongsToMany(User::class, 'task_hidden');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function scopeCompleted($query)
    {
        return $query->whereRaw('number_of_submissions <= (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND completed_at IS NOT NULL)');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
            })
            ->whereRaw('number_of_submissions > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND completed_at IS NOT NULL)');
    }

    public function scopeListable($query, $countryId = null)
    {
        return $query->where('is_active', true)
            ->where('visibility', 'public')
            ->whereNotNull('approved_at')
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
            ->whereRaw('number_of_submissions > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND paid_at IS NOT NULL)');
        
    }

    public function getAvailableAttribute(){
        if(!$this->is_active)
            return false;
        if(!$this->approved_at)
            return false;
        if($this->expiry_date < now())
            return false;
        if($this->number_of_submissions >= $this->taskSubmissions->whereNotNull('paid_at')->count())
            return false;
        if($this->restricted_countries && Auth::check() && in_array(Auth::user()->country_id,$this->restricted_countries))
            return false;
        return true;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'draft';
        }

        $workerCount = $this->workers()->whereNotNull('accepted_at')->count();

        if ($workerCount >= $this->number_of_submissions) {
            return 'closed';
        }

        $submittedCount = $this->taskSubmissions()->whereNotNull('completed_at')->count();
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
        if (auth()->user()->first_role->name == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', auth()->user()->country_id);
            });
        });
    }

    public function getRemainingTimeAttribute(){
        if($this->expiry_date < now())
            return null;
        $minutes = $this->expiry_date->diffInMinutes(now());
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
