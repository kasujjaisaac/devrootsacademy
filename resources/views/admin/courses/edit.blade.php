@extends('layouts.admin')
@section('title', 'Edit Course')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
/* ── Two-panel form layout ─────────────────────────────── */
.cf-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1024px) { .cf-grid { grid-template-columns: 1fr; } }

/* ── Quill editor ─────────────────────────────────────── */
#descEditor {
    background: #fff;
    border: 1px solid var(--ad-border);
    border-top: none;
    min-height: 220px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.875rem;
    color: var(--ad-text);
}
.ql-toolbar.ql-snow {
    border: 1px solid var(--ad-border);
    border-radius: 0;
    background: var(--ad-body-bg);
    padding: 6px 10px;
}
.ql-container.ql-snow { border-radius: 0; }
.ql-snow .ql-formats { margin-right: 10px; }
.ql-editor.ql-blank::before { font-style: normal; color: var(--ad-muted); }

/* ── Tag / pill input ─────────────────────────────────── */
.cf-tag-field {
    border: 1px solid var(--ad-border);
    background: #fff;
    padding: 6px 8px;
    min-height: 44px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
    cursor: text;
    transition: border-color .15s;
}
.cf-tag-field:focus-within { border-color: var(--ad-primary); }
.cf-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--ad-primary);
    color: #fff;
    font-size: 0.6875rem;
    font-weight: 500;
    padding: 3px 8px 3px 10px;
    white-space: nowrap;
    max-width: 100%;
}
.cf-tag-x {
    background: none;
    border: none;
    color: rgba(255,255,255,.7);
    cursor: pointer;
    font-size: 0.8125rem;
    padding: 0;
    line-height: 1;
    display: flex;
    align-items: center;
}
.cf-tag-x:hover { color: #fff; }
.cf-tag-input {
    border: none;
    outline: none;
    background: transparent;
    font-size: 0.8125rem;
    font-family: 'Poppins', sans-serif;
    color: var(--ad-text);
    flex: 1;
    min-width: 140px;
    padding: 2px 4px;
}
.cf-tag-input::placeholder { color: var(--ad-muted); }

/* ── Image upload zone ────────────────────────────────── */
.cf-upload-zone {
    border: 2px dashed var(--ad-border);
    background: var(--ad-body-bg);
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    position: relative;
}
.cf-upload-zone:hover,
.cf-upload-zone.drag-over {
    border-color: var(--ad-primary);
    background: rgba(198,40,40,.04);
}
.cf-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.cf-upload-icon { font-size: 1.75rem; color: var(--ad-muted); margin-bottom: 8px; }
.cf-upload-zone:hover .cf-upload-icon { color: var(--ad-primary); }
.cf-upload-text { font-size: 0.8125rem; color: var(--ad-muted); }
.cf-upload-text strong { color: var(--ad-primary); }
.cf-upload-hint { font-size: 0.6875rem; color: var(--ad-muted); margin-top: 4px; }
.cf-current-img {
    width: 100%;
    max-height: 160px;
    object-fit: cover;
    border: 1px solid var(--ad-border);
    margin-bottom: 10px;
    display: block;
}
.cf-img-preview {
    display: none;
    width: 100%;
    max-height: 180px;
    object-fit: cover;
    margin-top: 12px;
    border: 1px solid var(--ad-border);
}
.cf-img-preview.show { display: block; }

/* ── Toggle switch ────────────────────────────────────── */
.cf-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--ad-border);
}
.cf-toggle-row:last-of-type { border-bottom: none; }
.cf-toggle-label { font-size: 0.8125rem; font-weight: 500; color: var(--ad-text); }
.cf-toggle-sub { font-size: 0.6875rem; color: var(--ad-muted); margin-top: 1px; }
.cf-toggle { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
.cf-toggle input { opacity: 0; width: 0; height: 0; }
.cf-toggle-track {
    position: absolute;
    inset: 0;
    background: #d1d5db;
    cursor: pointer;
    transition: background .2s;
    border-radius: 24px;
}
.cf-toggle input:checked + .cf-toggle-track { background: var(--ad-primary); }
.cf-toggle-track::after {
    content: '';
    position: absolute;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #fff;
    top: 3px; left: 3px;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.cf-toggle input:checked + .cf-toggle-track::after { transform: translateX(18px); }

/* ── Char counter ─────────────────────────────────────── */
.cf-char-count { font-size: 0.6875rem; color: var(--ad-muted); text-align: right; margin-top: 4px; }
.cf-char-count.over { color: #ef4444; }

/* ── Sticky sidebar ───────────────────────────────────── */
.cf-sticky { position: sticky; top: 80px; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Edit Course</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.courses.index') }}">Courses</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $course->title }}</span>
        </nav>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="btn-ad btn-ad-outline">
            <i class="fas fa-arrow-up-right-from-square"></i> View
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="ad-alert ad-alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>{{ session('error') }}</div>
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if($errors->any())
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="ad-alert-list">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" id="courseForm">
@csrf
@method('PUT')

<div class="cf-grid">

    {{-- ════════════════════ MAIN (LEFT) ════════════════════ --}}
    <div>

        {{-- ── Basic Information ── --}}
        <div class="ad-card" style="margin-bottom:20px;">
            <div class="ad-card-head">
                <h3><i class="fas fa-circle-info" style="color:var(--ad-primary);margin-right:6px;"></i>Basic Information</h3>
            </div>
            <div class="ad-card-body">

                {{-- Title + Slug --}}
                <div class="ad-form-row">
                    <div class="ad-form-group">
                        <label class="ad-label">Title <span class="required">*</span></label>
                        <input type="text" name="title" id="titleInput"
                               class="ad-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               value="{{ old('title', $course->title) }}"
                               placeholder="e.g. Web Development Fundamentals"
                               required>
                        @error('title')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="ad-form-group">
                        <label class="ad-label">Slug <span class="required">*</span></label>
                        <input type="text" name="slug" id="slugInput"
                               class="ad-input {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                               value="{{ old('slug', $course->slug) }}"
                               placeholder="web-development-fundamentals"
                               data-edited="true"
                               required>
                        <p class="ad-input-hint">URL identifier — change with care (existing links will break).</p>
                        @error('slug')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Category + Level --}}
                <div class="ad-form-row">
                    <div class="ad-form-group">
                        <label class="ad-label">Category <span class="required">*</span></label>
                        <input type="text" name="category"
                               class="ad-input {{ $errors->has('category') ? 'is-invalid' : '' }}"
                               value="{{ old('category', $course->category) }}"
                               placeholder="e.g. Web Development"
                               list="categoryList"
                               required>
                        <datalist id="categoryList">
                            @foreach(\App\Models\Course::select('category')->distinct()->pluck('category') as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                        @error('category')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="ad-form-group">
                        <label class="ad-label">Level</label>
                        <select name="level" class="ad-input ad-select {{ $errors->has('level') ? 'is-invalid' : '' }}">
                            <option value="">— Select level —</option>
                            @foreach(['Beginner','Intermediate','Advanced'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('level', $course->level) == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                        @error('level')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Short Description --}}
                <div class="ad-form-group">
                    <label class="ad-label">Short Description</label>
                    <textarea name="short_description" id="shortDesc"
                              class="ad-textarea {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                              rows="2"
                              maxlength="500"
                              placeholder="One or two sentences summarising the course (used on cards)...">{{ old('short_description', $course->short_description) }}</textarea>
                    <div class="cf-char-count"><span id="shortDescCount">0</span> / 500</div>
                    @error('short_description')<p class="ad-error">{{ $message }}</p>@enderror
                </div>

                {{-- Full Description (Quill) --}}
                <div class="ad-form-group" style="margin-bottom:0;">
                    <label class="ad-label">Full Description <span class="required">*</span></label>
                    <div id="descEditor"></div>
                    <textarea name="description" id="descInput" hidden>{{ old('description', $course->description) }}</textarea>
                    <p class="ad-error" id="descClientError" hidden>Please add a course description.</p>
                    @error('description')<p class="ad-error">{{ $message }}</p>@enderror
                    <p class="ad-input-hint">Use the toolbar for headings, lists, links, and formatting.</p>
                </div>

            </div>
        </div>{{-- /Basic Info --}}

        {{-- ── Curriculum ── --}}
        <div class="ad-card">
            <div class="ad-card-head">
                <h3><i class="fas fa-list-check" style="color:var(--ad-primary);margin-right:6px;"></i>Course Outline / Curriculum</h3>
            </div>
            <div class="ad-card-body">
                <label class="ad-label">Topics &amp; Modules</label>
                <div class="cf-tag-field" id="tagField">
                    <input type="text" class="cf-tag-input" id="tagInput" placeholder="Type a topic and press Enter…">
                </div>
                {{-- Populated by JS with existing outline data --}}
                <textarea name="outline" id="outlineData" hidden>{{ old('outline', is_array($course->outline) ? implode("\n", $course->outline) : $course->outline) }}</textarea>
                <p class="ad-input-hint" style="margin-top:6px;">Press <kbd style="background:var(--ad-border);padding:1px 5px;font-size:0.6875rem;">Enter</kbd> to add each topic. Click a tag to remove it.</p>
                @error('outline')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
        </div>{{-- /Curriculum --}}

    </div>
    {{-- ════════════════════ / MAIN ════════════════════ --}}


    {{-- ════════════════════ SIDEBAR (RIGHT) ════════════════════ --}}
    <div class="cf-sticky">

        {{-- ── Publish Card ── --}}
        <div class="ad-card" style="margin-bottom:16px;">
            <div class="ad-card-head">
                <h3><i class="fas fa-paper-plane" style="color:var(--ad-primary);margin-right:6px;"></i>Publish</h3>
            </div>
            <div class="ad-card-body">
                <div class="cf-toggle-row">
                    <div>
                        <div class="cf-toggle-label">Active</div>
                        <div class="cf-toggle-sub">Show course to students</div>
                    </div>
                    <label class="cf-toggle">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                        <span class="cf-toggle-track"></span>
                    </label>
                </div>
                <div class="cf-toggle-row">
                    <div>
                        <div class="cf-toggle-label">Featured</div>
                        <div class="cf-toggle-sub">Highlight on homepage</div>
                    </div>
                    <label class="cf-toggle">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                        <span class="cf-toggle-track"></span>
                    </label>
                </div>

                <div style="display:flex;gap:10px;margin-top:16px;">
                    <button type="submit" class="btn-ad btn-ad-primary" style="flex:1;">
                        <i class="fas fa-save"></i> Update Course
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline">
                        Cancel
                    </a>
                </div>
            </div>
        </div>{{-- /Publish --}}

        {{-- ── Course Details Card ── --}}
        <div class="ad-card" style="margin-bottom:16px;">
            <div class="ad-card-head">
                <h3><i class="fas fa-sliders" style="color:var(--ad-primary);margin-right:6px;"></i>Course Details</h3>
            </div>
            <div class="ad-card-body">

                <div class="ad-form-row">
                    <div class="ad-form-group">
                        <label class="ad-label">Fee (UGX)</label>
                        <input type="number" name="fee"
                               class="ad-input {{ $errors->has('fee') ? 'is-invalid' : '' }}"
                               value="{{ old('fee', $course->fee) }}"
                               placeholder="e.g. 500000"
                               min="0" step="1">
                        <p class="ad-input-hint">Leave empty = free.</p>
                        @error('fee')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="ad-form-group">
                        <label class="ad-label">Duration (weeks)</label>
                        <input type="number" name="duration_weeks"
                               class="ad-input {{ $errors->has('duration_weeks') ? 'is-invalid' : '' }}"
                               value="{{ old('duration_weeks', $course->duration_weeks) }}"
                               placeholder="e.g. 12"
                               min="1">
                        @error('duration_weeks')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="ad-form-group">
                    <label class="ad-label">Delivery Mode</label>
                    <select name="mode" class="ad-input ad-select {{ $errors->has('mode') ? 'is-invalid' : '' }}">
                        <option value="">— Select mode —</option>
                        @foreach(['online' => 'Online','in-person' => 'In-Person','hybrid' => 'Hybrid'] as $val => $label)
                            <option value="{{ $val }}" {{ old('mode', $course->mode) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('mode')<p class="ad-error">{{ $message }}</p>@enderror
                </div>

                <div class="ad-form-group" style="margin-bottom:0;">
                    <label class="ad-label">Schedule</label>
                    <input type="text" name="schedule"
                           class="ad-input {{ $errors->has('schedule') ? 'is-invalid' : '' }}"
                           value="{{ old('schedule', $course->schedule) }}"
                           placeholder="e.g. Weekends, 9am–1pm">
                    @error('schedule')<p class="ad-error">{{ $message }}</p>@enderror
                </div>

                <div class="ad-form-group" style="margin-top:16px;margin-bottom:0;">
                    <label class="ad-label">Enrollment Close Date</label>
                    <input type="date" name="enrollment_close_date"
                           class="ad-input {{ $errors->has('enrollment_close_date') ? 'is-invalid' : '' }}"
                           value="{{ old('enrollment_close_date', optional($course->enrollment_close_date)->format('Y-m-d')) }}">
                    <p class="ad-input-hint">Applications will close automatically after this date.</p>
                    @error('enrollment_close_date')<p class="ad-error">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>{{-- /Details --}}

        {{-- ── Image Card ── --}}
        <div class="ad-card">
            <div class="ad-card-head">
                <h3><i class="fas fa-image" style="color:var(--ad-primary);margin-right:6px;"></i>Featured Image</h3>
            </div>
            <div class="ad-card-body">

                @if($course->image)
                <div style="margin-bottom:10px;">
                    <p class="ad-input-hint" style="margin-bottom:6px;font-weight:500;">Current image</p>
                    <img src="{{ asset('storage/' . $course->image) }}"
                         alt="{{ $course->title }}"
                         class="cf-current-img">
                </div>
                @endif

                <div class="cf-upload-zone" id="uploadZone">
                    <input type="file" name="image" id="imageInput" accept="image/*"
                           class="{{ $errors->has('image') ? 'is-invalid' : '' }}">
                    <div class="cf-upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                    <div class="cf-upload-text">
                        <strong>{{ $course->image ? 'Replace image' : 'Click to upload' }}</strong>
                        or drag &amp; drop
                    </div>
                    <div class="cf-upload-hint">JPG, PNG, WEBP — max 2 MB</div>
                </div>
                <img id="imgPreview" class="cf-img-preview" src="" alt="New image preview">
                @error('image')<p class="ad-error" style="margin-top:6px;">{{ $message }}</p>@enderror

            </div>
        </div>{{-- /Image --}}

    </div>
    {{-- ════════════════════ / SIDEBAR ════════════════════ --}}

</div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
/* ── Quill Init ─────────────────────────────────────── */
const quill = new Quill('#descEditor', {
    theme: 'snow',
    placeholder: 'Write a detailed course description…',
    modules: {
        toolbar: [
            [{ header: [2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'link'],
            ['clean']
        ]
    }
});

// Load existing content into Quill
const existingDesc = document.getElementById('descInput').value.trim();
if (existingDesc) {
    // If it looks like HTML, paste as HTML; otherwise set as plain text
    if (existingDesc.startsWith('<')) {
        quill.clipboard.dangerouslyPasteHTML(existingDesc);
    } else {
        quill.setText(existingDesc);
    }
}

const courseForm = document.getElementById('courseForm');
const descInput = document.getElementById('descInput');
const descClientError = document.getElementById('descClientError');

function syncDescription() {
    descInput.value = quill.root.innerHTML;
    descClientError.hidden = true;
}

quill.on('text-change', syncDescription);
syncDescription();

courseForm.addEventListener('submit', function (e) {
    syncDescription();

    if (!quill.getText().trim()) {
        e.preventDefault();
        descClientError.hidden = false;
    }
});

/* ── Auto-generate Slug ──────────────────────────────── */
const titleEl = document.getElementById('titleInput');
const slugEl  = document.getElementById('slugInput');
titleEl.addEventListener('input', function () {
    if (!slugEl.dataset.edited) {
        slugEl.value = this.value.toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
});
slugEl.addEventListener('input', () => slugEl.dataset.edited = 'true');

/* ── Short Description Counter ───────────────────────── */
const shortDesc = document.getElementById('shortDesc');
const countEl   = document.getElementById('shortDescCount');
function updateCount() {
    const n = shortDesc.value.length;
    countEl.textContent = n;
    countEl.parentElement.classList.toggle('over', n >= 490);
}
shortDesc.addEventListener('input', updateCount);
updateCount();

/* ── Tag / Outline Input ─────────────────────────────── */
const tagField    = document.getElementById('tagField');
const tagInput    = document.getElementById('tagInput');
const outlineData = document.getElementById('outlineData');

function syncOutline() {
    const tags = Array.from(tagField.querySelectorAll('.cf-tag span')).map(s => s.textContent.trim());
    outlineData.value = tags.join('\n');
}

function addTag(text) {
    text = text.trim();
    if (!text) return;
    const existing = Array.from(tagField.querySelectorAll('.cf-tag span')).map(s => s.textContent.trim());
    if (existing.includes(text)) { tagInput.value = ''; return; }

    const tag = document.createElement('div');
    tag.className = 'cf-tag';
    tag.innerHTML = `<span>${text}</span><button type="button" class="cf-tag-x" title="Remove"><i class="fas fa-times"></i></button>`;
    tag.querySelector('.cf-tag-x').addEventListener('click', () => { tag.remove(); syncOutline(); });
    tagField.insertBefore(tag, tagInput);
    tagInput.value = '';
    syncOutline();
}

tagInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); addTag(this.value); }
    if (e.key === 'Backspace' && !this.value) {
        const tags = tagField.querySelectorAll('.cf-tag');
        if (tags.length) { tags[tags.length - 1].remove(); syncOutline(); }
    }
});
tagField.addEventListener('click', () => tagInput.focus());

// Restore existing outline as tags
const savedOutline = outlineData.value.trim();
if (savedOutline) {
    savedOutline.split('\n').filter(v => v.trim()).forEach(addTag);
}

/* ── Image Upload Zone ───────────────────────────────── */
const uploadZone = document.getElementById('uploadZone');
const imageInput = document.getElementById('imageInput');
const imgPreview = document.getElementById('imgPreview');

function showPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => { imgPreview.src = e.target.result; imgPreview.classList.add('show'); };
    reader.readAsDataURL(file);
}

imageInput.addEventListener('change', () => showPreview(imageInput.files[0]));
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('drag-over');
    const dt = e.dataTransfer;
    if (dt.files.length) { imageInput.files = dt.files; showPreview(dt.files[0]); }
});
</script>
@endpush
