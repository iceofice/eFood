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
                <x-adminlte-options :options="$tables" empty-option="--select a table--" />
            </x-adminlte-select2>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $config = [
                    'format' => 'L',
                    'minDate' => 'js:moment()',
                    'maxDate' => 'js:moment().add(30, "days")',
                ];
            @endphp
            <x-adminlte-input-date id="reserved_at" name="reserved_at" label="Reservation Date" :config="$config" />
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
        <div class="col-6">
            <x-adminlte-select2 name="user_id" label="Waiter" enable-old-support>
                <x-adminlte-options :options="$waiters" :empty-option="$isWaiter ? null : '--select a waiter--'" />
            </x-adminlte-select2>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let time;
        let table = {{ old('table_id') ?? 0 }};

        $("#reserved_at").on("change.datetimepicker", ({
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
                        if (data.length == 0) {
                            $('#time').append('<option value="">No time available</option>');
                        } else {
                            $.each(data, function(i, item) {
                                $('#time').append($('<option>', {
                                    value: i,
                                    text: item
                                }));
                            });
                        }
                    });
            }
        }
    </script>
@endsection
