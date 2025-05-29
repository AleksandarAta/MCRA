<div class="relative p-1 flex justify-center items-center w-11" x-data="{ isOpen: false }" @click.away="isOpen = false"
    @keydown.esc="isOpen = false" x-on:playSound = "document.getElementById('notifSound').play()">

    @if ($notificaationNumber)
        <div
            class="bg-red-500 text-white absolute top-0 right-0 rounded-full text-xs p-1 w-5 h-5 flex items-center justify-center shadow-md transform translate-x-2 -translate-y-2">
            {{ $notificaationNumber }}
        </div>
    @endif

    <button @click="isOpen = !isOpen" wire:click="readNotifications()" class="relative z-20 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-6 fill-gray-800 dark:fill-white hover:fill-blue-500 transition-all" viewBox="0 0 448 512">
            <path
                d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416l400 0c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4l0-25.4c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112l0 25.4c0 47.9 13.9 94.6 39.7 134.6L72.3 368C98.1 328 112 281.3 112 233.4l0-25.4c0-61.9 50.1-112 112-112zm64 352l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z" />
        </svg>
    </button>

    <audio id="notifSound" src="{{ asset('images/mixkit-long-pop-2358.wav') }}" preload="auto"></audio>
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed md:absolute w-64 md:w-64 max-h-96 overflow-y-auto rounded-lg font-semibold text-sm text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 shadow-xl border top-5 right-0 border-gray-200 dark:border-gray-700 mt-10 md:mt-2 p-4 z-50 flex flex-col space-y-2">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <div
                    class="p-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all rounded-lg">
                    @if ($notification['event'] == 'send')
                        <div x-data="{ status: 'pending' }" class="space-y-2">
                            <template x-if="status === 'pending'">
                                <div x-transition>
                                    <span class="text-sm">
                                        @if ($notification['name']->email)
                                            <a href="{{ route('user.show', $notification['name']->email) }}">
                                                {{ $notification['name']->name }} {{ __('sent you a friend request') }}
                                            </a>
                                        @else
                                            {{ $notification['name']->name }} {{ __('sent you a friend request') }}
                                        @endif
                                    </span>
                                </div>
                            </template>
                        </div>
                    @elseif ($notification['event'] == 'accepted')
                        <a href="{{ route('user.show', $notification['name']->email) }}">
                            <span class="text-sm">{{ $notification['name']->name }}
                                {{ __('accepted your friend request') }}</span>
                        </a>
                    @elseif ($notification['event'] == 'commented')
                        {{-- {{ dd($notification) }} --}}
                        <a href="{{ route('blogs.show', $notification['slug']) }}">
                            <span class="text-sm">{{ $notification['name']->name }}
                                {{ __('Commented on your blog') }}</span>
                        </a>
                    @endif
                </div>
            @endforeach
        @else
            <div class="p-2 text-center text-gray-500">
                {{ __('No new notifications') }}
            </div>
        @endif
    </div>
</div>
