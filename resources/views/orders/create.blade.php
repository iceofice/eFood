@extends('crud.create')

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="customer_id" label="Customer" enable-old-support>
                <x-adminlte-options :options="$customers" />
            </x-adminlte-select2>
        </div>
        <div class="col-6">
            <x-adminlte-select2 id="table_id" name="table_id" label="Table" enable-old-support>
                <x-adminlte-options :options="$tables" empty-option="Select a table" />
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
            <x-adminlte-input-date id="date" name="date" label="Reservation Date" enable-old-support :config="$config" />
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="time" label="Time" enable-old-support>
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="status" label="Status" enable-old-support>
                <x-adminlte-options :options="$status" />
            </x-adminlte-select2>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let time;
        let table;

        $("#date").on("change.datetimepicker", ({
            date,
            oldDate
        }) => {
            time = date.format("YYYY-MM-DD");
            checkTime();
        });

        $('#table_id').on('select2:select', function(e) {
            table = e.params.data.id;
            checkTime();
        });

        function checkTime() {
            if (time && table) {
                $.get('{{ route('orders.checkTime') }}', {
                        'time': time,
                        'table': table
                    },
                    function(data) {
                        $('#time').find('option').remove();
                        $.each(data, function(i, item) {
                            $('#time').append($('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                    });
            }
        }
    </script>
@endsection
