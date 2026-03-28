@extends('layouts.admin')
@section('title', 'Add Staff User')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Add Staff User</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.staff-users.index') }}">Staff Access</a>
      <i class="fas fa-chevron-right"></i>
      <span>Add Staff User</span>
    </div>
  </div>
</div>

@include('admin.staff-users._form', [
  'formAction' => route('admin.staff-users.store'),
  'formMethod' => 'POST',
])
@endsection
