@extends('adminlte::page')

@section('title', 'eFood - Restaurant Management System')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Welcome back, {{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
