@extends('crud.edit')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $inventory->name }}" />
    <x-adminlte-input id="unit" name="unit" label="Unit" value="{{ $inventory->unit }}" />
    <x-adminlte-input id="qty" name="qty" label="Quantity" value="{{ $inventory->qty }}" />
@endsection
