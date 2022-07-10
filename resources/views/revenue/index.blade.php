@extends('adminlte::page')

@section('title', 'Revenue')

@section('content_header')
    <h1 class="m-0 text-dark">Revenue</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="height: 400px">
                        <canvas id="weekChart" height="70"></canvas>
                    </div>
                    <div style="height: 400px">
                        <canvas id="monthChart" height="70"></canvas>
                    </div>
                    <div style="height: 400px">
                        <canvas id="yearChart" height="70"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const weekChartDoc = document.getElementById('weekChart').getContext('2d');
        const weekChart = new Chart(weekChartDoc, {
            type: 'line',
            data: {
                labels: @json($weekLabel),
                datasets: [{
                    label: 'This Week Revenue',
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
        const monthChartDoc = document.getElementById('monthChart').getContext('2d');
        const monthChart = new Chart(monthChartDoc, {
            type: 'line',
            data: {
                labels: @json($monthLabel),
                datasets: [{
                    label: 'This Month Revenue',
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
        const yearChartDoc = document.getElementById('yearChart').getContext('2d');
        const yearChart = new Chart(yearChartDoc, {
            type: 'line',
            data: {
                labels: @json($yearLabel),
                datasets: [{
                    label: 'This Year Revenue',
                    data: @json($yearData),
                    backgroundColor: [
                        'rgba(5, 152, 98, 0.2)',
                    ],
                    borderColor: [
                        'rgba(0, 62, 33, 1)',
                    ],
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
