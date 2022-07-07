@extends('crud.create')

@section('form')
    <x-adminlte-input id="title" name="title" label="Title" value="{{ old('title') }}" />
    <x-adminlte-input id="subtitle" name="subtitle" label="Subtitle" value="{{ old('subtitle') }}" />
    <x-adminlte-input-date id="start_date" name="start_date" label="Start Date" value="{{ old('start_date') }}" />
    <x-adminlte-input-date id="end_date" name="end_date" label="End Date" value="{{ old('end_date') }}" />
    <x-adminlte-input id="amount" name="amount" label="Amount (in %)" value="{{ old('amount') }}" />
@endsection
