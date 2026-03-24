<?php

namespace App\Mail;

use App\Models\InstructorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorApplicationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public InstructorApplication $application)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Instructor Application Accepted - DevRoots Academy')
            ->view('emails.instructor-applications.accepted');
    }
}
