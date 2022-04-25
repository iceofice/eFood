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
        var menus = {!! json_encode($order->menus) !!}

        function onEditButtonPressed(event, el) {
            menuId = $(el).data('id');
            let menu = menus.find(o => o.id === menuId);
            $('#edit-qty').val(menu.pivot.qty);
        }

        function editItem(event) {
            event.preventDefault();
            var url = "{{ route('orders.updateMenu', ['order' => "$id", 'menu_id' => ':menuId']) }}";
            url = url.replace(':menuId', menuId);
            $('#edit-modal').modal('hide');
            $('#edit-form').attr('action', url);
            $('#edit-form').submit();
        }
    </script>
@endpush
