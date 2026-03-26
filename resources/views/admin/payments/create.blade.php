@extends('layouts.admin')
@section('title', 'Record Payment')

@section('content')
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Record Payment</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.payments.index') }}">Payments</a>
            <i class="fas fa-chevron-right"></i>
            <span>Record Payment</span>
        </nav>
    </div>
</div>

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
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

<form method="POST" action="{{ route('admin.payments.store') }}">
    @csrf

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Payment Details</h3>
        </div>
        <div class="ad-card-body" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;">
            <div>
                <label class="ad-label" for="student_id">Student</label>
                <select class="ad-input" id="student_id" name="student_id" required>
                    <option value="">Select student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="ad-label" for="course_id">Course</label>
                <select class="ad-input" id="course_id" name="course_id" required>
                    <option value="">Select course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="ad-label" for="amount">Amount</label>
                <input class="ad-input" id="amount" type="number" min="0" step="0.01" name="amount" value="{{ old('amount') }}" required>
            </div>

            <div>
                <label class="ad-label" for="currency">Currency</label>
                <input class="ad-input" id="currency" type="text" name="currency" value="{{ old('currency', 'UGX') }}" maxlength="3" required>
            </div>

            <div>
                <label class="ad-label" for="payment_method">Payment Method</label>
                <input class="ad-input" id="payment_method" type="text" name="payment_method" value="{{ old('payment_method', 'bank_transfer') }}" placeholder="e.g. bank_transfer, cash, mobile_money" required>
            </div>

            <div>
                <label class="ad-label" for="status">Status</label>
                <select class="ad-input" id="status" name="status" required>
                    @foreach(['completed', 'pending', 'failed', 'cancelled', 'reversed'] as $status)
                        <option value="{{ $status }}" @selected(old('status', 'completed') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="ad-label" for="reference">Reference</label>
                <input class="ad-input" id="reference" type="text" name="reference" value="{{ old('reference') }}" placeholder="Optional manual reference">
            </div>

            <div>
                <label class="ad-label" for="paid_at">Paid At</label>
                <input class="ad-input" id="paid_at" type="datetime-local" name="paid_at" value="{{ old('paid_at') }}">
            </div>

            <div style="grid-column:1 / -1;">
                <label class="ad-label" for="description">Description</label>
                <textarea class="ad-input" id="description" name="description" rows="4" placeholder="Optional finance note or payment description">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    <div style="margin-top:18px;display:flex;gap:10px;">
        <button type="submit" class="btn-ad btn-ad-primary">
            <i class="fas fa-save"></i> Save Payment
        </button>
        <a href="{{ route('admin.payments.index') }}" class="btn-ad btn-ad-outline">Cancel</a>
    </div>
</form>
@endsection
