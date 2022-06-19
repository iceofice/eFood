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
                    <a data-toggle="modal" data-target="#clockout-modal" class="btn btn-primary">Clock Out</a>
                </div>
            </div>
        </div>
    </div>

    <x-adminlte-modal id="clockin-modal" title="Clock In" icon="fas fa-clock">
        <div class="row">
            <div class="col-12">
                <form id="clockin-form" action="{{ route('attendances.staff.clockin') }}" method="POST">
                    @csrf
                    <x-adminlte-input id="code" name="code" label="Clock In Code" :class="$errors->clockin->first() != '' ? 'is-invalid' : null">
                        <x-slot name="bottomSlot">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->clockin->first() }}</strong>
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </form>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close" data-dismiss="modal" />
            <x-adminlte-button id="clockin-submit" theme="primary" label="Submit" />
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal id="clockout-modal" title="Clock Out" icon="fas fa-clock">
        <div class="row">
            <div class="col-12">
                <form id="clockout-form" action="{{ route('attendances.staff.clockout') }}" method="POST">
                    @csrf
                    <x-adminlte-input id="code" name="code" label="Clock Out Code" :class="$errors->clockout->first() != '' ? 'is-invalid' : null">
                        <x-slot name="bottomSlot">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->clockout->first() }}</strong>
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </form>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Close" data-dismiss="modal" />
            <x-adminlte-button id="clockout-submit" theme="primary" label="Submit" />
        </x-slot>
    </x-adminlte-modal>
@endsection

@push('js')
    <script>
        @if ($errors->clockin->first() != '')
            $('#clockin-modal').modal('show');
        @endif

        $("#clockin-submit").click(function() {
            $("#clockin-form").submit();
        });

        @if ($errors->clockout->first() != '')
            $('#clockout-modal').modal('show');
        @endif

        $("#clockout-submit").click(function() {
            $("#clockout-form").submit();
        });
    </script>
@endpush
