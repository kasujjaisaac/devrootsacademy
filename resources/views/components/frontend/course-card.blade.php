{{--
    Reusable course card component — homepage featured courses grid.

    Props:
      $image    — full URL or relative asset path
      $title    — course title string
      $desc     — short description
      $duration — e.g. "8 Weeks"
      $level    — e.g. "Beginner", "Intermediate", "Advanced"
      $enrollmentStatus — array with label, tone, message
      $fee      — formatted fee string
      $actionLabel — button label
      $slug     — (optional) course slug for detail page; falls back to apply-now
--}}
<div class="course-card">
    <div class="course-card-img">
        <img src="{{ \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '/']) ? $image : asset($image) }}" alt="{{ $title }}" loading="lazy">
    </div>
    <div class="course-card-body">
        <div class="course-meta-tags">
            @if($duration)
                <span class="course-tag"><i class="fas fa-clock"></i> {{ $duration }}</span>
            @endif
            @if($level)
                <span class="course-tag level-{{ strtolower($level) }}">{{ $level }}</span>
            @endif
            @if(!empty($enrollmentStatus))
                <span class="course-tag" style="{{ $enrollmentStatus['tone'] === 'closed' ? 'background:rgba(198,40,40,0.12);color:#9f1d26;' : ($enrollmentStatus['tone'] === 'closing' ? 'background:rgba(217,119,6,0.14);color:#b45309;' : 'background:rgba(22,163,74,0.12);color:#166534;') }}">
                    {{ $enrollmentStatus['label'] }}
                </span>
            @endif
        </div>
        <h3>{{ $title }}</h3>
        <p>{{ $desc }}</p>
        <div class="d-flex align-items-center justify-content-between mt-auto mb-3 flex-wrap gap-1">
            @if(!empty($fee))
                <span class="course-fee">{{ $fee }}</span>
            @endif
        </div>
        <a href="{{ !empty($slug) ? route('courses.show', $slug) : route('apply.now') }}" class="btn btn-primary btn-sm w-100">
            {{ $actionLabel ?? (!empty($slug) ? 'View Course' : 'Apply Now') }}
        </a>
    </div>
</div>
