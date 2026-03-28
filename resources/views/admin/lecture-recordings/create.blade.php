@extends('layouts.admin')
@section('title', 'Add Lecture Recording')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Add Lecture Recording</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.lecture-recordings.index') }}">Lecture Recordings</a>
      <i class="fas fa-chevron-right"></i>
      <span>Add Recording</span>
    </div>
  </div>
</div>

<form method="POST" action="{{ route('admin.lecture-recordings.store') }}">
  @csrf
  @include('admin.lecture-recordings._form')
</form>
@endsection
