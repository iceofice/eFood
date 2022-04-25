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
            <x-adminlte-select2 name="status" label="Status" enable-old-support>
                <x-adminlte-options :options="$status" />
            </x-adminlte-select2>
        </div>
    </div>
@endsection
