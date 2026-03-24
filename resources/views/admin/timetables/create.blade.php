@extends('layouts.admin')
@section('title', 'Create Timetable')

@section('content')
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Create Timetable</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.timetables.index') }}">Timetables</a>
            <i class="fas fa-chevron-right"></i>
            <span>Create</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('admin.timetables.store') }}">
    @include('admin.timetables._form', ['submitLabel' => 'Create Timetable'])
</form>
@endsection
