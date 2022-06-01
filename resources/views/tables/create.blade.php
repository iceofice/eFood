@extends('crud.create')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    @php
    $config = [
        'range' => true,
        'ticks' => [0, 15],
    ];
    @endphp
    <x-adminlte-input-slider name="range" label="Number Of People" color="orange" :config="$config" value="3,8">
    </x-adminlte-input-slider>
@endsection
