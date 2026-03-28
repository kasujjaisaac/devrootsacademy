@extends('layouts.admin')
@section('title', 'Edit Lecture Recording')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Edit Lecture Recording</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.lecture-recordings.index') }}">Lecture Recordings</a>
      <i class="fas fa-chevron-right"></i>
      <span>{{ $recording->title }}</span>
    </div>
  </div>
</div>

<form method="POST" action="{{ route('admin.lecture-recordings.update', $recording) }}">
  @csrf
  @method('PUT')
  @include('admin.lecture-recordings._form')
</form>
@endsection
