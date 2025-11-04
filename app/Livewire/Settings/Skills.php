<?php

namespace App\Livewire\Settings;

use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Skills extends Component
{
    public $skills;
    public $userSkills;
    public $search = '';

    public function mount()
    {
        $this->loadUserSkills();
    }

    public function loadUserSkills()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->userSkills = $user->skills->pluck('id')->toArray();
    }

    public function toggleSkill($skillId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (in_array($skillId, $this->userSkills)) {
            $user->skills()->detach($skillId);
        } else {
            $user->skills()->attach($skillId);
        }
        $this->loadUserSkills();
    }

    public function render()
    {
        $this->skills = Skill::where('name', 'like', '%' . $this->search . '%')->get();
        return view('livewire.settings.skills');
    }
}
