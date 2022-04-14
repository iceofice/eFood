@extends('crud.edit')

@php
$modelName = 'User';
$route = 'users';
$id = $user->id;
$options = [
    'Admin' => 'Admin',
    'Cashier' => 'Cashier',
    'Kitchen Staff' => 'Kitchen Staff',
    'Waiter' => 'Waiter',
];
@endphp

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $user->name }}" />
    <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ $user->email }}" />
    <x-adminlte-select name="role" label="Type" enable-old-support>
        <x-adminlte-options :options="$options" selected="{{ $user->role }}" />
    </x-adminlte-select>
    <x-adminlte-input id="password" name="password" label="Password" type="password">
        <x-slot name="bottomSlot">
            <div class="form-text">
                Fill only if you want to change the password.
            </div>
        </x-slot>
    </x-adminlte-input>
    <x-adminlte-input id="password_confirmation" name="password_confirmation" label="Password Confirmation" type="password">
        <x-slot name="bottomSlot">
            <div class="form-text">
                Fill only if you want to change the password.
            </div>
        </x-slot>
    </x-adminlte-input>
@endsection
