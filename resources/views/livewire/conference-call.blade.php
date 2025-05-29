<div wire:ignore id="userComponent" x-data= "{selectedUsers: @entangle('selectedUsers')}">
    <div id="room">
        <button wire:click="$dispatch('test-event')" class="text-white">Dispatch Livewire Event</button>
        <ul>
            @foreach ($users as $user)
                <li class="dark:text-white">{{ $user->name }}
                    <input type="checkbox" value="{{ $user->id }}" wire:model.live="selectedUsers">
                </li>
            @endforeach
        </ul>
        <x-button id="startConference" wire:click="initConf">Start Conference</x-button>
    </div>
</div>
@script
    <script>
        let peers = new Map();
        let pendingCandidates = new Map();
        let handledAnswers = new Set();

        Livewire.on("initConf", async (event) => {
            let selectedUsers = event['0'];


            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            const videoElement = document.createElement('video');
            videoElement.srcObject = stream;
            videoElement.autoplay = true;
            videoElement.playsInline = true;
            document.getElementById('room').appendChild(videoElement);


            selectedUsers.forEach(async (user) => {
                user = uuidv4();
                const peerId = user;


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
                pc.onicecandidate = (event) => {
                    console.log('sent ice Candidates')
                    if (event.candidate != null) {
                        Livewire.dispatch('sendIceCanidadtestoAnwserer', {
                            candidate: event.candidate,
                            peerId: peerId,
                        })
                    }
                };

                stream.getTracks().forEach(track => pc.addTrack(track, stream));

                pc.ontrack = event => {
                    const existingVideo = document.getElementById(`remote-${peerId}`);
                    if (!existingVideo) {
                        const remoteVideo2 = document.createElement('video');
                        remoteVideo2.srcObject = event.streams[0];
                        remoteVideo2.autoplay = true;
                        remoteVideo2.id = `remote-${peerId}`;

                        remoteVideo2.playsInline = true;
                        document.getElementById('room').appendChild(remoteVideo2);
                    }
                };


                const offer = await pc.createOffer();
                await pc.setLocalDescription(offer);
                Livewire.dispatch('sendOffer', {
                    type: 'offer',
                    sdp: offer.sdp,
                    peerId: peerId,
                });

            });

        });
        document.addEventListener('startCall', async function(event) {
            const answer = event.detail['0'];
            const sdp = answer.offer;
            const peerId = answer.peerId;
            const pc = peers.get(peerId);



            if (!pc) {
                console.error("Peer connection (pc) not initialized.");
                return;
            }

            try {
                await pc.setRemoteDescription(new RTCSessionDescription({
                    type: 'answer',
                    sdp: sdp,
                }));

                console.log('Remote description set successfully.');



            } catch (err) {
                console.error("Failed to set remote description:", err);
            } finally {
                handledAnswers.add(peerId);
            }

        })


        Livewire.on('receiveIceCandidatesOfferer', (event) => {
            // const peerId = data['0']['data']['peerId'];
            // const dataCandidate = data['0']['data']['candidate'];

            // const pc = peers.get(peerId);

            console.log(event);

            // if (!pc) {
            //     if (!pendingCandidates.has(peerId)) {
            //         pendingCandidates.set(peerId, []);
            //     }
            //     pendingCandidates.get(peerId).push(dataCandidate);
            //     console.log('Candidate stored (peer not ready)');
            //     return;
            // }

            // if (dataCandidate) {
            //     const candidate = new RTCIceCandidate(dataCandidate);
            //     pc.addIceCandidate(candidate).catch(console.error);
            // }
        })
    </script>
@endscript
