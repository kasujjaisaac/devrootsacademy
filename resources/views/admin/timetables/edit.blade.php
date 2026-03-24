@extends('layouts.admin')
@section('title', 'Edit Timetable')

@section('content')
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Edit Timetable</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.timetables.index') }}">Timetables</a>
            <i class="fas fa-chevron-right"></i>
            <span>Edit</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('admin.timetables.update', $timetable) }}">
    @method('PUT')
    @include('admin.timetables._form', ['submitLabel' => 'Update Timetable'])
</form>
@endsection
