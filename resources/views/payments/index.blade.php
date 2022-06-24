@extends('crud.index')

@section('filter')
    <a href="{{ route('orders.index') }}" class="btn btn-primary mb-4">
        Go To Order
    </a>
@endsection
