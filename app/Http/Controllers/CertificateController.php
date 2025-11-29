<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function download(Course $course)
    {
        $user = Auth::user();

        // Check if user is enrolled
        if (!$course->isEnrolledBy($user)) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Check if course is completed
        $progress = $course->getProgressFor($user);
        if ($progress < 100) {
            return redirect()->back()->with('error', 'You must complete the course to download the certificate.');
        }

        $data = [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('F j, Y'),
            'id' => strtoupper(substr(md5($user->id . $course->id . $course->created_at), 0, 10))
        ];

        $pdf = Pdf::loadView('certificates.pdf', $data);
        
        return $pdf->download('certificate-' . \Str::slug($course->title) . '.pdf');
    }
}
