@extends('crud.edit')

@section('form')
    <h5>Customer - Table : {{ $order->customer_name . ' - ' . $order->table->name }}</h5>
    <h5>Total : RM {{ $order->total }}</h5>

    <x-adminlte-select2 name="method" label="Method" enable-old-support>
        <x-adminlte-options :options="$methods" selected="{{ $payment->method }}" />
    </x-adminlte-select2>

    <div id="bank-select">
        <x-adminlte-select2 name="bank" label="Bank" enable-old-support>
            <x-adminlte-options :options="$banks" selected="{{ $payment->bank }}" />
        </x-adminlte-select2>
    </div>

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
@endsection

@section('js')
    <script>
        var bankSelect = $('#bank-select')
        var ewalletButton = $('#ewallet-button')
        @if ($payment->method != 2)
            bankSelect.hide();
            $('#bank').prop('disabled', true);
        @endif
        ewalletButton.hide();
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
    </script>
@endsection
