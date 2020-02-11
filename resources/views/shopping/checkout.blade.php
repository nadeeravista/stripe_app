
<html>
    <head>
        <title>Shopping</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                    <h1>Checkout</h1>
                    <h4>Your Total: {{config("cart_settings.currency")}}{{ $total }}</h4>
                    <div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : ''  }}">
                        {{ Session::get('error') }}
                    </div>
                    @if(Session::has('success'))
                    <div class="alert alert-info">
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    {!! Form::open(['url' => 'checkout', 'id' => 'checkout-form']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" class="form-control" required>
                            </div>
                        </div>
                        <hr>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="card-name">Card Holder Name</label>
                                <input type="text" id="card-name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="card-number">Credit Card Number</label>
                                <input type="text" id="card-number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="card-expiry-month">Expiration Month</label>
                                        <input type="text" id="card-expiry-month" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="card-expiry-year">Expiration Year</label>
                                        <input type="text" id="card-expiry-year" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="card-cvc">CVC</label>
                                <input type="text" id="card-cvc" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Pay</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
    Stripe.setPublishableKey('pk_test_UyOgf40YeF8qB5TxszNgzxrj');

    var $form = $('#checkout-form');

    $form.submit(function (event) {
        $('#charge-error').addClass('hidden');
        $form.find('button').prop('disabled', true);
        Stripe.card.createToken({
            number: $('#card-number').val(),
            cvc: $('#card-cvc').val(),
            exp_month: $('#card-expiry-month').val(),
            exp_year: $('#card-expiry-year').val(),
            name: $('#card-name').val()
        }, stripeResponseHandler);
        return false;
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('#charge-error').removeClass('hidden');
            $('#charge-error').text(response.error.message);
            $form.find('button').prop('disabled', false);
        } else {
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));

            // Submit the form:
            $form.get(0).submit();
        }
    }
        </script>
    </body>

</html>


