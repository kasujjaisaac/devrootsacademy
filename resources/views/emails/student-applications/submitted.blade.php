<p>Hello {{ $application->full_name }},</p>
<p>We have received your application to DevRoots Academy for <strong>{{ $application->course?->title ?? 'your selected course' }}</strong>.</p>
<p>Our admissions team will review it and contact you with the next update.</p>
<p>Application status: <strong>Submitted</strong></p>
<p>Regards,<br>DevRoots Academy Admissions</p>
