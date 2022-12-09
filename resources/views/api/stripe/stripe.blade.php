@extends('backend.layouts.app')
@section('css')
<style type="text/css">
    .card-title {
        display: inline;
        font-weight: bold;
    }

    .display-table {
        display: table;
    }

    .display-tr {
        display: table-row;
    }

    .display-td {
        display: table-cell;
        vertical-align: middle;
        width: 61%;
    }
</style>
@endsection
@section('content')
<div class="container">

    <a href="{{ route('backend.subscription-change') }}" class="btn btn-primary"> <i class=" fas fa-caret-left"></i> Back to billing</a>

    <div class="row">
        <div class="col-md-6 m-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-header mb-2">
                        <!-- <p>Add your payment details</p> -->
                        <h4 class="card-title text-center text-primary">Add your payment details</h4>
                    </div>
                    <div class="m-auto mb-3">
                        <ul class="nav nav-tabs nav-bordered border-0">
                            <li class="nav-item">
                                <a href="{{ route('backend.stripe',['id'=>$billing->id]) }}" class="nav-link active">
                                    Stripe
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.paypal',['id'=>$billing->id]) }}" class="nav-link">
                                    Paypal
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                    <form role="form" action="{{ route('backend.stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <input type="hidden" name="billing_id" value="{{$billing->id}}">
                        <div class='mb-2 row'>
                            <div class='col-xs-12 required'>
                                <label class='control-label'>Name on Card</label>
                                <input class='form-control' size='4' type='text'>
                            </div>
                        </div>
                        <div class='mb-2 row'>
                            <div class='col-xs-12 card required'>
                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                            </div>
                        </div>
                        <div class='mb-2 row'>
                            <div class='col-xs-12 col-md-4 cvc required'>
                                <label class='control-label'>CVC</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 expiration required'>
                                <label class='control-label'>Expiration Month</label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 expiration required'>
                                <label class='control-label'>Expiration Year</label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
                        <div class='mb-2 row'>
                            <div class='col-md-12 error mb-2 d-none'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg w-100" type="submit">Pay Now (${{$billing->total_amount}})</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function() {

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('d-none');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('d-none');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('d-none')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>
@endsection