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
