@extends('crud.create')

@section('form')
    <div class="row">
        <div class="col-6">
            {{-- TODO: Make all x-adminlte-select into select2 --}}
            <x-adminlte-select2 name="customer_id" label="Customer" enable-old-support>
                <x-adminlte-options :options="$customers" />
            </x-adminlte-select2>
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="table_id" label="Table" enable-old-support>
                <x-adminlte-options :options="$tables" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $config = ['format' => 'YYYY-MM-DD HH.mm'];
            @endphp
            <x-adminlte-input-date name="reserved_at" label="Reservation Time" enable-old-support :config="$config" />
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="status" label="Status" enable-old-support>
                <x-adminlte-options :options="$status" />
            </x-adminlte-select2>
        </div>
    </div>
@endsection
