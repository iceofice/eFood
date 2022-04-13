@extends('crud.create')

@php
$modelName = 'User';
$route = 'users';
@endphp

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ old('email') }}" />
    <x-adminlte-input id="password" name="password" label="Password" type="password" />
    <x-adminlte-input id="password_confirmation" name="password_confirmation" label="Password Confirmation"
        type="password" />
@endsection
