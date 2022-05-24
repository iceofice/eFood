@extends('crud.edit')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $table->name }}" />
    <x-adminlte-input id="qty" name="qty" label="Number Of Person" value="{{ $table->qty }}" />
@endsection
