@extends('layouts.admin')
@section('title', 'Edit Course')

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
            <span>Edit: {{ $course->title }}</span>
        </nav>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-arrow-left"></i> Back to Courses
    </a>
</div>

{{-- Session / Validation Alerts --}}
@if(session('success'))
<div class="ad-alert ad-alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

@if($errors->any())
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="ad-alert-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Edit Course Form --}}
<div class="ad-card">
    <div class="ad-card-head">
        <h3><i class="fas fa-pen" style="color:var(--ad-primary);margin-right:6px;"></i> Course Details</h3>
    </div>
    <div class="ad-card-body">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="ad-form-section">Basic Information</div>

            <div class="ad-form-row">
                <div class="ad-form-group">
                    <label class="ad-label">Title <span class="required">*</span></label>
                    <input type="text"
                           name="title"
                           class="ad-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                           value="{{ old('title', $course->title) }}"
                           placeholder="e.g. Programming Fundamentals"
                           required>
                    @if($errors->has('title'))
                        <p class="ad-error">{{ $errors->first('title') }}</p>
                    @endif
                </div>
                <div class="ad-form-group">
                    <label class="ad-label">Slug <span class="required">*</span></label>
                    <input type="text"
                           name="slug"
                           class="ad-input {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                           value="{{ old('slug', $course->slug) }}"
                           placeholder="e.g. programming-fundamentals"
                           required>
                    <p class="ad-input-hint">URL-friendly unique identifier (e.g. programming-fundamentals).</p>
                    @if($errors->has('slug'))
                        <p class="ad-error">{{ $errors->first('slug') }}</p>
                    @endif
                </div>
            </div>

            <div class="ad-form-row">
                <div class="ad-form-group">
                    <label class="ad-label">Category <span class="required">*</span></label>
                    <input type="text"
                           name="category"
                           class="ad-input {{ $errors->has('category') ? 'is-invalid' : '' }}"
                           value="{{ old('category', $course->category) }}"
                           placeholder="e.g. Web Development"
                           required>
                    @if($errors->has('category'))
                        <p class="ad-error">{{ $errors->first('category') }}</p>
                    @endif
                </div>
                <div class="ad-form-group">
                    <label class="ad-label">Fee (UGX)</label>
                    <input type="number"
                           name="fee"
                           class="ad-input {{ $errors->has('fee') ? 'is-invalid' : '' }}"
                           value="{{ old('fee', $course->fee) }}"
                           placeholder="e.g. 500000"
                           min="0">
                    <p class="ad-input-hint">Leave blank or 0 for a free course.</p>
                    @if($errors->has('fee'))
                        <p class="ad-error">{{ $errors->first('fee') }}</p>
                    @endif
                </div>
            </div>

            <div class="ad-form-group">
                <label class="ad-label">Description <span class="required">*</span></label>
                <textarea name="description"
                          class="ad-textarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                          rows="4"
                          placeholder="Brief overview of the course..."
                          required>{{ old('description', $course->description) }}</textarea>
                @if($errors->has('description'))
                    <p class="ad-error">{{ $errors->first('description') }}</p>
                @endif
            </div>

            <div class="ad-form-section">Media &amp; Curriculum</div>

            <div class="ad-form-group">
                <label class="ad-label">Course Image</label>

                @if($course->image)
                <div style="margin-bottom:10px;">
                    <p class="ad-input-hint" style="margin-bottom:6px;">Current image:</p>
                    <img src="{{ asset('storage/' . $course->image) }}"
                         alt="{{ $course->title }}"
                         style="max-width:200px;max-height:130px;object-fit:cover;border:1px solid var(--ad-border);">
                </div>
                @endif

                <input type="file"
                       name="image"
                       class="ad-input {{ $errors->has('image') ? 'is-invalid' : '' }}"
                       accept="image/*"
                       data-preview="imgPreview">
                <p class="ad-input-hint">Leave empty to keep the current image. Accepted: JPG, PNG, WEBP.</p>
                @if($errors->has('image'))
                    <p class="ad-error">{{ $errors->first('image') }}</p>
                @endif
                <img id="imgPreview" class="ad-img-preview" src="" alt="New image preview">
            </div>

            <div class="ad-form-group">
                <label class="ad-label">Course Outline / Curriculum</label>
                <textarea name="outline"
                          id="outline"
                          class="ad-textarea {{ $errors->has('outline') ? 'is-invalid' : '' }}"
                          rows="6"
                          placeholder="List the modules, topics, or weekly breakdown...">{{ old('outline', $course->outline) }}</textarea>
                <p class="ad-input-hint">Describe what students will learn, module by module.</p>
                @if($errors->has('outline'))
                    <p class="ad-error">{{ $errors->first('outline') }}</p>
                @endif
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn-ad btn-ad-primary">
                    <i class="fas fa-save"></i> Update Course
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
