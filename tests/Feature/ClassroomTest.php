<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles if they don't exist
        if (!Role::where('name', 'tutor')->exists()) {
            Role::create(['name' => 'tutor']);
        }
        if (!Role::where('name', 'student')->exists()) {
            Role::create(['name' => 'student']);
        }
    }

    public function test_tutor_can_create_classroom()
    {
        $tutor = User::factory()->create(['is_approved' => true]);
        $tutor->assignRole('tutor');

        $response = $this->actingAs($tutor)->post(route('classrooms.store'), [
            'title' => 'Test Classroom',
            'description' => 'A test classroom description',
            'max_participants' => 20,
            'is_public' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('classrooms', [
            'title' => 'Test Classroom',
            'teacher_id' => $tutor->id,
        ]);
    }

    public function test_student_can_browse_classrooms()
    {
        $student = User::factory()->create(['is_approved' => true]);
        $student->assignRole('student');

        Classroom::create([
            'teacher_id' => User::factory()->create(['is_approved' => true])->id,
            'title' => 'Public Classroom',
            'max_participants' => 10,
            'is_public' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->get(route('classrooms.browse'));

        $response->assertStatus(200);
        $response->assertSee('Public Classroom');
    }

    public function test_student_can_join_classroom_via_code()
    {
        $tutor = User::factory()->create(['is_approved' => true]);
        $classroom = Classroom::create([
            'teacher_id' => $tutor->id,
            'title' => 'Private Classroom',
            'max_participants' => 10,
            'is_active' => true,
            'join_code' => 'ABC12345',
        ]);

        $student = User::factory()->create(['is_approved' => true]);
        $student->assignRole('student');

        $response = $this->actingAs($student)->followingRedirects()->post(route('classrooms.join-code'), [
            'join_code' => 'ABC12345',
        ]);

        $response->assertViewIs('classrooms.room');
        
        $this->assertDatabaseHas('classroom_participants', [
            'classroom_id' => $classroom->id,
            'user_id' => $student->id,
        ]);
    }

    public function test_tutor_can_start_and_end_session()
    {
        $tutor = User::factory()->create(['is_approved' => true]);
        $tutor->assignRole('tutor');

        $classroom = Classroom::create([
            'teacher_id' => $tutor->id,
            'title' => 'Session Test',
            'max_participants' => 10,
            'is_active' => true,
        ]);

        // Start session
        $response = $this->actingAs($tutor)->post(route('classrooms.start', $classroom));
        $response->assertRedirect(route('classrooms.room', $classroom));
        
        $this->assertDatabaseHas('classrooms', [
            'id' => $classroom->id,
            'status' => 'live',
        ]);

        $this->assertDatabaseHas('classroom_sessions', [
            'classroom_id' => $classroom->id,
            'ended_at' => null,
        ]);

        // End session
        $response = $this->actingAs($tutor)->post(route('classrooms.end', $classroom));
        $response->assertRedirect(route('classrooms.show', $classroom));

        $this->assertDatabaseHas('classrooms', [
            'id' => $classroom->id,
            'status' => 'ended',
        ]);
    }
}
