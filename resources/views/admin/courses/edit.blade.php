@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Course</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $course->slug) }}"
                   class="w-full border px-3 py-2 rounded" required>
            <small class="text-gray-500">URL-friendly unique identifier (e.g., programming-fundamentals)</small>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Category</label>
            <input type="text" name="category" value="{{ old('category', $course->category) }}"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border px-3 py-2 rounded" required>{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Current Image</label>
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="mb-2 w-48">
            @endif
            <input type="file" name="image" class="w-full border px-3 py-2 rounded">
            <small class="text-gray-500">Leave empty if you don't want to change the image</small>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Fee (UGX)</label>
            <input type="number" name="fee" value="{{ old('fee', $course->fee) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Course Outline (Optional)</label>
            <textarea name="outline" id="outline" rows="4"
                      class="w-full border px-3 py-2 rounded">{{ old('outline', $course->outline) }}</textarea>
        </div>

        <!-- TinyMCE -->
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#outline',
                height: 300,
                menubar: false,
                plugins: 'table lists',
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | table',
                content_style: "body { font-family:Arial,sans-serif; font-size:14px }"
            });
        </script>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Course
        </button>
    </form>
</div>
@endsection
