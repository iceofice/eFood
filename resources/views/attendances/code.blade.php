@extends('adminlte::page')

@section('title', 'Attendance Code')

@section('content_header')
    <h1 class="m-0 text-dark">Attendance Code</h1>
@stop

@section('content')
    <div class="row text-center text-monospace" style="font-size: 40px;">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    {{ $code[0] }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    {{ $code[1] }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    {{ $code[2] }}
                </div>
            </div>
        </div>
    </div>
@endsection
