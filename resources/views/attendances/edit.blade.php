@extends('crud.edit')

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="user_id" label="Staff">
                <x-adminlte-options :options="$users" empty-option="--select a staff--"
                    selected="{{ $attendance->user_id }}" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $config = ['format' => 'YYYY-MM-DD HH.mm'];
            @endphp
            <x-adminlte-input-date id="clock_in" name="clock_in" label="Clock In" :config="$config"
                value="{{ $attendance->clock_in }}" />
        </div>
        <div class="col-6">
            <x-adminlte-input-date id="clock_out" name="clock_out" label="Clock Out" :config="$config"
                value="{{ $attendance->clock_out }}" />
        </div>
    </div>
@endsection
