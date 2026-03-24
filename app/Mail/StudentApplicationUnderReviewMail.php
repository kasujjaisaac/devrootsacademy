<?php

namespace App\Mail;

use App\Models\StudentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApplicationUnderReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StudentApplication $application)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Your Application Is Under Review - DevRoots Academy')
            ->view('emails.student-applications.under-review');
    }
}
