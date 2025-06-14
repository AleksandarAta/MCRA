<x-app-layout>
    <div id="container">

        <h1><a href="//webrtc.github.io/samples/" title="WebRTC samples homepage">WebRTC samples</a> <span>Multiple peer
                connections</span>
        </h1>

        <video id="video1" playsinline autoplay muted></video>
        <video id="video2" playsinline autoplay></video>
        <video id="video3" playsinline autoplay></video>

        <div>
            <button id="startButton">Start</button>
            <button id="callButton">Call</button>
            <button id="hangupButton">Hang Up</button>
        </div>

        <p>View the console to see logging and to inspect the <code>MediaStream</code> object <code>localStream</code>.
        </p>

        <p>For more information about RTCPeerConnection, see <a
                href="http://www.html5rocks.com/en/tutorials/webrtc/basics/"
                title="HTML5 Rocks article about WebRTC by Sam Dutton">Getting
                Started With WebRTC</a>.</p>


        <a href="https://github.com/webrtc/samples/tree/gh-pages/src/content/peerconnection/multiple"
            title="View source for this page on GitHub" id="viewSource">View source on GitHub</a>

    </div>
</x-app-layout>
<script>
    const startButton = document.getElementById('startButton');
    const callButton = document.getElementById('callButton');
    const hangupButton = document.getElementById('hangupButton');
    callButton.disabled = true;
    hangupButton.disabled = true;
    startButton.onclick = start;
    callButton.onclick = call;
    hangupButton.onclick = hangup;

    const video1 = document.querySelector('video#video1');
    const video2 = document.querySelector('video#video2');
    const video3 = document.querySelector('video#video3');

    // eslint-disable-next-line prefer-const
    let preferredVideoCodecMimeType = 'video/VP8';

    let localStream;
    let pc1Local;
    let pc1Remote;
    let pc2Local;
    let pc2Remote;

    const supportsSetCodecPreferences = window.RTCRtpTransceiver &&
        'setCodecPreferences' in window.RTCRtpTransceiver.prototype;

    function maybeSetCodecPreferences(trackEvent) {
        if (!supportsSetCodecPreferences) return;
        if (trackEvent.track.kind === 'video' && preferredVideoCodecMimeType) {
            const {
                codecs
            } = RTCRtpReceiver.getCapabilities('video');
            const selectedCodecIndex = codecs.findIndex(c => c.mimeType === preferredVideoCodecMimeType);
            const selectedCodec = codecs[selectedCodecIndex];
            codecs.splice(selectedCodecIndex, 1);
            codecs.unshift(selectedCodec);
            trackEvent.transceiver.setCodecPreferences(codecs);
        }
    }

    async function start() {
        console.log('Requesting local stream');
        startButton.disabled = true;
        localStream = await navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true
        });
        video1.srcObject = localStream;
        callButton.disabled = false;
    }

    async function call() {
        callButton.disabled = true;
        hangupButton.disabled = false;
        console.log('Starting calls');
        const audioTracks = localStream.getAudioTracks();
        const videoTracks = localStream.getVideoTracks();
        if (audioTracks.length > 0) {
            console.log(`Using audio device: ${audioTracks[0].label}`);
        }
        if (videoTracks.length > 0) {
            console.log(`Using video device: ${videoTracks[0].label}`);
        }
        // Create an RTCPeerConnection via the polyfill.

        pc1Local = new RTCPeerConnection();
        pc1Remote = new RTCPeerConnection();
        pc1Remote.ontrack = e => gotRemoteStream(e, video2);
        console.log('pc1: created local and remote peer connection objects');

        pc2Local = new RTCPeerConnection();
        pc2Remote = new RTCPeerConnection();
        pc2Remote.ontrack = e => gotRemoteStream(e, video3);
        console.log('pc2: created local and remote peer connection objects');
        localStream.getTracks().forEach(track => {
            pc1Local.addTrack(track, localStream);
            pc2Local.addTrack(track, localStream);
        });
        await Promise.all([
            negotiate(pc1Local, pc1Remote),
            negotiate(pc2Local, pc2Remote),
        ]);
    }

    async function negotiate(localPc, remotePc) {
        localPc.onicecandidate = e => remotePc.addIceCandidate(e.candidate);
        remotePc.onicecandidate = e => localPc.addIceCandidate(e.candidate);

        await localPc.setLocalDescription();
        await remotePc.setRemoteDescription(localPc.localDescription);
        await remotePc.setLocalDescription();
        await localPc.setRemoteDescription(remotePc.localDescription);
    }

    function hangup() {
        console.log('Ending calls');
        pc1Local.close();
        pc1Remote.close();
        pc2Local.close();
        pc2Remote.close();
        pc1Local = pc1Remote = null;
        pc2Local = pc2Remote = null;
        hangupButton.disabled = true;
        callButton.disabled = false;
    }

    function gotRemoteStream(e, videoObject) {
        maybeSetCodecPreferences(e);
        if (videoObject.srcObject !== e.streams[0]) {
            videoObject.srcObject = e.streams[0];
        }
    }
</script>
