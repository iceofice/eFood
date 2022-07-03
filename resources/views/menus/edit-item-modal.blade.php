<x-adminlte-modal id="edit-modal" title="Edit Item" icon="fas fa-pen">
    <form id="edit-form" action="" method="post">
        @csrf
        @method('put')
        <x-adminlte-input id="edit-qty" name="qty" label="Quantity" value="" />
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button label="Cancel" data-dismiss="modal" />
        <x-adminlte-button id="add-item-button" theme="primary" label="Edit" onclick="editItem(event)" />
    </x-slot>
</x-adminlte-modal>

@push('js')
    <script>
        var inventories = {!! json_encode($menu->inventories) !!}

        function onEditButtonPressed(event, el) {
            inventoryId = $(el).data('id');
            let inventory = inventories.find(o => o.id === inventoryId);
            $('#edit-qty').val(inventory.pivot.qty);
        }

        function editItem(event) {
            event.preventDefault();
            var url = "{{ route('menus.updateInventory', ['menu' => "$id", 'inventory_id' => ':inventoryId']) }}";
            url = url.replace(':inventoryId', inventoryId);
            $('#edit-modal').modal('hide');
            $('#edit-form').attr('action', url);
            $('#edit-form').submit();
        }
    </script>
@endpush
