@extends('crud.edit')

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="customer_id" label="Customer" enable-old-support>
                <x-adminlte-options :options="$customers" selected="{{ $order->customer_id }}" />
            </x-adminlte-select2>
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="table_id" label="Table" enable-old-support>
                <x-adminlte-options :options="$tables" selected="{{ $order->table_id }}" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $config = [
                    'format' => 'L',
                ];
            @endphp
            <x-adminlte-input-date name="date" label="Reservation date" enable-old-support :config="$config"
                value="{{ $order->date }}" />
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="time" label="Time" enable-old-support>
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="status" label="Status" enable-old-support>
                <x-adminlte-options :options="$status" selected="{{ $order->status }}" />
            </x-adminlte-select2>
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="user_id" label="Waiter" enable-old-support>
                <x-adminlte-options :options="$waiters" empty-option="--select a waiter--"
                    selected="{{ $order->user_id }}" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Items</h3>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <a data-toggle='modal' data-target='#add-modal' class="btn btn-primary mb-4">
                        Add New Items
                    </a>
                    <x-adminlte-datatable id="table2" :heads="$table->heads" head-theme="dark" :config="$table->config" striped
                        hoverable bordered />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional')
    @include('orders.add-item-modal')
    @include('orders.remove-item-modal')
    @include('orders.edit-item-modal')
@endsection

@section('js')
    <script>
        let time = {{ $order->date }};
        let table = {{ $order->table_id }};
        let id = {{ $order->id }};
        var first = true;

        $("#date").on("change.datetimepicker", ({
            date,
            oldDate
        }) => {
            time = date.format("YYYY-MM-DD");
            checkTime(first);
            first = false;
        });

        $('#table_id').on('select2:select', function(e) {
            table = e.params.data.id;
            checkTime();
        });

        function checkTime(first = false) {
            if (time && table) {
                $.get('{{ route('orders.checkTime') }}', {
                        'time': time,
                        'table': table,
                        'id': id
                    },
                    function(data) {
                        $('#time').find('option').remove();
                        $.each(data, function(i, item) {
                            $('#time').append($('<option>', {
                                value: i,
                                text: item,
                                selected: first && i == '{{ $order->time }}'
                            }));
                        });
                    });
            }
        }
    </script>
@endsection
