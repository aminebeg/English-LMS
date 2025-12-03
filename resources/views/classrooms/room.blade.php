<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $classroom->title }} - Live Room</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #111827; color: white; overflow: hidden; }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            padding: 1rem;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }
        .video-container {
            position: relative;
            background: #1f2937;
            border-radius: 0.5rem;
            overflow: hidden;
            aspect-ratio: 16/9;
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .participant-label {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.6);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        .controls-bar {
            height: 80px;
            background: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            border-top: 1px solid #374151;
        }
        .control-btn {
            padding: 0.75rem;
            border-radius: 50%;
            background: #374151;
            border: none;
            color: white;
            cursor: pointer;
            transition: background 0.2s;
        }
        .control-btn:hover { background: #4b5563; }
        .control-btn.active { background: #ef4444; }
    </style>
</head>
<body>

    <div class="video-grid" id="video-grid">
        <!-- Local Video -->
        <div class="video-container">
            <video id="local-video" autoplay muted playsinline></video>
            <div class="participant-label">You ({{ auth()->user()->name }})</div>
        </div>
        <!-- Remote videos will be added here -->
    </div>

    <div class="controls-bar">
        <button class="control-btn" id="btn-mic" onclick="toggleAudio()">
            🎤
        </button>
        <button class="control-btn" id="btn-cam" onclick="toggleVideo()">
            📷
        </button>
        <form action="{{ route('classrooms.leave', $classroom) }}" method="POST">
            @csrf
            <button type="submit" class="control-btn" style="background: #ef4444; border-radius: 8px; padding: 0.75rem 1.5rem;">
                Leave Room
            </button>
        </form>
    </div>

    <script>
        const classroomId = {{ $classroom->id }};
        const currentUserId = {{ auth()->id() }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        const localVideo = document.getElementById('local-video');
        const videoGrid = document.getElementById('video-grid');
        
        let localStream;
        let peers = {}; // Store RTCPeerConnection objects: { userId: connection }
        let iceCandidatesQueue = {}; // Store candidates that arrive before remote description

        const rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };

        // Initialize
        async function init() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                localVideo.srcObject = localStream;
                
                // Start polling for signals
                setInterval(pollSignals, 2000);
                
                console.log('WebRTC initialized. Waiting for peers...');
            } catch (err) {
                console.error('Error accessing media devices:', err);
                alert('Could not access camera/microphone. Please allow permissions.');
            }
        }

        // Poll for signals from server
        async function pollSignals() {
            try {
                const response = await fetch(`/classrooms/${classroomId}/signal`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                
                // Handle signals
                for (const signal of data.signals) {
                    await handleSignal(signal);
                }

                // Handle new participants (simple discovery)
                for (const p of data.participants) {
                    if (p.id !== currentUserId && !peers[p.id]) {
                        // Found a new peer we aren't connected to yet.
                        // To avoid collision, let's say the one with higher ID initiates the offer.
                        if (currentUserId > p.id) {
                            createPeer(p.id, p.name, true);
                        }
                    }
                }
            } catch (err) {
                console.error('Polling error:', err);
            }
        }

        // Handle incoming signal
        async function handleSignal(signal) {
            console.log('Received signal:', signal.type, 'from', signal.sender_id);
            const senderId = signal.sender_id;
            const payload = JSON.parse(signal.payload);

            if (!peers[senderId]) {
                createPeer(senderId, signal.sender.name, false);
            }
            
            const pc = peers[senderId];

            if (signal.type === 'offer') {
                await pc.setRemoteDescription(new RTCSessionDescription(payload));
                const answer = await pc.createAnswer();
                await pc.setLocalDescription(answer);
                sendSignal(senderId, 'answer', JSON.stringify(answer));
                
                // Process queued candidates
                if (iceCandidatesQueue[senderId]) {
                    for (const candidate of iceCandidatesQueue[senderId]) {
                        await pc.addIceCandidate(candidate);
                    }
                    delete iceCandidatesQueue[senderId];
                }
            } else if (signal.type === 'answer') {
                await pc.setRemoteDescription(new RTCSessionDescription(payload));
            } else if (signal.type === 'candidate') {
                if (pc.remoteDescription) {
                    await pc.addIceCandidate(new RTCIceCandidate(payload));
                } else {
                    if (!iceCandidatesQueue[senderId]) iceCandidatesQueue[senderId] = [];
                    iceCandidatesQueue[senderId].push(new RTCIceCandidate(payload));
                }
            }
        }

        // Create Peer Connection
        function createPeer(remoteUserId, remoteUserName, isInitiator) {
            console.log('Creating peer connection to:', remoteUserId, 'Initiator:', isInitiator);
            
            const pc = new RTCPeerConnection(rtcConfig);
            peers[remoteUserId] = pc;

            // Add local tracks
            localStream.getTracks().forEach(track => pc.addTrack(track, localStream));

            // Handle ICE candidates
            pc.onicecandidate = (event) => {
                if (event.candidate) {
                    sendSignal(remoteUserId, 'candidate', JSON.stringify(event.candidate));
                }
            };

            // Handle remote stream
            pc.ontrack = (event) => {
                console.log('Received remote track from:', remoteUserId);
                let videoContainer = document.getElementById(`container-${remoteUserId}`);
                
                if (!videoContainer) {
                    videoContainer = document.createElement('div');
                    videoContainer.id = `container-${remoteUserId}`;
                    videoContainer.className = 'video-container';
                    videoContainer.innerHTML = `
                        <video id="video-${remoteUserId}" autoplay playsinline></video>
                        <div class="participant-label">${remoteUserName}</div>
                    `;
                    videoGrid.appendChild(videoContainer);
                }
                
                const remoteVideo = document.getElementById(`video-${remoteUserId}`);
                if (remoteVideo.srcObject !== event.streams[0]) {
                    remoteVideo.srcObject = event.streams[0];
                }
            };
            
            // Cleanup on disconnect
            pc.oniceconnectionstatechange = () => {
                if (pc.iceConnectionState === 'disconnected' || pc.iceConnectionState === 'closed') {
                    document.getElementById(`container-${remoteUserId}`)?.remove();
                    delete peers[remoteUserId];
                }
            };

            // If initiator, create offer
            if (isInitiator) {
                pc.onnegotiationneeded = async () => {
                    try {
                        const offer = await pc.createOffer();
                        await pc.setLocalDescription(offer);
                        sendSignal(remoteUserId, 'offer', JSON.stringify(offer));
                    } catch (err) {
                        console.error('Error creating offer:', err);
                    }
                };
            }
            
            return pc;
        }

        // Send signal to server
        async function sendSignal(receiverId, type, payload) {
            await fetch(`/classrooms/${classroomId}/signal`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    type: type,
                    payload: payload
                })
            });
        }

        // Controls
        function toggleAudio() {
            const audioTrack = localStream.getAudioTracks()[0];
            if (audioTrack) {
                audioTrack.enabled = !audioTrack.enabled;
                document.getElementById('btn-mic').classList.toggle('active');
                document.getElementById('btn-mic').innerText = audioTrack.enabled ? '🎤' : '🔇';
            }
        }

        function toggleVideo() {
            const videoTrack = localStream.getVideoTracks()[0];
            if (videoTrack) {
                videoTrack.enabled = !videoTrack.enabled;
                document.getElementById('btn-cam').classList.toggle('active');
                document.getElementById('btn-cam').innerText = videoTrack.enabled ? '📷' : '🚫';
            }
        }

        // Start
        init();
    </script>
</body>
</html>
