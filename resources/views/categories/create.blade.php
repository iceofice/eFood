@extends('adminlte::page')

@section('title', 'Add Category')

@section('content_header')
    <h1 class="m-0 text-dark">Add Category</h1>
@stop

@section('content')
    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-adminlte-select name="type" label="Type" enable-old-support>
                            <x-adminlte-options :options="['Category', 'Filter']" />
                        </x-adminlte-select>

                        <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
                        <x-adminlte-input id="slug" name="slug" label="Slug" value="{{ old('slug') }}" />
                        <x-adminlte-textarea id="description" name="description" label="Description">
                            {{ old('description') }}
                        </x-adminlte-textarea>

                        <img id="image-preview" class="form-image-preview" style="display:none;">
                        <x-adminlte-input-file id="image" name="image" label="Image" placeholder="Choose an image..." />
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-default">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $('#name').change(function(e) {
            $.get('{{ route('categories.checkSlug') }}', {
                    'name': $(this).val()
                },
                function(data) {
                    $('#slug').val(data.slug);
                });
        });
        $('#image').change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview').show();
            };
            reader.readAsDataURL(file);
        });
    </script>
@stop
