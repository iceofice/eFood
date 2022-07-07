@extends('crud.edit')

@section('form')
    <x-adminlte-input id="title" name="title" label="Title" value="{{ $discount->title }}" />
    <x-adminlte-input id="subtitle" name="subtitle" label="Subtitle" value="{{ $discount->subtitle }}" />
    <x-adminlte-input-date id="start_date" name="start_date" label="Start Date" value="{{ $discount->start_date }}" />
    <x-adminlte-input-date id="end_date" name="end_date" label="End Date" value="{{ $discount->end_date }}" />
    <x-adminlte-input id="amount" name="amount" label="Amount (in %)" value="{{ $discount->amount }}" />
@endsection
