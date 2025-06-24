<?php

namespace App\Models;

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
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'requirements' => 'array',
        'files' => 'array',
        'template_data' => 'array',
        'restricted_countries' => 'array',
        'approved_at'=> 'datetime'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function workers()
    {
        return $this->hasMany(TaskWorker::class);   
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

    public function scopeCompleted($query)
    {
        return $query->whereRaw('number_of_people <= (SELECT COUNT(*) FROM task_workers WHERE task_workers.task_id = tasks.id AND submitted_at IS NOT NULL)');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
                     })
                     ->whereRaw('number_of_people > (SELECT COUNT(*) FROM task_workers WHERE task_workers.task_id = tasks.id AND (submitted_at IS NOT NULL OR accepted_at IS NOT NULL))');
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
                     ->whereRaw('number_of_people > (SELECT COUNT(*) FROM task_workers WHERE task_workers.task_id = tasks.id AND (submitted_at IS NOT NULL OR accepted_at IS NOT NULL))');
    }

    public function getStatusAttribute(){
        if (!$this->is_active) {
            return 'draft';
        }
        
        $workerCount = $this->workers()->whereNotNull('accepted_at')->count();
        
        if ($workerCount >= $this->number_of_people) {
            return 'closed';
        }
        
        $submittedCount = $this->workers()->whereNotNull('submitted_at')->count();
        if ($submittedCount >= $this->number_of_people) {
            return 'completed';
        }
        
        return 'ongoing';
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
