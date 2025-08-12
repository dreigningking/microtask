<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Models\Settlement;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Task extends Model
{
    use Sluggable;
    
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
        'approved_at'=> 'datetime',
        'expiry_date'=> 'datetime'
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
        return $this->morphOne(OrderItem::class,'orderable');   
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

    public function settlements(){
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

    public function scopeCompleted($query)
    {
        return $query->whereRaw('number_of_people <= (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND completed_at IS NOT NULL)');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
                     })
                     ->whereRaw('number_of_people > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND completed_at IS NOT NULL)');
    }

    public function scopeListable($query, $countryId)
    {
        return $query->where('is_active', true)
                     ->where('visibility', 'public')
                     ->whereNotNull('approved_at')
                     ->where(function($q) use ($countryId) {
                         $q->whereNull('restricted_countries')
                           ->orWhereJsonDoesntContain('restricted_countries', $countryId);
                     })
                     ->where(function($q) {
                         $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
                     })
                     ->whereRaw('number_of_people > (SELECT COUNT(*) FROM task_submissions WHERE task_submissions.task_id = tasks.id AND completed_at IS NOT NULL)');
    }

    public function getStatusAttribute(){
        if (!$this->is_active) {
            return 'draft';
        }
        
        $workerCount = $this->workers()->whereNotNull('accepted_at')->count();
        
        if ($workerCount >= $this->number_of_people) {
            return 'closed';
        }
        
        $submittedCount = $this->taskSubmissions()->whereNotNull('completed_at')->count();
        if ($submittedCount >= $this->number_of_people) {
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
}
