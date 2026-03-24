@csrf

<div class="ad-card" style="padding:24px;">
    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;">
        <div style="grid-column:span 2;">
            <label class="ad-label">Course</label>
            <select name="course_id" class="ad-input {{ $errors->has('course_id') ? 'is-invalid' : '' }}" required>
                <option value="">Select course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id', $timetable->course_id) == $course->id)>{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id')<p class="ad-error">{{ $message }}</p>@enderror
        </div>

        <div style="grid-column:span 2;">
            <label class="ad-label">Session Title</label>
            <input type="text" name="title" class="ad-input {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', $timetable->title) }}" placeholder="e.g. UI/UX Design Weekday Class" required>
            @error('title')<p class="ad-error">{{ $message }}</p>@enderror
        </div>

        <div style="grid-column:span 2;">
            <label class="ad-label">Description</label>
            <textarea name="description" rows="4" class="ad-input {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Add session notes, venue, or delivery instructions.">{{ old('description', $timetable->description) }}</textarea>
            @error('description')<p class="ad-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="ad-label">Starts At</label>
            <input type="datetime-local" name="starts_at" class="ad-input {{ $errors->has('starts_at') ? 'is-invalid' : '' }}" value="{{ old('starts_at', optional($timetable->starts_at)->format('Y-m-d\TH:i')) }}" required>
            @error('starts_at')<p class="ad-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="ad-label">Ends At</label>
            <input type="datetime-local" name="ends_at" class="ad-input {{ $errors->has('ends_at') ? 'is-invalid' : '' }}" value="{{ old('ends_at', optional($timetable->ends_at)->format('Y-m-d\TH:i')) }}">
            @error('ends_at')<p class="ad-error">{{ $message }}</p>@enderror
        </div>
    </div>

    <div style="margin-top:18px;display:flex;align-items:center;gap:10px;">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $timetable->is_active ?? true))>
        <label for="is_active" style="margin:0;">Publish this timetable entry to enrolled students</label>
    </div>
</div>

<div style="margin-top:18px;display:flex;gap:10px;">
    <button type="submit" class="btn-ad btn-ad-primary">
        <i class="fas fa-save"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.timetables.index') }}" class="btn-ad btn-ad-outline">Cancel</a>
</div>
