<?php

namespace App\Mail;

use App\Models\StudentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewStudentApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StudentApplication $application)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Student Application Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.student-application-received',
        );
    }
}
