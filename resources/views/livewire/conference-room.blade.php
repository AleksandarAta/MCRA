<div id="room" class="absolute top-2/4 left-2/4 w-1/3 h-1/3">
</div>

@script
    <script>
        Livewire.on('startConferenece', async function(event) {

            console.log(event[0].offer);
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



            await pc.setRemoteDescription(new RTCSessionDescription({
                type: event[0].type,
                sdp: event[0].offer
            }));

            const answer = await pc.createAnswer();
            await pc.setLocalDescription(answer);


            Livewire.dispatch('sendAwnser', {
                type: 'awnser',
                sdp: answer.sdp
            });

            pc.ontrack = e => console.log(e);



        });
    </script>
@endscript
