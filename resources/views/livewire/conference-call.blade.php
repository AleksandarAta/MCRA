<div wire:ignore>
    <div id="room">
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
        let peers = new Map();
        let pendingCandidates = new Map();
        let handledAnswers = new Set();

        document.querySelector("#startConference").addEventListener('click', async (event) => {
            const peerId = uuidv4();

            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            const videoElement = document.createElement('video');
            videoElement.srcObject = stream;
            videoElement.autoplay = true;
            videoElement.playsInline = true;
            document.getElementById('room').appendChild(videoElement);


            pc = new RTCPeerConnection({
                'iceServers': [{
                        'urls': 'stun:stun.l.google.com:19302'
                    },
                    {
                        'urls': 'turn:turn.' + window.location.hostname + ':3479',
                        'username': 'test',
                        'credential': 'test123'
                    }
                ]

            });

            peers.set(peerId, pc);

            stream.getTracks().forEach(track => pc.addTrack(track, stream));


            pc.onicecandidate = (event) => {
                console.log(event.candidate);
                Livewire.dispatch('sendIceCanidadtestoAnwserer', {
                    candidate: event.candidate.toJSON(),
                    peerId: peerId,
                })
            };


            const offer = await pc.createOffer();
            await pc.setLocalDescription(offer);
            Livewire.dispatch('sendOffer', {
                type: 'offer',
                sdp: offer.sdp,
                peerId: peerId,
            });



        });
        document.addEventListener('startCall', async function(event) {
            const answer = event.detail[0];
            const sdp = answer.offer;
            const peerId = answer.peerId;
            const pc = peers.get(peerId);

            console.log(peerId);

            if (handledAnswers.has(peerId)) {
                console.log('Answer already handled for this peer, ignoring.');
                return;
            }


            if (!pc) {
                console.error("Peer connection (pc) not initialized.");
                return;
            }

            if (pc.signalingState === 'stable') {
                console.log('Connection already stable - ignoring answer');
                return;
            }

            try {

                await pc.setRemoteDescription(new RTCSessionDescription({
                    type: 'answer',
                    sdp: sdp,
                }));



                pc.ontrack = event => {
                    const reventmoteVideo2 = document.createElement('video');
                    remoteVideo2.srcObject = event.streams[0];
                    remoteVideo2.autoplay = true;
                    remoteVideo2.playsInline = true;
                    document.getElementById('room').appendChild(remoteVideo2);
                };

            } catch (err) {
                console.error("Failed to set remote description:", err);
            } finally {
                handledAnswers.add(peerId);
            }

        })
        Livewire.on('receiveIceCandidatesOfferer', (event) => {
            const peerId = event.detail[0];
            const candiate = event.detail[1];
            const pc = peers.get(peerId);
            console.log('added Ice candidate');
            pc.addIceCandidate(new RTCIceCandidate(candiate))
                .catch(console.error);
        })
    </script>
@endscript
