<p>Hello {{ $application->full_name }},</p>
<p>Thank you for your interest in DevRoots Academy. After reviewing your application for <strong>{{ $application->course?->title ?? 'your selected course' }}</strong>, we are unable to move it forward at this time.</p>
@if($application->review_notes)
<p><strong>Review note:</strong> {{ $application->review_notes }}</p>
@endif
<p>Application status: <strong>Rejected</strong></p>
<p>Regards,<br>DevRoots Academy Admissions</p>
