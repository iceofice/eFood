@extends('adminlte::page')

@section('title', 'Add ' . $modelName)

@section('content_header')
    <h1 class="m-0 text-dark">Add {{ $modelName }}</h1>
@stop

@section('content')
    <form action="{{ route($route . '.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @yield('form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route($route . '.index') }}" class="btn btn-default">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @yield('additional')
@stop
