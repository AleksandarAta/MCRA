<div class="fixed bottom-0 right-[280px] flex">
    @if ($open != null)
        @foreach ($open as $op)
            <div class="mr-3" wire:key="chat-window-{{ $op['room_id'] }}">
                <div class="p-2 bg-orange-400 text-white flex justify-between ">
                    <div class="flex justify-between whitespace-nowrap  w-20">
                        <img src="{{ asset($friend->profile_photo_path) }}" alt="" class= "w-7 h-6 rounded">
                        <span class="text-white">{{ $op['name'] }}</span>
                    </div>
                    <div>
                        <button wire:click = "closeChat({{ $op['room_id'] }})">X</button>
                    </div>
                </div>
                <div class="body">
                    <livewire:chatBody :channel_id="$op['room_id']" :key="$op['room_id']" />
                </div>
                <div class="footer w-full bg-gray-300 p-2">
                    <form action="" wire:submit.prevent="sendMessage({{ $op['room_id'] }})"
                        class="flex justify-between items-center">
                        <input type="text" name="body{{ $op['room_id'] }}" id="body{{ $op['room_id'] }}"
                            class="w-11/12 rounded foucs:ring-0 focus:outline-none"
                            wire:model="body.{{ $op['room_id'] }}">
                        <button type="submit" id="chat{{ $op['room_id'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="w-5 h-6 fill-orange-400 self-center">
                                <path
                                    d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480l0-83.6c0-4 1.5-7.8 4.2-10.8L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
