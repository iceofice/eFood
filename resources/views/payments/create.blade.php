@extends('crud.create')

@section('form')
    <h5>Customer - Table : {{ $order->customer_name . ' - ' . $order->table->name }}</h5>

    <a data-toggle='modal' data-target='#order-summary' class="btn btn-dark mb-4">
        <i class="fa fa-print mr-2"></i>Order Summary
    </a>
    <h5>Total : RM <span id="total">{{ $order->total }}</span></h5>
    <x-adminlte-input name="order_id" type="hidden" value="{{ $order->id }}" />

    <x-adminlte-select2 name="method" label="Method" enable-old-support>
        <x-adminlte-options :options="$methods" empty-option="--select a method--" />
    </x-adminlte-select2>

    <div id="bank-select">
        <x-adminlte-select2 name="bank" label="Bank" enable-old-support>
            <x-adminlte-options :options="$banks" empty-option="--select bank--" />
        </x-adminlte-select2>
    </div>

    @if ($discountsOption)
        <x-adminlte-select2 name="discount_id" label="Discount" enable-old-support>
            <x-adminlte-options :options="$discountsOption" placeholder="--select discount--" />
        </x-adminlte-select2>
    @else
        <span style="color:#007bff">No available discount.</span>
    @endif

    <x-adminlte-input id="donation" name="donation" label="Donation" value="{{ old('donation') }}" />

    <br />
    <a id="ewallet-button" data-toggle='modal' data-target='#ewallet-payment' class="btn btn-primary mb-4">
        Show QR
    </a>
@endsection

@section('additional')
    <x-adminlte-modal id="ewallet-payment" title="eWallet" icon="fas fa-camera">
        <div class="text-center">
            <img src="{{ asset('images/qr.png') }}" alt="">
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close" data-dismiss="modal" />
            <x-adminlte-button label="Confirm" theme="primary" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="order-summary" title="Order Summary" icon="fas fa-list">
        @foreach ($order->menus as $item)
            <div class="row">
                <div class="col-3">
                    <figure>
                        <img class="order-summary-image img-thumbnail"
                            src="{{ url('storage/images/' . $item->image) }}" />
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
                    <p id="discount"></p>
                    <p>Total:
                        <span class="text-primary">RM
                            <span id="total-modal">{{ number_format($order->total, 2, '.', ',') }}</span>
                        </span>
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
        var bankSelect = $('#bank-select')
        var ewalletButton = $('#ewallet-button')
        bankSelect.hide();
        ewalletButton.hide();
        $('#bank').prop('disabled', true);
        $('#method').on('select2:select', function(e) {
            method = e.params.data.id;
            bankSelect.hide();
            ewalletButton.hide();
            $('#bank').prop('disabled', true);
            if (method == 2) {
                bankSelect.show();
                $('#bank').prop('disabled', false);
            } else if (method == 3) {
                ewalletButton.show();
            }
        });
        $('#discount_id').on('select2:select', function(e) {
            if (e.params.data.id != "") {
                let discounts = {!! json_encode($discounts) !!};
                var total = (100 - parseFloat(discounts[e.params.data.id])) * {{ $order->total }} / 100;
                $('#total').text(total);
                $('#total-modal').text(total);
                $('#discount').text("Discount: " + discounts[e.params.data.id] + "%");
            } else {
                var total = {{ $order->total }};
                $('#total').text(total);
                $('#total-modal').text(total);
                $('#discount').text("Discount: " + discounts[e.params.data.id] + "%");
            }
        });
    </script>
@endsection
