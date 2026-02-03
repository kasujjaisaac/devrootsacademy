@extends('layouts.admin')
@section('title','Payments')

@section('content')
<h1 class="page-title">Revenue & Payments</h1>

<div class="kpi-card green">
    <span>Total Revenue</span>
    <h2>${{ number_format($totalRevenue) }}</h2>
</div>

<div class="card">
    <h3>Monthly Revenue</h3>
    <canvas id="revenueChart"></canvas>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('revenueChart'),{
    type:'line',
    data:{
        labels:{!! json_encode($months) !!},
        datasets:[{
            label:'Revenue',
            data:{!! json_encode($amounts) !!},
            borderColor:'#22c55e',
            fill:false
        }]
    }
});
</script>
@endpush
