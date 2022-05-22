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
                    @foreach ($categories as $slug => $category)
                        <li role="presentation" @once class="active" @endonce>
                            <a href="#{{ $slug }}" aria-controls="{{ $slug }}" role="tab"
                                data-toggle="tab">{{ $category }}</a>
                        </li>
                    @endforeach
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
                                                <li>
                                                    <div class="fh5co-food-desc">
                                                        <figure>
                                                            <img src="{{ url('storage/images/' . $menu->image) }}"
                                                                class="img-responsive"
                                                                alt="{{ $menu->name }} image" />
                                                        </figure>
                                                        <div>
                                                            <h3>{{ $menu->name }}</h3>
                                                            <p>{{ $menu->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="fh5co-food-pricing">RM {{ $menu->price }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            {{-- TODO: Empry Category --}}
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
                                                <li>
                                                    <div class="fh5co-food-desc">
                                                        <figure>
                                                            <img src="{{ url('storage/images/' . $menu->image) }}"
                                                                class="img-responsive"
                                                                alt="{{ $menu->name }} image" />
                                                        </figure>
                                                        <div>
                                                            <h3>{{ $menu->name }}</h3>
                                                            <p>{{ $menu->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="fh5co-food-pricing">RM {{ $menu->price }}
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
    </div>
</div>
