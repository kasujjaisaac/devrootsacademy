@extends('layouts.admin')
@section('title','Instructor Earnings')

@section('content')
<h1 class="page-title">Instructor Earnings</h1>

<div class="card">
<table>
    <thead>
        <tr>
            <th>Instructor</th>
            <th>Courses</th>
            <th>Enrollments</th>
            <th>Total Earnings</th>
        </tr>
    </thead>
    <tbody>
    @foreach($instructors as $i)
        <tr>
            <td>{{ $i->name }}</td>
            <td>{{ $i->courses_count }}</td>
            <td>{{ $i->enrollments_count }}</td>
            <td><strong>${{ number_format($i->earnings) }}</strong></td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
