<div id="profile-section" data-section="profile" style="background-image: url(images/slide_2.jpg)"
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
        <div class="row" style="display: flex;">
            <div class="col-md-6" style="flex: 1;">
                <div class="fh5co-event to-animate-2"
                    style="height: 100%; display: flex; justify-content: space-evenly; flex-direction: column">
                    <div>
                        <h3>Login</h3>
                        <span class="fh5co-event-meta">Login to your account below</span>
                    </div>
                    <form action="{{ route('customer.login') }}" class="dark-form" method="POST">
                        @csrf
                        <div class="form-group">
                            @if ($errors->login && $errors->login->first() != '')
                                <label class="text-warning">{{ $errors->login->first() }}</label>
                            @endif
                            <label for="email-phone" class="sr-only">Email/Phone</label>
                            <input id="email-phone" class="form-control" placeholder="Email/Phone" name="email-phone"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" class="form-control" placeholder="Password" type="password"
                                name="password" required />
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-outline" value="Login" type="submit" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6" style="flex: 1;">
                <div class="fh5co-event to-animate-2"
                    style="height: 100%; display: flex; justify-content: space-evenly; flex-direction: column">
                    <div>
                        <h3>Register</h3>
                        <span class="fh5co-event-meta">Fill the form below to register</span>
                    </div>
                    <form action="" class="dark-form">
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input id="name" name="name" class="form-control" placeholder="Name" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="email-phone" class="sr-only">Email/Phone</label>
                            <input id="email-phone" name="email-phone" class="form-control" placeholder="Email/Phone"
                                type="text" />
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" class="form-control" placeholder="Password"
                                type="password" />
                        </div>
                        <div class="form-group">
                            <label for="password-confirmation" class="sr-only">Confirm Password</label>
                            <input id="password-confirmation" name="password-confirmation" class="form-control"
                                placeholder="Confirm Password" type="password" />
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
