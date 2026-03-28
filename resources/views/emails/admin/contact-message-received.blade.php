<p>A new message was submitted through the website contact form.</p>

<p><strong>Name:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> {{ $contactMessage->email }}</p>
<p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>

<p><strong>Message:</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>

<p>Reply directly to this email to respond to the sender.</p>
