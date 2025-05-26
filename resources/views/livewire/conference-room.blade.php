<div wire:ignore id="room2" class="absolute top-2/4 left-2/4 w-1/3 h-1/3 flex">
</div>

@script
    <script>
        let peers = new Map();
        let pendingCandidates = new Map();
        let handledAnswers = new Set();
        let remoteVideos = new Map();
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

                stream.getTracks().forEach(track => pc.addTrack(track, stream));

                pc.ontrack = e => {
                    console.log(e.streams[0]);
                    remoteVideo = document.createElement('video');
                    remoteVideo.style.width = '320px';
                    remoteVideo.style.height = '240px';
                    remoteVideo.style.backgroundColor = 'black';
                    remoteVideo.id = `remote-${peerId}`;
                    remoteVideo.autoplay = true;
                    remoteVideo.playsInline = true;
                    document.getElementById('room2').appendChild(remoteVideo);
                    remoteVideos.set(peerId, remoteVideo);
                    remoteVideo.srcObject = e.streams[0];
                    console.log("Video tracks:", e.streams[0].getVideoTracks());
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
        Livewire.on('receiveIceCandidatesAwnserer', async function(event) {
            const peerId = event.detail[0];
            const eventCandiate = event.detail[1];
            const pc = peers.get(peerId);
            try {
                console.log('added Ice candidate');
                const candidate = new RTCIceCandidate(eventCandiate);
                await pc.addIceCandidate(candidate);
            } catch (err) {
                console.error('Error adding ICE candidate:', err);
            }
        });
    </script>
@endscript
