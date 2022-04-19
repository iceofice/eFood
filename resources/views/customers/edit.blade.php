@extends('crud.edit')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $customer->name }}" />
    <x-adminlte-input id="email" name="email" label="Email" type="email" value="{{ $customer->email }}" />
    <x-adminlte-input id="phone" name="phone" label="Phone" value="{{ $customer->phone }}" />

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
