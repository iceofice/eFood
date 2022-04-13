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
                        {{-- TODO: Refactor using blade component <x-adminlte-input /> --}}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                                value="{{ old('slug') }}">
                            @error('slug')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea row="50" class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description">{{ old('description') }}</textarea>
                        </div>
                        {{-- TODO: CSS --}}
                        <img id="image-preview" style="height: 100px; width: 150px; object-fit:contain; display:none;">
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
