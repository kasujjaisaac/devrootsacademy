<p>Hello {{ $application->full_name }},</p>
<p>We are pleased to inform you that your application for <strong>{{ $application->course?->title ?? 'your selected course' }}</strong> has been accepted.</p>
@if($application->student?->student_number)
<p>Your student number is <strong>{{ $application->student->student_number }}</strong>.</p>
@endif
<p>Our team will guide you through the enrollment step next.</p>
<p>Application status: <strong>Accepted</strong></p>
<p>Regards,<br>DevRoots Academy Admissions</p>
