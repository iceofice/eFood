@extends('crud.index')

@section('filter')
    <div class="col-xs-12 col-sm-6 col-md-3">
        <x-adminlte-select id="role" name="role" label="Role">
            <x-adminlte-options :options="$options" placeholder="--select a role--" />
        </x-adminlte-select>
    </div>
@endsection

@push('js')
    <script>
        $('#role').on('change', function() {
            $('#table2').DataTable().destroy();
            $.ajax({
                type: 'POST',
                url: '{{ route($route . '.filter') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    role: $(this).val(),
                },
                success: function(data) {
                    $('#table2').DataTable(data)
                },
                error: function(data) {
                    error_message(data.responseJSON.message);
                }
            });
        })
    </script>
@endpush
