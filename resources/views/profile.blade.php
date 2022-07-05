@extends('layouts.app')

@section('content')
    <div id="fh5co-menus" data-section="menu">
        <div class="container">
            <h1>Profile</h1>

            <div class="row row-padded">
                <div class="col-md-12">
                    <div class="fh5co-food-menu to-animate-2">
                        <ul>
                            @forelse ($orders as $order)
                                <li>
                                    <div class="fh5co-food-desc">
                                        <div>
                                            <h3>{{ \Carbon\Carbon::parse($order->reserved_at)->format('D, d F Y, H:i') }}
                                            </h3>
                                            @forelse ($order->menus as $item)
                                                <p>{{ $item->pivot->qty }}x {{ $item->name }} @
                                                    RM{{ $item->pivot->price }}</p>
                                            @empty
                                                <p>No order yet.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="fh5co-food-pricing">
                                        RM {{ $order->total ?? 0 }}
                                    </div>
                                </li>
                            @empty
                                <p>No order yet.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <a class="btn btn-primary" href="{{ route('front.book') }}">Reserve</a>
        </div>
    </div>
@endsection
