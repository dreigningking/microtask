<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use App\Models\Platform;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

class Welcome extends Component
{
    use HelperTrait,GeoLocationTrait;
    
    public $tasks;
    public $popularPlatforms;

    public function mount()
    {
        
        $countryId = Auth::check() ? Auth::user()->country_id : ($this->getLocation()->country_id ?? null);
        $this->tasks = Task::with('user', 'platform','latestModeration')
            ->listable($countryId)
            ->whereHas('promotions', function($q) {
                $q->where('type', 'featured');
            })
            ->latest()
            ->take(10)
            ->get()
            ->map(function($task) {
                $task->platform_name = $task->platform?->name ?? 'Uncategorized';
                $task->estimated_time = $this->getTimeConversion($task->expected_completion_minutes);
                return $task;
            });

        $this->popularPlatforms = Platform::whereHas('tasks',function($query){
                $query->listable();
            })->withCount(['tasks' => function($query) {
                $query->listable();
            }])
            ->orderByDesc('tasks_count')
            ->take(8)
            ->get()
            ->map(function($platform) {
                return [
                    'id' => $platform->id,
                    'name' => $platform->name,
                    'image' => $platform->image,
                    'jobs_count' => $platform->tasks_count
                ];
            });
    }

    public function render()
    {
       return view('livewire.welcome');
    }
}
