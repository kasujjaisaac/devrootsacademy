<p>Hello {{ $application->full_name }},</p>
<p>Thank you for applying to become an instructor at DevRoots Academy. After review, we are unable to move your application forward at this time.</p>
@if($application->review_notes)
<p><strong>Review note:</strong> {{ $application->review_notes }}</p>
@endif
<p>Application status: <strong>Rejected</strong></p>
<p>Regards,<br>DevRoots Academy Team</p>
