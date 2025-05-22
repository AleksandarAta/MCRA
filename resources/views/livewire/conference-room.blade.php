<div id="room" class="absolute top-2/4 left-2/4 w-1/3 h-1/3">
</div>

@script
    <script>
        document.addEventListener('startConferenece', async function() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });
                const videoElement = document.createElement('video');
                videoElement.srcObject = stream;
                videoElement.autoplay = true;
                videoElement.playsInline = true;

                document.getElementById('room').appendChild(videoElement);
            } catch (err) {
                console.error('Camera error:', err);
            }
        });
    </script>
@endscript
