<div wire:ignore id="room2" class="absolute top-2/4 left-2/4 w-1/3 h-1/3 flex">
</div>

@script
    <script>
        let peers = new Map();
        let pendingCandidates = new Map();
        let handledAnswers = new Set();
        let remoteDescriptionSet = new Set();

        Livewire.on('startConferenece', async function(event) {

            const peerId = event[0].peerId;
            const offer = event[0].offer;

            if (handledAnswers.has(peerId)) {
                console.log('Answer already handled for this peer, ignoring.');
                return;
            }


            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });
                const videoElement = document.createElement('video');
                videoElement.srcObject = stream;
                videoElement.autoplay = true;
                videoElement.playsInline = true;

                document.getElementById('room2').appendChild(videoElement);

                const pc = new RTCPeerConnection({
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
                console.log("pc set: ",
                    peers);
                if (pendingCandidates.has(peerId)) {
                    const candidates = pendingCandidates.get(peerId);
                    console.log('Processing pending candidates:', candidates);
                    candidates.forEach(candidate => {
                        const iceCandidate = new RTCIceCandidate(candidate);
                        pc.addIceCandidate(iceCandidate).catch(console.error);
                        console.log('added ice candidate');
                    });
                    pendingCandidates.delete(peerId);
                }


                stream.getTracks().forEach(track => pc.addTrack(track, stream));

                pc.ontrack = e => {
                    const existingVideo = document.getElementById(`remote-${peerId}`);

                    if (!existingVideo) {
                        const remoteVideo = document.createElement('video');
                        remoteVideo.id = `remote-${peerId}`;
                        remoteVideo.style.width = '320px';
                        remoteVideo.style.height = '240px';
                        remoteVideo.style.backgroundColor = 'black';
                        remoteVideo.autoplay = true;
                        remoteVideo.playsInline = true;
                        remoteVideo.srcObject = e.streams[0];
                        document.getElementById('room2').appendChild(remoteVideo);
                    } else {
                        existingVideo.srcObject = e.streams[0];
                    }
                };


                await pc.setRemoteDescription(new RTCSessionDescription({
                    type: 'offer',
                    sdp: offer,
                }));



                const answer = await pc.createAnswer();
                await pc.setLocalDescription(answer);

                pc.onicecandidate = e => {
                    Livewire.dispatch('sendIceCanidadtesToOfferer', {
                        candidate: e.candidate,
                        peerId: peerId,
                    })
                };

                Livewire.dispatch('sendAwnser', {
                    type: 'answer',
                    sdp: answer.sdp,
                    peerId: peerId,
                });


            } catch {
                console.error("Failed to set remote description:", err);
            } finally {
                handledAnswers.add(peerId);

            }

        });
        Livewire.on('receiveIceCandidatesAnwserer', (data) => {

            const peerId = data['0']['data']['peerId'];
            const dataCandidate = data['0']['data']['candidate'];
            const pc = peers.get(peerId);

            if (!pc) {
                if (!pendingCandidates.has(peerId)) {
                    pendingCandidates.set(peerId, []);
                }
                pendingCandidates.get(peerId).push(dataCandidate);
                console.log('Candidate stored (peer not ready)');
                return;
            }

            if (dataCandidate) {
                const candidate = new RTCIceCandidate(dataCandidate);
                pc.addIceCandidate(candidate).catch(console.error);
            }
        })
    </script>
@endscript
