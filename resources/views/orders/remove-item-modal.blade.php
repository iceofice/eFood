<x-adminlte-modal id="remove-modal" title="Remove Item" icon="fas fa-trash">
    <div>Are you sure you want to remove this item?</div>
    <x-slot name="footerSlot">
        <form action="" id="remove-form" method="post">
            @csrf
            <x-adminlte-button label="Cancel" data-dismiss="modal" />
            <x-adminlte-button theme="danger" label="Remove" onclick="removeItem(event)" />
        </form>
    </x-slot>
</x-adminlte-modal>

@push('js')
    <script>
        function onRemoveButtonPressed(event, el) {
            menuId = $(el).data('id');
        }

        function removeItem(event) {
            event.preventDefault();
            var url = "{{ route('orders.removeMenu', ['order' => "$id", 'menu_id' => ':menuId']) }}";
            url = url.replace(':menuId', menuId);
            $('#remove-form').attr('action', url);
            $("#remove-form").submit();
        }
    </script>
@endpush
