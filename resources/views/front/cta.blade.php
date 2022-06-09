<div id="fh5co-type" style="background-image: url(images/slide_3.jpg);" data-stellar-background-ratio="0.5">
    <div class="fh5co-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="to-animate">Welcome Back {{ Auth::guard('customer')->user()->name }}</h3>
                <a href="{{ route('front.order') }}" class="btn btn-primary">Order Now</a>
                <a href="{{ route('front.profile') }}" class="btn btn-primary btn-outline">Check Profile</a>
            </div>
        </div>
    </div>
</div>
