<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('frontend.contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:3000',
        ], [
            'message.min' => 'Please write at least 10 characters in your message.',
        ]);

        $contactMessage = ContactMessage::create($request->only('name', 'email', 'subject', 'message'));

        $contactAddress = config('mail.notifications.contact_address', 'info@devroots.ac.ug');

        if ($contactAddress) {
            rescue(function () use ($contactAddress, $contactMessage) {
                Mail::to($contactAddress)->send(new AdminContactMessageMail($contactMessage));
            }, report: true);
        }

        return back()->with('contact_success', 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.');
    }
}
