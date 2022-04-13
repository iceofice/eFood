@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1 class="m-0 text-dark">Edit User</h1>
@stop
@section('content')
    <form action="{{ route('users.update', $user->id) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-adminlte-input id="name" name="name" label="Name" value="{{ $user->name }}" />
                        <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ $user->email }}" />
                        <x-adminlte-input id="password" name="password" label="Password" type="password">
                            <x-slot name="bottomSlot">
                                <div class="form-text">
                                    Fill only if you want to change the password.
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input id="password_confirmation" name="password_confirmation"
                            label="Password Confirmation" type="password">
                            <x-slot name="bottomSlot">
                                <div class="form-text">
                                    Fill only if you want to change the password.
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-default">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
