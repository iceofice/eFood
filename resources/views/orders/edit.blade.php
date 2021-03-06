@extends('crud.edit')

@php
$updateDetails = auth()
    ->user()
    ->can('manage orders details');
@endphp

@section('form')
    <div class="row">
        <div class="col-6">
            <x-adminlte-select2 name="customer_id" label="Customer" enable-old-support :disabled="!$updateDetails">
                <x-adminlte-options :options="$customers" selected="{{ $order->customer_id }}" />
            </x-adminlte-select2>
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="table_id" label="Table" enable-old-support :disabled="!$updateDetails">
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
                value="{{ $order->date }}" :disabled="!$updateDetails" />
        </div>
        <div class="col-6">
            <x-adminlte-select2 name="time" label="Time" enable-old-support :disabled="!$updateDetails">
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
            <x-adminlte-select2 name="user_id" label="Waiter" enable-old-support :disabled="!$updateDetails">
                <x-adminlte-options :options="$waiters" :empty-option="$isWaiter ? null : '--select a waiter--'" selected="{{ $order->user_id }}" />
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
                    @can('manage orders details')
                        <a data-toggle='modal' data-target='#add-modal' class="btn btn-primary mb-4">
                            <i class="fa fa-plus mr-2"></i>Add New Items
                        </a>
                    @endcan
                    <a data-toggle='modal' data-target='#order-summary' class="btn btn-dark mb-4">
                        <i class="fa fa-print mr-2"></i>Order Summary
                    </a>
                    @can('manage payments')
                        <a class="btn btn-dark mb-4" href="{{ route('payments.create', ['orderID' => $order->id]) }}">
                            <i class="fa fa-money-bill mr-2"></i>Go to Payment
                        </a>
                    @endcan
                    <x-adminlte-datatable id="table2" :heads="$table->heads" head-theme="dark" :config="$table->config" striped
                        hoverable bordered />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional')
    @can('manage orders details')
        @include('orders.add-item-modal')
        @include('orders.remove-item-modal')
        @include('orders.edit-item-modal')
    @endcan
    <x-adminlte-modal id="order-summary" title="Order Summary" icon="fas fa-list">
        @foreach ($order->menus as $item)
            <div class="row">
                <div class="col-3">
                    <figure>
                        <img class="order-summary-image img-thumbnail" src="{{ url('storage/images/' . $item->image) }}" />
                    </figure>
                </div>
                <div class="col-9">
                    <span>{{ $item->pivot->qty }}x </span>
                    {{ $item->name }}
                    <div class="float-right">
                        RM{{ number_format($item->pivot->price * $item->pivot->qty, 2, '.', ',') }}
                    </div>
                    <br />
                    @RM{{ $item->pivot->price }}
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-12">
                <div class="float-right">
                    <p>Total:
                        <span class="text-primary">RM{{ number_format($order->total, 2, '.', ',') }}</span>
                    </p>
                </div>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let time = $("#date")[0].value;
            let table = {{ $order->table_id }};
            let id = {{ $order->id }};

            checkTime(true);

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

            function checkTime(first = false) {
                console.log(first)
                if (time && table) {
                    $.get('{{ route('orders.checkTime') }}', {
                            'time': time,
                            'table': table,
                            'id': id
                        },
                        function(data) {
                            $('#time').find('option').remove();
                            if (data.length == 0) {
                                $('#time').append('<option value="">No time available</option>');
                            } else {
                                $.each(data, function(i, item) {
                                    $('#time').append($('<option>', {
                                        value: i,
                                        text: item,
                                        selected: first && i == '{{ $order->time }}'
                                    }));
                                });
                            }
                        });
                }
            }
        });
    </script>
@endsection
