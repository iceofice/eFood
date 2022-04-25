@extends('adminlte::page')

@section('title', 'Edit ' . $modelName)

@section('content_header')
    <h1 class="m-0 text-dark">Edit {{ $modelName }}</h1>
@stop

@section('content')
    <form action="{{ route($route . '.update', $id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @yield('form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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
