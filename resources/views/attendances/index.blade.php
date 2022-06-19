@extends('crud.index')

@section('filter')
    <a href="{{ route('attendances.code') }}" class="btn btn-dark mb-4">Attendance Code</a>
@endsection
