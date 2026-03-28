<div class="ad-card">
  <div class="ad-card-head">
    <h3>{{ $recording->exists ? 'Edit Lecture Recording' : 'Add Lecture Recording' }}</h3>
  </div>
  <div class="ad-card-body">
    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;">
      <div class="ad-form-group">
        <label class="ad-label" for="course_id">Course</label>
        <select id="course_id" name="course_id" class="ad-select" required>
          <option value="">Select course</option>
          @foreach($courses as $course)
            <option value="{{ $course->id }}" @selected((string) old('course_id', $recording->course_id) === (string) $course->id)>{{ $course->title }}</option>
          @endforeach
        </select>
      </div>

      <div class="ad-form-group">
        <label class="ad-label" for="class_date">Class Recording Date</label>
        <input id="class_date" type="date" name="class_date" class="ad-input" value="{{ old('class_date', optional($recording->class_date)->format('Y-m-d')) }}" required>
      </div>

      <div class="ad-form-group">
        <label class="ad-label" for="title">Lecture Title</label>
        <input id="title" type="text" name="title" class="ad-input" value="{{ old('title', $recording->title) }}" required>
      </div>

      <div class="ad-form-group">
        <label class="ad-label" for="topic">Topic</label>
        <input id="topic" type="text" name="topic" class="ad-input" value="{{ old('topic', $recording->topic) }}" placeholder="Optional short topic">
      </div>
    </div>

    <div class="ad-form-group">
      <label class="ad-label" for="google_drive_url">Google Drive Link</label>
      <input id="google_drive_url" type="url" name="google_drive_url" class="ad-input" value="{{ old('google_drive_url', $recording->google_drive_url) }}" placeholder="https://drive.google.com/..." required>
      <p class="ad-input-hint">Paste the Google Drive share link for this class recording.</p>
    </div>

    <div class="ad-form-group">
      <label class="ad-label" for="description">Short Description</label>
      <textarea id="description" name="description" class="ad-input" rows="4" placeholder="Optional summary or note for students">{{ old('description', $recording->description) }}</textarea>
    </div>

    <label style="display:inline-flex;align-items:center;gap:10px;margin-top:4px;">
      <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $recording->exists ? $recording->is_published : true))>
      <span>Publish this recording to the student portal</span>
    </label>
  </div>
</div>

<div style="display:flex;justify-content:flex-end;gap:12px;margin-top:18px;">
  <a href="{{ route('admin.lecture-recordings.index') }}" class="btn-ad btn-ad-outline">Cancel</a>
  <button type="submit" class="btn-ad btn-ad-primary">
    <i class="fas fa-circle-play"></i> {{ $recording->exists ? 'Update Recording' : 'Save Recording' }}
  </button>
</div>
