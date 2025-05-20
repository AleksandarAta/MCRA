<div class="h-72 bg-white overflow-y-auto relative w-72" x-data x-ref="chatBody" x-init="$nextTick(() => { $refs.chatBody.scrollTo({ top: $refs.chatBody.scrollHeight }) })">
    <div>
        @foreach ($messeges as $message)
            @if ($message->from != Auth::id())
                <div class="bg-green-400 p-2 m-1 rounded max-w-36">
                    <div class="flex items-center gap-2">
                        <img src="" alt="" class="w-6 h-6 rounded-full">
                        <span>Friend</span>
                    </div>
                    <p>{{ $message->body }}</p>
                </div>
            @else
                <div class="p-2 rounded text-right w-full flex justify-end">
                    <p class="max-w-40 bg-blue-400 p-2">{{ $message->body }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
