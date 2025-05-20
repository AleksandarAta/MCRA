<div class=" fixed bottom-0 right-0 dark:bg-gray-500 dark:text-white w-64">

    <ul class=" dark:bg-gray-500 w-full">
        @foreach ($userList as $friend)
            <li
                class="whitespace-nowrap bg-white p-4  dark:bg-gray-500 transition-colors duration-200 rounded dark:hover:bg-blue-400 hover:bg-blue-100">
                <button
                    @click="$dispatch('startChat', { friend_id: {{ $friend['id'] }} , name: '{{ $friend['name'] }}' })"
                    class="flex
                    items-center justify-between w-full">
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
                </button>
            </li>
        @endforeach
    </ul>
</div>
