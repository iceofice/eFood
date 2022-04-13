@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
    <h1 class="m-0 text-dark">Add User</h1>
@stop

@section('content')
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
                        <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ old('email') }}" />
                        <x-adminlte-input id="password" name="password" label="Password" type="password" />
                        <x-adminlte-input id="password_confirmation" name="password_confirmation"
                            label="Password Confirmation" type="password" />
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('users.index') }}" class="btn btn-default">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
