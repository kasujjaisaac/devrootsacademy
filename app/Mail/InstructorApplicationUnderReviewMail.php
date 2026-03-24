<?php

namespace App\Mail;

use App\Models\InstructorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorApplicationUnderReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public InstructorApplication $application)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Your Instructor Application Is Under Review - DevRoots Academy')
            ->view('emails.instructor-applications.under-review');
    }
}
