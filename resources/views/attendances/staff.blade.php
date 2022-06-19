@extends('adminlte::page')

@section('title', 'Employee Attendance')

@section('content_header')
    <h1 class="m-0 text-dark">Employee Attendance</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a data-toggle="modal" data-target="#clockin-modal" class="btn btn-primary">Clock In</a>
                    <a class="btn btn-primary">Clock Out</a>
                </div>
            </div>
        </div>
    </div>

    <x-adminlte-modal id="clockin-modal" title="Clock In" icon="fas fa-clock">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('attendances.staff.clockin') }}">
                    <x-adminlte-input id="code" name="code" label="Clock In Code" value="{{ old('code') }}" />
                </form>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close" data-dismiss="modal" />
            <x-adminlte-button id="add-item-button" theme="primary" label="Submit" />
        </x-slot>
    </x-adminlte-modal>
@endsection
