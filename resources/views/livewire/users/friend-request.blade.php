<div>
    @if (Auth::user() != $user)
        @if ($status == '')
            <button wire:click="addFriend({{ $user->id }})"
                class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                {{ __('Add friend') }}
            </button>
        @elseif($status == 'add')
            <div class="flex gap-2 mt-2">
                <button @click="$dispatch('acceptFriend', { friend_id: {{ $user->id }} })"
                    class="rounded p-1 bg-orange-400 hover:text-black hover:bg-white hover:border hover:border-orange-400 dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                    {{ __('Accept') }}
                </button>
                <button @click=" $dispatch('rejectFriend', { friend_id: {{ $user->id }} })"
                    class=" rounded p-1 bg-orange-400 hover:text-black hover:bg-white hover:border hover:border-orange-400 dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                    {{ __('Reject') }}
                </button>
            </div>
        @elseif($status == 'friends')
            <button
                class="cursor-default whitespace-nowrap  p-1 text-sm rounded bg-orange-400  dark:bg-orange-600 dark:text-gray-100">
                {{ __('Friends') }}</button>
        @elseif($status == 'sent')
            <span
                class="cursor-default p-1 text-sm rounded whitespace-nowrap  bg-orange-400  dark:bg-orange-600 dark:text-gray-100">
                {{ __('Friend Request sent') }}</span>
        @endif
    @endif
</div>
