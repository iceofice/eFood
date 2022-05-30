@extends('crud.create')

@section('form')
    <x-adminlte-select2 name="type" label="Type" enable-old-support>
        <x-adminlte-options :options="['Category', 'Filter']" />
    </x-adminlte-select2>

    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
    <x-adminlte-input id="slug" name="slug" label="Slug" value="{{ old('slug') }}" />
    <x-adminlte-textarea id="description" name="description" label="Description">
        {{ old('description') }}
    </x-adminlte-textarea>

    <img id="image-preview" class="form-image-preview" style="display:none;">
    <x-adminlte-input-file id="image" name="image" label="Image" placeholder="Choose an image..." />
@endsection

@section('js')
    <script>
        $('#name').change(function(e) {
            $.get('{{ route('categories.checkSlug') }}', {
                    'name': $(this).val()
                },
                function(data) {
                    $('#slug').val(data.slug);
                });
        });
    </script>
    @include('partials.preview-image-script')
@endsection
