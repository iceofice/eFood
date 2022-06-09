<div class="js-sticky">
    <div class="fh5co-main-nav">
        <div class="container-fluid">
            <div class="fh5co-menu-1">
                @if (Illuminate\Support\Facades\Route::is('front'))
                    <a href="#" data-nav-section="features">Featured</a>
                    <a href="#" data-nav-section="menu">Menu</a>
                @endif
            </div>
            <div class="fh5co-logo">
                <a class="external" href="{{ route('front') }}">foodee</a>
            </div>
            <div class="fh5co-menu-2">
                @if (Illuminate\Support\Facades\Route::is('front'))
                    @if (Auth::guard('customer')->check())
                        <a class="external" href="{{ route('front.order') }}">Reserve</a>
                        <a class="external" href="{{ route('front.profile') }}">Profile</a>
                    @else
                        <a href="#" data-nav-section="reservation">Reserve</a>
                        <a href="#" data-nav-section="profile">Profile</a>
                    @endif
                @endif
            </div>
            @if (Auth::guard('customer')->check() && !Illuminate\Support\Facades\Route::is('front'))
                <div class="logout">
                    <a class="external" href="{{ route('front.logout') }}">Logout</a>
                </div>
            @endif

        </div>
    </div>
</div>
