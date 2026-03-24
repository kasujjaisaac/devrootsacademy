<?php

namespace App\Mail;

use App\Models\StudentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApplicationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StudentApplication $application)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Application Update - DevRoots Academy')
            ->view('emails.student-applications.rejected');
    }
}
