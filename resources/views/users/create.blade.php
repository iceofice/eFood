@extends('crud.create')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ old('email') }}" />
    <x-adminlte-select2 name="role" label="Type" enable-old-support>
        <x-adminlte-options :options="$options" />
    </x-adminlte-select2>
    <x-adminlte-input id="password" name="password" label="Password" type="password" />
    <x-adminlte-input id="password_confirmation" name="password_confirmation" label="Password Confirmation"
        type="password" />
@endsection
