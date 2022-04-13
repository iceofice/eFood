@extends('adminlte::page')

@section('title', $modelName . ' List')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $modelName }} List</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route($route . '.create') }}" class="btn btn-primary mb-4">
                        Add New {{ $modelName }}
                    </a>
                    <x-adminlte-datatable id="table2" :heads="$table->heads" head-theme="dark" :config="$table->config" striped
                        hoverable bordered />
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <x-adminlte-modal id="delete-modal" title="{{ $modelName }} Deletion" icon="fas fa-trash">
        <div>Are you sure you want to delete this {{ $modelName }}?</div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
            <form action="" id="delete-form" method="post">
                @method('delete')
                @csrf
                <x-adminlte-button theme="success" label="Accept" onclick="deleteModel(event)" />
            </form>
        </x-slot>
    </x-adminlte-modal>

    <script>
        button = null;

        function setButton(event, el) {
            button = $(el);
        }

        function deleteModel(event) {
            event.preventDefault();
            $("#delete-form").attr('action', button.attr('href'));
            $("#delete-form").submit();
        }
    </script>
@endpush
