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
        @yield('content')
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
