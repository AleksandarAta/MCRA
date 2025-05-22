<div>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }}
                <input type="checkbox" value="{{ $user->id }}" wire:model="selectedUsers">
            </li>
        @endforeach
    </ul>
    <x-button wire:click="startConference">Start Conference</x-button>
</div>
