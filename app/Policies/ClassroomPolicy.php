<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassroomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can browse classrooms
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Classroom $classroom): bool
    {
        // Teacher can always view their classroom
        if ($classroom->teacher_id === $user->id) {
            return true;
        }

        // Public classrooms can be viewed by anyone
        if ($classroom->is_public) {
            return true;
        }

        // Participants can view private classrooms they're part of
        return $classroom->hasParticipant($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only tutors and editors can create classrooms
        return $user->hasRole('tutor') || $user->hasRole('editor');
    }

    /**
     * Determine whether the user can join a classroom.
     */
    public function join(User $user, Classroom $classroom): bool
    {
        // Teacher can always join their classroom
        if ($classroom->teacher_id === $user->id) {
            return true;
        }

        // Check if classroom is active and not full
        if (!$classroom->canJoin()) {
            return false;
        }

        // Public classrooms can be joined by anyone
        if ($classroom->is_public) {
            return true;
        }

        // Private classrooms only by participants
        return $classroom->hasParticipant($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classroom $classroom): bool
    {
        // Only the teacher who created the classroom can update it
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        // Only the teacher who created the classroom can delete it
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }
}
