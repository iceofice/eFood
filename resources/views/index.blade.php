<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>eFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic|Merriweather:300,400italic,300italic,400,700italic"
        rel="stylesheet" type="text/css" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css" />
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css" />
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="css/simple-line-icons.css" />
    <!-- Datetimepicker -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <!-- Flexslider -->
    <link rel="stylesheet" href="css/flexslider.css" />
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css" />

    <link rel="stylesheet" href="css/style.css" />

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
</head>

<body>
    <div id="fh5co-container">
        <div class="js-sticky">
            <div class="fh5co-main-nav">
                <div class="container-fluid">
                    <div class="fh5co-menu-1">
                        <!-- <a href="#" data-nav-section="home">Home</a> -->
                        <a href="#" data-nav-section="features">Featured</a>
                        <a href="#" data-nav-section="menu">Menu</a>
                    </div>
                    <div class="fh5co-logo">
                        <a href="index.html">foodee</a>
                    </div>
                    <div class="fh5co-menu-2">
                        <a href="#" data-nav-section="reservation">Reservation</a>
                        <a href="#" data-nav-section="profile">Profile</a>
                    </div>
                </div>
            </div>
        </div>

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
                </div>
            </div>
        </div>

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
                                <div role="tabpanel" class="tab-pane fade in @once active @endonce"
                                    id="{{ $slug }}">
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

        <div id="fh5co-contact" data-section="reservation">
            <div class="container">
                <div class="row text-center fh5co-heading row-padded">
                    <div class="col-md-8 col-md-offset-2">
                        <h2 class="heading to-animate">Reserve a Table</h2>
                        <p class="sub-heading to-animate">
                            Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the
                            blind texts.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 to-animate-2">
                        <h3>Contact Info</h3>
                        <ul class="fh5co-contact-info">
                            <li class="fh5co-contact-address">
                                <i class="icon-home"></i>
                                5555 Love Paradise 56 New Clity 5655, <br />Excel Tower United Kingdom
                            </li>
                            <li><i class="icon-phone"></i> (123) 465-6789</li>
                            <li><i class="icon-envelope"></i>info@freehtml5.co</li>
                            <li>
                                <i class="icon-globe"></i>
                                <a href="http://freehtml5.co/" target="_blank">freehtml5.co</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 to-animate-2">
                        <h3>Reservation Form</h3>
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input id="name" class="form-control" placeholder="Name" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input id="email" class="form-control" placeholder="Email" type="email" />
                        </div>
                        <div class="form-group">
                            <label for="occation" class="sr-only">Occation</label>
                            <select class="form-control" id="occation">
                                <option>Select an Occation</option>
                                <option>Wedding Ceremony</option>
                                <option>Birthday</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" class="sr-only">Date</label>
                            <input id="date" class="form-control" placeholder="Date &amp; Time" type="text" />
                        </div>

                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="" id="message" cols="30" rows="5" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-outline" value="Send Message" type="submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="fh5co-events" data-section="profile" style="background-image: url(images/slide_2.jpg)"
            data-stellar-background-ratio="0.5">
            <div class="fh5co-overlay"></div>
            <div class="container">
                <div class="row text-center fh5co-heading row-padded">
                    <div class="col-md-8 col-md-offset-2 to-animate">
                        <h2 class="heading">Profile</h2>
                        <p class="sub-heading">
                            Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the
                            blind texts.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="fh5co-event to-animate-2">
                            <h3>Login</h3>
                            <span class="fh5co-event-meta">Login to your account below</span>
                            <form action="" class="dark-form">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input id="email" class="form-control" placeholder="Email" type="email" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="password" class="form-control" placeholder="Password"
                                        type="password" />
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary btn-outline" value="Login" type="submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fh5co-event to-animate-2">
                            <h3>Register</h3>
                            <span class="fh5co-event-meta">Fill the form below to register</span>
                            <form action="" class="dark-form">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input id="email" class="form-control" placeholder="Email" type="email" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="password" class="form-control" placeholder="Password"
                                        type="password" />
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary btn-outline" value="Register" type="submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Easing -->
    <script src="js/jquery.easing.1.3.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Bootstrap DateTimePicker -->
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Stellar Parallax -->
    <script src="js/jquery.stellar.min.js"></script>

    <!-- Flexslider -->
    <script src="js/jquery.flexslider-min.js"></script>
    <script>
        $(function() {
            $("#date").datetimepicker();
        });
        $("#myTabs a").click(function(e) {
            e.preventDefault();
            $(this).tab("show");
        });
    </script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
</body>

</html>
