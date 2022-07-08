@extends('adminlte::page')

@section('title', 'Donation')

@section('content_header')
    <h1 class="m-0 text-dark">Donation</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Donation Amount: <strong>RM{{ $donationAmount }}</strong></h5>
                    <form action="{{ route('donations.out') }}" method="POST">
                        @csrf
                        <x-adminlte-input id="amount" name="amount" label="Take Out Amount"
                            value="{{ old('amount') }}" />
                        <x-adminlte-button type="submit" theme="primary" label="Take Out" />

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
