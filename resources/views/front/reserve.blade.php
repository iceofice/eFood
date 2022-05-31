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
                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('customers.add') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input id="name" name="name" class="form-control" placeholder="Name" type="text" required />
                    </div>
                    <div class="form-group">
                        <input id="email-phone" name="email-phone" class="form-control" placeholder="Email/Phone"
                            type="text" required />
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary btn-outline" value="Check Avaibility" type="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
