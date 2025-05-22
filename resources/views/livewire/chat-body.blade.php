<div wire:ignore class="h-72 bg-white overflow-y-auto relative w-72" x-ref="chatBody" id="chatBody" x-data="{
    latestMessage: $wire.entangle('latest_message'),
}"
    x-init="$nextTick(() => $refs.chatBody.scrollTo({ top: $refs.chatBody.scrollHeight }));
    $watch('latestMessage', newMsg => {
        $dispatch('addMessage', { newMsg });
    });">
    @foreach ($messages as $message)
        @if ($own_id != $message->from)
            <div wire:key="{{ $message->id }}" id="friendMessage" class="bg-green-400 p-2 m-1 rounded max-w-36">
                <div>
                    <div class="flex items-center gap-2">
                        <img src="" alt="Friend" class="w-6 h-6 rounded-full">
                        <span>Friend</span>
                    </div>
                    <p>{{ $message->body }}</p>
                </div>
            </div>
        @else
            <div id="userMesasge" class="p-2 rounded text-right w-full flex justify-end">
                <p class="max-w-40 bg-blue-400 p-2">{{ $message->body }}</p>
            </div>
        @endif
    @endforeach
</div>
@script
    <script>
        document.addEventListener('addMessage', function(event) {

            console.log(event.detail.newMsg.message);
            const message = event.detail.newMsg;
            const container = document.createElement('div');

            container.className = 'bg-green-400 p-2 m-1 rounded max-w-36';
            const innerDiv = document.createElement('div');

            const friendInfo = document.createElement('div');
            friendInfo.className = 'flex items-center gap-2';

            const img = document.createElement('img');
            img.className = 'w-6 h-6 rounded-full';
            img.src = '';
            img.alt = 'Friend';

            const name = document.createElement('span');
            name.textContent = 'Friend';

            const messageBody = document.createElement('p');
            const node = document.createTextNode(event.detail.newMsg.message);
            messageBody.appendChild(node);

            friendInfo.appendChild(img);
            friendInfo.appendChild(name);
            innerDiv.appendChild(friendInfo);
            innerDiv.appendChild(messageBody);
            container.appendChild(innerDiv);

            const chatBody = document.querySelector('#chatBody');
            chatBody.appendChild(container);

            chatBody.scrollTo({
                top: chatBody.scrollHeight
            });
        });
    </script>
@endscript
