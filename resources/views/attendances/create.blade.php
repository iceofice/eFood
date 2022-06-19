@extends('crud.create')

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="user_id" label="Staff" enable-old-support>
                <x-adminlte-options :options="$users" empty-option="--select a staff--" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $config = ['format' => 'YYYY-MM-DD HH.mm'];
            @endphp
            <x-adminlte-input-date id="clock_in" name="clock_in" label="Clock In" :config="$config" />
        </div>
        <div class="col-6">
            <x-adminlte-input-date id="clock_out" name="clock_out" label="Clock Out" :config="$config" />
        </div>
    </div>
@endsection
