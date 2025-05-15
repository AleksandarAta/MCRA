<div class="relative p-1 h-10 flex justify-center items-center w-11" x-data="{ isOpen: false }" @click.away="isOpen = false"
    @keydown.esc="isOpen = false">

    @if ($notificaationNumber)
        <div
            class="bg-red-500 text-white absolute top-0 right-0 rounded-full text-xs p-1 w-5 h-5 flex items-center justify-center shadow-md transform translate-x-2 -translate-y-2">
            {{ $notificaationNumber }}
        </div>
    @endif

    <button @click="isOpen = !isOpen" wire:click = "readNotifications()" class="relative z-20 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-6 fill-gray-800 dark:fill-white hover:fill-blue-500 transition-all" viewBox="0 0 448 512">
            <path
                d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416l400 0c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4l0-25.4c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112l0 25.4c0 47.9 13.9 94.6 39.7 134.6L72.3 368C98.1 328 112 281.3 112 233.4l0-25.4c0-61.9 50.1-112 112-112zm64 352l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z" />
        </svg>
    </button>
    <div x-show="isOpen"
        class="w-64 max-h-96 overflow-y-auto rounded-lg font-semibold text-sm text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 shadow-lg absolute bottom-0 mt-2 p-4 z-10 flex flex-col space-y-2">

        @foreach ($notifications as $notification)
            <div x-data = '{accepted: true}'
                class="p-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all rounded-lg">
                @if ($notification['event'] == 'send')
                    <div x-show = "accepted">
                        <span class="text-sm">{{ $notification['name']->name }} sent you a friend request</span>
                        <button
                            @click=" accepted = false; $dispatch('acceptFriend', { friend_id: {{ $notification['name']->id }}})"
                            class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                            {{ __('Accept') }}
                        </button>
                        <button
                            class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                            {{ __('Reject') }}
                        </button>
                    </div>
                    <div x-transition x-show= "!accepted">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-6 fill-orange-400 dark:fill-orange-700"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path
                                d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16l-97.5 0c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8l97.5 0c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32L0 448c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32l0-224c0-17.7-14.3-32-32-32l-64 0z" />
                        </svg>
                    </div>
                @endif
                @if ($notification['event'] == 'accepted')
                    <span class="text-sm">{{ $notification['name']->name }} accepted your friend request</span>
                @endif
            </div>
        @endforeach
    </div>

</div>
