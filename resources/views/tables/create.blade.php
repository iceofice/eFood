@extends('crud.create')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="qty" name="qty" label="Number Of Person" value="{{ old('qty') }}" />
@endsection
