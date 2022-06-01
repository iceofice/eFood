@extends('crud.edit')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ $table->name }}" />
    @php
    $config = [
        'range' => true,
        'ticks' => [0, 15],
    ];
    @endphp
    <x-adminlte-input-slider name="range" label="Number Of People" color="orange" :config="$config"
        value="{{ $table->min }},{{ $table->max }}">
    </x-adminlte-input-slider>
@endsection
