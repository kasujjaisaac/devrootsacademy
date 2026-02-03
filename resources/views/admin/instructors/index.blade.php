@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Instructors</h1>

<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($instructors as $instructor)
        <tr>
            <td class="border px-4 py-2">{{ $instructor->name }}</td>
            <td class="border px-4 py-2">{{ $instructor->email }}</td>
            <td class="border px-4 py-2">{{ $instructor->status }}</td>
            <td class="border px-4 py-2">
                <form method="POST" action="{{ route('admin.instructors.approve', $instructor->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.instructors.reject', $instructor->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
