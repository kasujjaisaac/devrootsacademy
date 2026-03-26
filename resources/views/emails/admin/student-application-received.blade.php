<p>A new student application has been submitted.</p>

<p><strong>Applicant:</strong> {{ $application->full_name }}</p>
<p><strong>Email:</strong> {{ $application->email ?? 'Not provided' }}</p>
<p><strong>Phone:</strong> {{ $application->phone }}</p>
<p><strong>Course:</strong> {{ $application->course?->title ?? 'Not assigned' }}</p>
<p><strong>Submitted At:</strong> {{ $application->created_at?->format('M d, Y g:i A') }}</p>

@if($application->goals)
<p><strong>Goals:</strong><br>{{ $application->goals }}</p>
@endif

<p>Log in to the admin dashboard to review this application.</p>
