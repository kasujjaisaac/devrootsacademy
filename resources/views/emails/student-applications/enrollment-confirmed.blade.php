<p>Hello {{ $application->full_name }},</p>
<p>Your enrollment at DevRoots Academy has been confirmed for <strong>{{ $application->enrollment?->course?->title ?? $application->course?->title ?? 'your selected course' }}</strong>.</p>
<p>Your student portal account has been created using this email address.</p>
<p>Please check your inbox for a separate password setup email, then use it to create your password and sign in to your portal here: <a href="{{ url('/student') }}">{{ url('/student') }}</a>.</p>
<p>Once signed in, you will be able to view your profile, payments, calendar, and other onboarding information.</p>
<p>Our team will also contact you with any additional onboarding details, schedules, and next steps to begin your learning journey.</p>
<p>Application status: <strong>Enrolled</strong></p>
<p>Regards,<br>DevRoots Academy Admissions</p>
