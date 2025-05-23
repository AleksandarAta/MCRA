<div>
    <div sid="room">
        <ul>
            @foreach ($users as $user)
                <li class="dark:text-white">{{ $user->name }}
                    <input type="checkbox" value="{{ $user->id }}" wire:model="selectedUsers">
                </li>
            @endforeach
        </ul>
        <x-button id="startConference">Start Conference</x-button>
    </div>
</div>
@script
    <script>
        var pc;
        document.querySelector("#startConference").addEventListener('click', async (e) => {


            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            const videoElement = document.createElement('video');
            videoElement.srcObject = stream;
            videoElement.autoplay = true;
            videoElement.playsInline = true;
            document.getElementById('room').appendChild(videoElement);


            const pc = new RTCPeerConnection({
                iceServers: [{
                    urls: 'stun:stun.l.google.com:19302'
                }, ]
            });

            stream.getTracks().forEach(track => {
                pc.addTrack(track, stream);
            });

            const offer = await pc.createOffer();
            await pc.setLocalDescription(offer);


            Livewire.dispatch('startConference', {
                type: 'offer',
                sdp: offer.sdp
            });

        });
        document.addEventListener('startCall', async function(event) {
            console.log(event)
            await pc.setRemoteDescription(new RTCSessionDescription({
                type: event[0].type,
                sdp: event[0].offer
            }));
        })
    </script>
@endscript
{{-- wire:click="startConference" --}}
