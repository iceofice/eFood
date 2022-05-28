<div id="fh5co-featured" data-section="features">
    <div class="container">
        <div class="row text-center fh5co-heading row-padded">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="heading to-animate">Featured Dishes</h2>
                <p class="sub-heading to-animate">
                    Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                    there live the
                    blind texts.
                </p>
            </div>
        </div>
        <div class="row">
            @if (isset($featured[0]))
                <div class="fh5co-grid">
                    <div class="fh5co-v-half to-animate-2">
                        <div class="fh5co-v-col-2 fh5co-bg-img"
                            style="background-image: url('storage/images/{{ $featured[0]->image }}')">
                        </div>
                        <div class="fh5co-v-col-2 fh5co-text fh5co-special-1 arrow-left">
                            <h2>{{ $featured[0]->name }}</h2>
                            <span class="pricing">RM{{ $featured[0]->price }}</span>
                            <p>
                                {{ $featured[0]->description }}
                            </p>
                        </div>
                    </div>
                    <div class="fh5co-v-half">
                        <div class="fh5co-h-row-2 to-animate-2">
                            <div class="fh5co-v-col-2 fh5co-bg-img"
                                style="background-image: url('storage/images/{{ $featured[1]->image }}')"></div>
                            <div class="fh5co-v-col-2 fh5co-text arrow-left">
                                <h2>{{ $featured[1]->name }}</h2>
                                <span class="pricing">RM{{ $featured[1]->price }}</span>
                                <p>{{ $featured[1]->description }}</p>
                            </div>
                        </div>
                        <div class="fh5co-h-row-2 fh5co-reversed to-animate-2">
                            <div class="fh5co-v-col-2 fh5co-bg-img"
                                style="background-image: url('storage/images/{{ $featured[2]->image }}')"></div>
                            <div class="fh5co-v-col-2 fh5co-text arrow-right">
                                <h2>{{ $featured[2]->name }}</h2>
                                <span class="pricing">RM{{ $featured[2]->price }}</span>
                                <p>{{ $featured[2]->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h3>No featured menu</h3>
                </div>
            @endif
        </div>
    </div>
</div>
