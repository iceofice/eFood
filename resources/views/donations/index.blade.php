@extends('adminlte::page')

@section('title', 'Donation')

@section('content_header')
    <h1 class="m-0 text-dark">Donation</h1>
@stop

@section('content')
    {{ $donationAmount }}
@endsection
