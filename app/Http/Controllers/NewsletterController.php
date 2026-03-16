<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:newsletter_subscribers,email',
        ], [
            'email.unique' => 'This email is already subscribed to our newsletter.',
        ]);

        NewsletterSubscriber::create(['email' => $request->email]);

        return back()->with('newsletter_success', 'You have been subscribed successfully!');
    }
}
