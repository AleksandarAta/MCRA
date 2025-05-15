        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" p-3 grid grid-cols-8 gap-4 dark:bg-slate-600">
                    <div class="shadow-xl p-3 col-span-3 dark:bg-gray-800">
                        <img src="{{ asset($user->img) }}" alt="{{ $user->name }}">
                        <p>{{ $user->name }}</p>
                        @if ($user->adress != null)
                            <p>{{ $user->adress->city }}</p>
                            <p>{{ $user->adress->country }}</p>
                        @else
                            <p>User not verified yet</p>
                        @endif
                        <p>{{ $user->phone }}</p>
                        <p>{{ $user->email }}</p>
                        @if (Auth::user() != $user)
                            <button wire:click="addFriend({{ $user->id }})"
                                class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                                {{ __('Add friend') }}
                            </button>
                        @endif

                        @if (Auth::user() == $user)
                            <button @click = "isOpen = true"
                                class="rounded p-1   hover:text-black  dark:text-white dark:hover:text-blacktext-sm">
                                <svg class="fill-orange-700 dark:fill-orange-400 w-5 h-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path
                                        d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    <div class="col-span-4">
                        @if ($user->biography != null)
                            <p>{{ $user->biography->title }}</p>
                            {!! $user->biography->biography !!}
                        @else
                            <p>User not verified yet</p>
                        @endif
                        <h2>{{ __('Commneds') }}</h2>
                        <p>To be continued...</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-4">
                <h2>{{ __('Badges') }}</h2>
            </div>
        </div>
