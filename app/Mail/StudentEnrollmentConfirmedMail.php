<?php

namespace App\Mail;

use App\Models\StudentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentEnrollmentConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StudentApplication $application)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Enrollment Confirmed - DevRoots Academy')
            ->view('emails.student-applications.enrollment-confirmed');
    }
}
