<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $classroom->title }} - Live Room</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://8x8.vc/vpaas-magic-cookie-9c575dcad3cc43679f065eb4d0fd1bed/external_api.js"></script>
    
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        
        #meet-container {
            height: 100vh;
            width: 100vw;
        }
        
        #classroom-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(75, 85, 99, 0.3);
            padding: 1rem 1.5rem;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        #meet {
            height: calc(100vh - 70px);
            margin-top: 70px;
        }
    </style>
</head>
<body class="bg-gray-900">
    {{-- Header --}}
    <div id="classroom-header">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-white font-semibold text-lg">{{ $classroom->title }}</h1>
                <p class="text-gray-400 text-xs">
                    Join Code: <span class="text-white font-mono">{{ $classroom->join_code }}</span>
                    @if($classroom->course)
                        <span class="ml-3">📚 {{ $classroom->course->title }}</span>
                    @endif
                </p>
            </div>
            
            @if($classroom->status === 'live')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white animate-pulse">
                    <span class="mr-1">🔴</span> LIVE
                </span>
            @endif
        </div>
        
        <div class="flex items-center gap-3">
            @if($classroom->isTeacher(auth()->user()))
                {{-- Teacher Controls --}}
                @if($classroom->status !== 'live')
                    <form action="{{ route('classrooms.start', $classroom) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors">
                            Start Session
                        </button>
                    </form>
                @else
                    <form action="{{ route('classrooms.end', $classroom) }}" method="POST" class="inline" onsubmit="return confirm('End this session? All participants will be disconnected.')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                            End Session
                        </button>
                    </form>
                @endif
            @else
                {{-- Student Controls --}}
                <form action="{{ route('classrooms.leave', $classroom) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                        Leave Room
                    </button>
                </form>
            @endif
            
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-md transition-colors">
                Exit
            </a>
        </div>
    </div>

    {{-- Jitsi Meet Container --}}
    <div id="meet"></div>

    <script>
        // Jitsi Meet Configuration
        const domain = '8x8.vc';
        const options = {
            roomName: 'vpaas-magic-cookie-9c575dcad3cc43679f065eb4d0fd1bed/{{ $classroom->join_code }}',
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#meet'),
            configOverwrite: {
                startWithAudioMuted: {{ $classroom->isTeacher(auth()->user()) ? 'false' : 'true' }},
                startWithVideoMuted: {{ $classroom->isTeacher(auth()->user()) ? 'false' : 'true' }},
                prejoinPageEnabled: false,
                disableDeepLinking: true,
            },
            interfaceConfigOverwrite: {
                TOOLBAR_BUTTONS: [
                    'microphone',
                    'camera',
                    'closedcaptions',
                    'desktop',
                    'fullscreen',
                    'fodeviceselection',
                    'hangup',
                    'chat',
                    'raisehand',
                    'videoquality',
                    'filmstrip',
                    'tileview',
                    'settings',
                    'shortcuts',
                    'stats',
                ],
                SHOW_JITSI_WATERMARK: false,
                SHOW_WATERMARK_FOR_GUESTS: false,
                DEFAULT_BACKGROUND: '#111827',
                DISABLE_JOIN_LEAVE_NOTIFICATIONS: false,
            },
            userInfo: {
                displayName: '{{ auth()->user()->name }}',
                email: '{{ auth()->user()->email }}',
            }
        };

        // Initialize Jitsi Meet
        const api = new JitsiMeetExternalAPI(domain, options);

        // Event listeners
        api.addEventListener('readyToClose', () => {
            window.location.href = '{{ route('classrooms.show', $classroom) }}';
        });

        api.addEventListener('videoConferenceJoined', (data) => {
            console.log('Joined conference:', data);
            
            @if($classroom->isTeacher(auth()->user()))
                // Teacher starts with unmuted mic and camera
                api.executeCommand('toggleAudio');
                api.executeCommand('toggleVideo');
            @endif
        });

        // Notify server when user leaves
        window.addEventListener('beforeunload', () => {
            // You can send AJAX request here to update participant status
        });
    </script>
</body>
</html>
