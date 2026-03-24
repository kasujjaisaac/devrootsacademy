<p>Hello {{ $application->full_name }},</p>
<p>Your application for <strong>{{ $application->course?->title ?? 'your selected course' }}</strong> is now under review.</p>
<p>We are currently assessing your submission and will share a decision once the review is complete.</p>
<p>Application status: <strong>Under Review</strong></p>
<p>Regards,<br>DevRoots Academy Admissions</p>
