<div id="reserve-section" data-section="reservation">
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
                <ul class="reserve-section-info">
                    <li class="reserve-section-address">
                        <i class="icon-home"></i>
                        125, Jalan Radin Anum 1 <br />Bandar Baru Sri Petaling <br />Kuala Lumpur
                    </li>
                    <li><i class="icon-phone"></i> (+60) 11-3670-5125</li>
                    <li><i class="icon-envelope"></i>efood@gmail.com</li>
                    <li>
                        <i class="icon-globe"></i>
                        <a href="#">eFood Website</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 to-animate-2">
                <h3>Reservation Form</h3>
                @if ($errors->reserve && $errors->reserve->first() != '')
                    <div class="text-warning">{{ $errors->reserve->first() }}</div>
                @endif
                <form action="{{ route('front.findCustomer') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input id="name" name="name" class="form-control" placeholder="Name" type="text"
                            required />
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
