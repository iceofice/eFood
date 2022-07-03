<x-adminlte-modal id="add-modal" title="Add Items" icon="fas fa-edit">
    <form id="add-form" action="{{ route('menus.addInventory', $id) }}" method="post">
        @csrf
        <x-adminlte-select2 id="inventory_id" name="inventory_id" label="Menu Item" enable-old-support>
            <x-adminlte-options :options="$inventories" />
        </x-adminlte-select2>

        <x-adminlte-input id="qty" name="qty" label="Quantity" value="{{ old('qty') }}" />
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button label="Cancel" data-dismiss="modal" />
        <x-adminlte-button id="add-item-button" theme="primary" label="Add" />
    </x-slot>
</x-adminlte-modal>

@push('js')
    <script>
        $('#add-item-button').click(function(event) {
            event.preventDefault();
            $('#add-modal').modal('hide');
            $('#add-form').submit();
        });
    </script>
@endpush
