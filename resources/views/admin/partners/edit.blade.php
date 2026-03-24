@extends('layouts.admin')
@section('title', 'Edit Partner')

@section('content')

<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Edit Partner</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.partners.index') }}">Partners</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $partner->name }}</span>
        </nav>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('partners') }}" target="_blank" class="btn-ad btn-ad-outline">
            <i class="fas fa-arrow-up-right-from-square"></i> View
        </a>
        <a href="{{ route('admin.partners.index') }}" class="btn-ad btn-ad-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>{{ session('error') }}</div>
</div>
@endif
@if($errors->any())
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="ad-alert-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.partners._form')

    <div style="display:flex;gap:10px;justify-content:flex-end;">
        <a href="{{ route('admin.partners.index') }}" class="btn-ad btn-ad-outline">Cancel</a>
        <button type="submit" class="btn-ad btn-ad-primary">
            <i class="fas fa-save"></i> Update Partner
        </button>
    </div>
</form>

@endsection
