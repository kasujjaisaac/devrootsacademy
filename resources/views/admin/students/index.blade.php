@extends('layouts.admin')
@section('title','Students')

@section('content')
<h1 class="text-3xl font-bold mb-6">Students</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <input
        type="text"
        placeholder="Search student..."
        class="border p-2 rounded w-full mb-4"
        onkeyup="filterTable(this.value)"
    >

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3 border-b">Name</th>
                <th class="p-3 border-b">Email</th>
                <th class="p-3 border-b">Phone</th>
                <th class="p-3 border-b">Course Interest</th>
                <th class="p-3 border-b">Status</th>
                <th class="p-3 border-b">Joined</th>
            </tr>
        </thead>
        <tbody id="studentsTable">
            @foreach($students as $student)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $student->full_name }}</td>
                <td class="p-3">{{ $student->email ?? '-' }}</td>
                <td class="p-3">{{ $student->phone }}</td>
                <td class="p-3">{{ $student->course_interest }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-sm
                        {{ $student->status == 'active' ? 'bg-green-100 text-green-700' : ($student->status=='pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($student->status) }}
                    </span>
                </td>
                <td class="p-3">{{ $student->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
function filterTable(value) {
    value = value.toLowerCase();
    document.querySelectorAll('#studentsTable tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
}
</script>
@endsection
