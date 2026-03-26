<p>Dear {{ $enrollment->student?->full_name ?? 'Student' }},</p>

<p>Your course <strong>{{ $enrollment->course?->title ?? 'course' }}</strong> has been marked as completed at DevRoots Academy.</p>

<p>You can sign in to your student portal to review your academic record, timetable history, and payment summary.</p>

<p>Student Number: <strong>{{ $enrollment->student?->student_number ?? 'Pending' }}</strong></p>

<p>Thank you for learning with DevRoots Academy.</p>
