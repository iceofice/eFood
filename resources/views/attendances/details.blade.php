@extends('adminlte::page')

@section('title', 'Attendance Code')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $user->name }} Attendance Record</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="height: 400px">
                        <canvas id="myChart" height="70"></canvas>
                    </div>
                    <div style="height: 400px">
                        <canvas id="myChart2" height="70"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugins.Chartjs', true)

@section('js')
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($weekLabel),
                datasets: [{
                    label: 'This Week Working Hours',
                    data: @json($weekData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const ctx1 = document.getElementById('myChart2').getContext('2d');
        const myChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: @json($monthLabel),
                datasets: [{
                    label: 'This Month Working Hours',
                    data: @json($monthData),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scaleLabel: {
                    display: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>
@endsection
