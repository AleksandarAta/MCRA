<div class="h-72 bg-white overflow-y-auto relative w-72" x-ref="chatBody" x-data="{
    messages: $wire.entangle('messages'),
    latestMessage: $wire.entangle('latest_message'),
    userId: $wire.entangle('own_id'),
    last_id: $wire.entangle('last_id')
}" x-init="$nextTick(() => $refs.chatBody.scrollTo({ top: $refs.chatBody.scrollHeight }));
$watch('latestMessage', newMsg => {
    if (newMsg) {
        messages.push({
            id: last_id,
            chatRoom_id: newMsg.channel,
            body: newMsg.message,
            from: newMsg.sender_id,
            read: false
        });
    }
});">
    <template x-for="(message, index) in messages" :key="message.id">
        <div x-show="userId !== message.from" class="bg-green-400 p-2 m-1 rounded max-w-36">
            <div class="flex items-center gap-2">
                <img src="" alt="Friend" class="w-6 h-6 rounded-full">
                <span>Friend</span>
            </div>
            <p x-text="message.body"></p>
        </div>
        <div x-show="userId === message.from" class="p-2 rounded text-right w-full flex justify-end">
            <p class="max-w-40 bg-blue-400 p-2" x-text="message.body"></p>
        </div>
    </template>
</div>
