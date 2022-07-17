@extends('layouts.app')

@section('content')
    <div id="fh5co-menus" data-section="menu">
        <div class="container">
            <div class="row text-center fh5co-heading row-padded">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="heading to-animate">Food Menu</h2>
                    <p class="sub-heading to-animate">
                        Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                        there live the
                        blind texts.
                    </p>
                </div>
            </div>
            <div class="row row-padded">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        @forelse ($categories as $slug => $category)
                            <li role="presentation" @once class="active" @endonce>
                                <a href="#{{ $slug }}" aria-controls="{{ $slug }}" role="tab"
                                    data-toggle="tab">{{ $category }}</a>
                            </li>
                        @empty
                            <h3>No menu available.</h3>
                        @endforelse
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        @foreach ($categories as $slug => $category)
                            <div role="tabpanel" class="tab-pane fade in @once active @endonce" id="{{ $slug }}">
                                <div class="col-md-6">
                                    <div class="fh5co-food-menu to-animate-2">
                                        <ul>
                                            @if (isset($menus[$slug][0]))
                                                @foreach ($menus[$slug][0] as $menu)
                                                    <li id="menu-{{ $menu->id }}"
                                                        @if (!$menu->is_active || $menu->out_of_stock) class="menu-disabled" @endif>
                                                        <div class="fh5co-food-desc">
                                                            <figure>
                                                                <img src="{{ url('storage/images/' . $menu->image) }}"
                                                                    class="img-responsive"
                                                                    alt="{{ $menu->name }} image" />
                                                            </figure>
                                                            <div>
                                                                <h3>
                                                                    <span id="menu-{{ $menu->id }}-qty"></span>
                                                                    {{ $menu->name }}
                                                                </h3>
                                                                <p>{{ $menu->description }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="fh5co-food-pricing">
                                                            RM {{ $menu->price }}
                                                        </div>
                                                        <div class="fh5co-food-pricing">
                                                            @if (!$menu->is_active || $menu->out_of_stock)
                                                                <span>is not available</span>
                                                            @else
                                                                <button class="btn btn-sm btn-primary add-button"
                                                                    data-toggle="modal" data-target="#addItemModal"
                                                                    data-model="{{ $menu }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                No menu under this category
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fh5co-food-menu to-animate-2">
                                        <ul>
                                            @if (isset($menus[$slug][1]))
                                                @foreach ($menus[$slug][1] as $menu)
                                                    <li id="menu-{{ $menu->id }}"
                                                        @if (!$menu->is_active || $menu->out_of_stock) class="menu-disabled" @endif>
                                                        <div class="fh5co-food-desc">
                                                            <figure>
                                                                <img src="{{ url('storage/images/' . $menu->image) }}"
                                                                    class="img-responsive"
                                                                    alt="{{ $menu->name }} image" />
                                                            </figure>
                                                            <div>
                                                                <h3>
                                                                    <span id="menu-{{ $menu->id }}-qty"></span>
                                                                    {{ $menu->name }}
                                                                </h3>
                                                                <p>{{ $menu->description }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="fh5co-food-pricing">
                                                            RM {{ $menu->price }}
                                                        </div>
                                                        <div class="fh5co-food-pricing">
                                                            @if (!$menu->is_active || $menu->out_of_stock)
                                                                <span>is not available</span>
                                                            @else
                                                                <button class="btn btn-sm btn-primary add-button"
                                                                    data-toggle="modal" data-target="#addItemModal"
                                                                    data-model="{{ $menu }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row text-right">
                <button data-toggle="modal" data-target="#summaryModal" class="btn btn-primary">Finish</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Add Item Modal -->
    <x-adminlte-modal id="addItemModal" title="Add Items" icon="fas fa-edit">
        <div class="fh5co-food-desc mb-4">
            <figure>
                <img id="menu-image" class="img-responsive" />
            </figure>
            <div>
                <h3 id="menu-name"></h3>
                <p id="menu-description"></p>
            </div>
        </div>
        <div class="fh5co-food-pricing" id="menu-price">
        </div>
        <label for="qty" class="sr-only">Quantity</label>
        <br />
        <p style="clear:both;" id="modal-error" class="error"></p>
        <input id="menu-qty" class="form-control" placeholder="Quantity" name="qty" type="number" required />
        <x-adminlte-textarea id="menu-note" name="note" placeholder="Special Request...." />
        <x-slot name="footerSlot">
            <x-adminlte-button id="remove-item-button" label="Remove" theme="danger" />
            <x-adminlte-button id="add-item-button" theme="primary" label="Add" />
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal id="summaryModal" title="Your order" icon="fas fa-list">
        @foreach ($items as $item)
            <div style="float: left;">
                <div class="fh5co-food-desc mb-4">
                    <figure>
                        <img class="img-responsive" src="{{ url('storage/images/' . $item->image) }}" />
                    </figure>
                    <div>
                        <h3>
                            <span>{{ $item->pivot->qty }}x </span>
                            {{ $item->name }}
                        </h3>
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
                <div class="fh5co-food-pricing">
                    RM{{ number_format($item->price * $item->pivot->qty, 2, '.', ',') }}
                </div>
            </div>
        @endforeach
        <div class="fh5co-food-pricing">
            <span>Total:</span>
            RM{{ $order->total }}
        </div>
        <div class="clearfix"></div>

        <x-slot name="footerSlot">
            <form action="{{ route('front.order.finish') }}" method="POST">
                @csrf
                <input type="hidden" name="orderID" value="{{ $order->id }}" />
                <x-adminlte-button type="submit" id="confirm-button" theme="primary" label="Confirm" />
            </form>
        </x-slot>
    </x-adminlte-modal>


    <script>
        var orderItems;
        var id;

        orderItems = {!! json_encode($items) !!};

        $.each(orderItems, function(key, value) {
            $('#menu-' + value.id).addClass('active');
            $('#menu-' + value.id + '-qty').text(value.pivot.qty + 'x ');
        });

        $('#addItemModal').on('show.bs.modal', function(e) {
            var menu = $(e.relatedTarget).data('model');
            id = menu.id;
            $('#modal-error').text('');
            $('#menu-image').attr('src', '/storage/images/' + menu.image);
            $('#menu-name').text(menu.name);
            $('#menu-description').text(menu.description);
            $('#menu-price').text('RM ' + menu.price);
            item = orderItems.find(item => item.id == menu.id);
            if (item) {
                $('#menu-qty').val(item.pivot.qty);
                $('#menu-note').val(item.pivot.note);
            }
        });

        $('#add-item-button').on('click', function() {
            if ($('#menu-qty').val() > 0) {
                $.post('{{ route('front.order.add') }}', {
                    _token: '{{ csrf_token() }}',
                    orderID: '{{ $order->id }}',
                    menuID: id,
                    qty: $('#menu-qty').val(),
                    note: $('#menu-note').val()
                }, function(data) {
                    if (data.success) {
                        location.reload();
                    }
                });
            } else {
                $('#modal-error').text('Quantity must be greater than 0');
            }
        });

        $('#remove-item-button').on('click', function() {
            $.post('{{ route('front.order.remove') }}', {
                _token: '{{ csrf_token() }}',
                orderID: '{{ $order->id }}',
                menuID: id,
            }, function(data) {
                if (data.success) {
                    location.reload();
                }
            });
        });
    </script>
@endsection
