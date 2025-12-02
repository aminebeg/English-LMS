# Virtual Classrooms - Implementation Plan

## Overview
A real-time virtual classroom system allowing teachers to conduct live sessions with students, featuring video/audio communication, screen sharing, and text chat.

## Core Features

### 1. Classroom Management
- Teachers can create/edit/delete classrooms
- Classrooms can be:
  - **Course-linked**: Associated with a specific course for live sessions
  - **Independent**: Standalone classrooms for general lessons
- Classroom settings: title, description, max participants, schedule

### 2. Participant Management
- Students can browse and join available classrooms
- Join codes/links for easy access
- Role-based access (Teacher/Student)
- Participant list with status indicators

### 3. Real-time Communication
- **Video/Audio**: WebRTC-based video conferencing
- **Screen Sharing**: Teacher can share screen
- **Text Chat**: Real-time messaging within classroom
- **Hand Raising**: Students can raise hand for questions

### 4. Session Management
- Start/End session controls
- Session recording (optional)
- Session history and analytics
- Attendance tracking

## Technology Stack

### Backend
- **Laravel**: Core application framework
- **Laravel Broadcasting**: Real-time events
- **Pusher/Laravel Reverb**: WebSocket server
- **WebRTC**: Peer-to-peer video/audio

### Frontend
- **JavaScript**: Core logic
- **WebRTC API**: Video/audio/screen sharing
- **Simple-Peer or PeerJS**: WebRTC wrapper library
- **Tailwind CSS**: Styling (existing)

### Real-time Options
**Option 1: Third-party Service (Recommended for MVP)**
- Agora.io (free tier: 10,000 minutes/month)
- Daily.co
- Jitsi (self-hosted, open source)

**Option 2: Custom WebRTC**
- Build from scratch using WebRTC + Socket.io
- More control but more complex

## Database Schema

### Tables

#### `classrooms`
```sql
- id (bigint, primary key)
- teacher_id (foreign key -> users.id)
- course_id (nullable, foreign key -> courses.id)
- title (string)
- description (text, nullable)
- slug (string, unique)
- join_code (string, unique, 6 chars)
- max_participants (integer, default 50)
- is_active (boolean, default true)
- is_public (boolean, default true)
- scheduled_at (datetime, nullable)
- duration_minutes (integer, nullable)
- status (enum: scheduled, live, ended)
- settings (json) - audio/video defaults, recording, etc.
- created_at, updated_at
```

#### `classroom_participants`
```sql
- id (bigint, primary key)
- classroom_id (foreign key)
- user_id (foreign key)
- role (enum: teacher, student)
- joined_at (datetime)
- left_at (datetime, nullable)
- is_active (boolean, current session)
- created_at, updated_at
```

#### `classroom_sessions`
```sql
- id (bigint, primary key)
- classroom_id (foreign key)
- started_at (datetime)
- ended_at (datetime, nullable)
- duration_minutes (integer, calculated)
- recording_url (string, nullable)
- participants_count (integer)
- created_at, updated_at
```

#### `classroom_messages`
```sql
- id (bigint, primary key)
- classroom_id (foreign key)
- user_id (foreign key)
- message (text)
- type (enum: text, system, announcement)
- created_at, updated_at
```

## Implementation Phases

### Phase 1: Database & Models ✅ (Start Here)
- Create migrations
- Create models with relationships
- Add policies for authorization

### Phase 2: Basic CRUD
- ClassroomController (create, edit, delete, view)
- Routes setup
- Teacher classroom management UI
- Student classroom browsing/joining UI

### Phase 3: Real-time Chat
- Setup Laravel Broadcasting
- Create chat events
- Implement chat UI
- Test messaging

### Phase 4: Video/Audio Integration
- Choose and integrate video service (Agora/Jitsi)
- Implement video grid UI
- Camera/microphone controls
- Test video streaming

### Phase 5: Screen Sharing
- Implement screen share controls
- Screen share view for students
- Toggle between camera and screen

### Phase 6: Advanced Features
- Hand raising
- Recording
- Attendance tracking
- Session analytics

## API Routes Structure

```php
// Classroom Management (Teacher)
POST   /classrooms                    - Create classroom
GET    /classrooms/{id}               - View classroom
PUT    /classrooms/{id}               - Update classroom
DELETE /classrooms/{id}               - Delete classroom
GET    /teacher/classrooms            - List teacher's classrooms

// Student Routes
GET    /classrooms                    - Browse public classrooms
POST   /classrooms/{id}/join          - Join classroom
POST   /classrooms/join-code          - Join via code
GET    /student/classrooms            - My joined classrooms

// Live Session
GET    /classrooms/{id}/room          - Enter classroom room
POST   /classrooms/{id}/start         - Start session
POST   /classrooms/{id}/end           - End session
GET    /classrooms/{id}/participants  - Get participants

// Chat
GET    /classrooms/{id}/messages      - Get chat history
POST   /classrooms/{id}/messages      - Send message

// Broadcasting Events
ClassroomJoined
ClassroomLeft
MessageSent
SessionStarted
SessionEnded
ParticipantStatusChanged
```

## UI Components

### Teacher Dashboard
1. **My Classrooms List**
   - Grid/list view
   - Create new classroom button
   - Quick actions (start, edit, delete)

2. **Classroom Form**
   - Basic info (title, description)
   - Settings (max participants, public/private)
   - Course association dropdown
   - Schedule settings

3. **Classroom Room (Live)**
   - Video grid (teacher + students)
   - Sidebar: Participants list & Chat
   - Controls: Camera, Mic, Screen Share, End Session
   - Student hand-raises notification

### Student Dashboard
1. **Browse Classrooms**
   - Filter by course/teacher
   - Join button
   - Join via code input

2. **My Classrooms**
   - Enrolled classrooms
   - Upcoming sessions
   - Join active sessions

3. **Classroom Room (Live)**
   - Video grid view
   - Chat panel
   - Raise hand button
   - Leave button

## WebRTC Solution: Agora.io (Recommended)

### Why Agora?
- Free tier (10K minutes/month)
- Easy integration
- Excellent documentation
- Screen sharing built-in
- Laravel-friendly

### Integration Steps
1. Sign up for Agora account
2. Get App ID and App Certificate
3. Install Agora JS SDK via CDN
4. Generate tokens server-side (Laravel)
5. Initialize Agora client in classroom room
6. Handle join/leave events

### Alternative: Jitsi Meet
- Completely free
- Self-hosted option
- Iframe embed integration
- Less customization but faster setup

## Security Considerations
- Join code validation
- Participant authorization
- Rate limiting on joins
- Session token expiration
- HTTPS required for WebRTC
- Input sanitization for chat

## Next Steps

1. **Start with Phase 1**: Create database migrations and models
2. **Setup basic CRUD**: Teacher can create/manage classrooms
3. **Integrate Agora/Jitsi**: Get video working
4. **Add chat**: Real-time messaging
5. **Polish UI**: Make it beautiful and intuitive
6. **Test thoroughly**: Multi-user testing

## Estimated Timeline
- Phase 1 (DB/Models): 1-2 hours
- Phase 2 (CRUD UI): 2-3 hours
- Phase 3 (Chat): 1-2 hours
- Phase 4 (Video): 3-4 hours
- Phase 5 (Screen Share): 1 hour
- Phase 6 (Polish): 2-3 hours

**Total**: ~10-15 hours for full implementation

## Decision Points

1. **Video Service**: Agora.io (free tier) vs Jitsi (self-hosted)
2. **WebSocket**: Pusher (hosted) vs Laravel Reverb (self-hosted)
3. **Recording**: Server-side vs client-side vs disabled
4. **Mobile**: Responsive web vs native apps later

---

**Let's start with Phase 1!** 🚀
