@extends('crud.create')

@section('form')
    <x-adminlte-input id="name" name="name" label="Name" value="{{ old('name') }}" />
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
@endsection
