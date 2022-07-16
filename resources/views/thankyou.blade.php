@extends('layouts.app')

@section('content')
    <div id="fh5co-type" style="background-image: url(images/slide_3.jpg); height:100vh;" data-stellar-background-ratio="0.5">
        <div class="fh5co-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="to-animate">Thank You {{ $customer }}</h3>
                    <p>Your reservation
                        @if ($order->menus->count() != 0)
                            and order have
                        @else
                            has
                        @endif
                        been recorded.
                    </p>
                    @if ($order->menus->count() == 0)
                        <p>Do you want to order the food?</p>
                        <form action="{{ route('front.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="orderID" value="{{ $order->id }}">
                            <button class="btn btn-primary" type="submit">Order Now</button>
                        </form>
                        <a href="{{ route('front.profile') }}">No Thanks</a>
                    @else
                        <p>Your order: </p>
                        <div class="row" style="margin: 0 auto 1.5rem; width: 50%;">
                            @foreach ($order->menus as $item)
                                <div class="fh5co-food-desc">
                                    <figure>
                                        <img class="img-responsive" src="{{ url('storage/images/' . $item->image) }}" />
                                    </figure>
                                    <div>
                                        <h3 style="font-size: 24px;">
                                            <span>{{ $item->pivot->qty }}x </span>
                                            {{ $item->name }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="fh5co-food-pricing" style="font-size: 18px;">
                                    RM{{ number_format($item->price * $item->pivot->qty, 2, '.', ',') }}
                                </div>
                            @endforeach
                            <div class="fh5co-food-pricing mb-4">
                                <span style="color: #ddd">Total:</span>
                                RM{{ $order->total }}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <form action="{{ route('front.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="orderID" value="{{ $order->id }}">

                            <button class="btn btn-primary" type="submit">Edit Order</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
