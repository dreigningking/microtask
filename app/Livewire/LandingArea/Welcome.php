<?php

namespace App\Livewire\LandingArea;

use App\Models\Task;
use Livewire\Component;
use App\Models\Platform;
use Livewire\Attributes\Layout;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

#[Layout('components.layouts.landing-layout')]
class Welcome extends Component
{
    use HelperTrait,GeoLocationTrait;
    
    public $tasks;
    public $popularPlatforms;
    public $allPlatforms;
    public $searchQuery = '';
    public $searchPlatform = '';
    
    public $registeredUsers = 0;
    public $completedJobs = 0;
    public $activeJobs = 0;

    public function mount()
    {
        
        $countryId = Auth::check() ? Auth::user()->country_id : ($this->getLocation()->country_id ?? null);
        $this->tasks = Task::with('user', 'platform')
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

        $this->popularPlatforms = Platform::withCount(['tasks' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderByDesc('tasks_count')
            ->take(8)
            ->get()
            ->map(function($platform) {
                return [
                    'id' => $platform->id,
                    'name' => $platform->name,
                    'image' => $platform->image,
                    'color' => $platform->color ?? $this->getDefaultColor($platform->name),
                    'jobs_count' => $platform->tasks_count
                ];
            });

        $this->allPlatforms = Platform::all();
        $this->getPlatformStats();
    }

    public function searchJobs()
    {
        return redirect()->route('explore', [
            'search' => $this->searchQuery,
            'selectedPlatforms' => $this->searchPlatform ? [$this->searchPlatform] : []
        ]);
    }

    private function getPlatformStats()
    {
        $this->registeredUsers = \App\Models\User::count();
        $this->completedJobs = Task::completed()->count();
        $this->activeJobs = Task::active()->count();
    }

    private function getDefaultColor($platformName)
    {
        $colors = [
            'Design & Creative' => 'blue',
            'Writing & Translation' => 'green',
            'Development & IT' => 'purple',
            'Marketing & Sales' => 'orange',
            'Customer Support' => 'red',
            'Data Entry & Admin' => 'indigo',
            'Video & Animation' => 'yellow',
            'Translation' => 'pink'
        ];

        return $colors[$platformName] ?? 'gray';
    }

    public function render()
    {
       return view('livewire.landing-area.welcome');
    }
}
