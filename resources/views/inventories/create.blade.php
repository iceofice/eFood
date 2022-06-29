@extends('crud.create')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="unit" name="unit" label="Unit" value="{{ old('unit') }}" />
    <x-adminlte-input id="qty" name="qty" label="Quantity" value="{{ old('qty') }}" />
@endsection
