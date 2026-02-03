@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Courses</h1>
        <a href="{{ route('admin.courses.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Course</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Title</th>
                <th class="px-4 py-2 border">Category</th>
                <th class="px-4 py-2 border">Fee (UGX)</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr class="text-center">
                <td class="px-4 py-2 border">{{ $course->title }}</td>
                <td class="px-4 py-2 border">{{ $course->category }}</td>
                <td class="px-4 py-2 border">{{ $course->fee ?? 'N/A' }}</td>
                <td class="px-4 py-2 border flex justify-center gap-2">
                    <a href="{{ route('admin.courses.edit', $course->id) }}"
                       class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>

                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this course?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-2 border text-center">No courses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
