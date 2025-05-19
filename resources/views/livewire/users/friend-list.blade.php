<div class=" fixed bottom-0 right-0 dark:bg-gray-500 dark:text-white">
    <ul class="p-1 dark:bg-gray-500">
        @foreach ($userList as $friend)
            <button @click="$dispatch('startChat', { id: {{ $friend['id'] }} })
                class="whitespace-nowrap
                flex bg-white p-2 items-center w-56 justify-between dark:bg-gray-500 hover:bg-blue-100 transition-colors
                duration-200 rounded dark:hover:bg-blue-400">
                <li class="flex items-center justify-between w-full">
                    @if (isset($friend['profile_photo_path']))
                        <a href="{{ route('user.show', $friend['email']) }}">
                            <img src="{{ asset($friend['profile_photo_path']) }}" alt="profile img"
                                class="w-6 h-7 rounded-full mr-3 object-cover">
                        </a>
                    @endif

                    {{ $friend['name'] }}

                    @if ($friend['status'] == 'online')
                        <span class="inline-block w-2 h-2 bg-green-300 rounded-full"></span>
                    @else
                        <span class="inline-block w-2 h-2 bg-gray-500 rounded-full dark:bg-gray-100"></span>
                    @endif
                </li>
            </button>
        @endforeach
    </ul>
</div>
