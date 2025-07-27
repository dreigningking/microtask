<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search skills..." class="w-full px-4 py-2 border border-gray-300 rounded-md">
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($skills as $skill)
            <div
                wire:click="toggleSkill({{ $skill->id }})"
                class="cursor-pointer p-4 border rounded-md text-center {{ in_array($skill->id, $userSkills) ? 'bg-primary text-white' : 'border-gray-300' }}"
            >
                {{ $skill->name }}
            </div>
        @endforeach
    </div>
</div>
