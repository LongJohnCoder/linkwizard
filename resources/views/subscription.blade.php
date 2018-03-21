<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="https://tier5.us/images/favicon.ico">
    <title>Tier5 | URL Shortener | Subscription</title>
    <meta name="description" content="A free URL shortner brought to you by Tier5 LLC." />
    <meta name="keywords" content="Tier5 URL Shortner, Tr5.io, Tier5" />
    <meta name="author" content="Tier5 LLC" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/animate.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style.css">
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/style2.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/custom.css" />
    <link rel="stylesheet" href="https://t4t5.github.io/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" href="{{ URL('/')}}/public/resources/css/creditCardTypeDetector.css" />
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{--
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <style>
    body {
        font-family: 'Nunito';
    }

    .fa-btn {
        margin-right: 6px;
    }

    .alert.parsley {
        margin-top: 5px;
        margin-bottom: 0px;
        padding: 10px 15px 10px 15px;
    }

    .check .alert {
        margin-top: 20px;
    }

    .credit-card-box .panel-title {
        display: inline;
        font-weight: bold;
    }

    .credit-card-box .display-td {
        display: table-cell;
        vertical-align: middle;
        width: 100%;
    }

    .credit-card-box .display-tr {
        display: table-row;
    }

    </style>
</head>

<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- open/close -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="logo">
                        <a href="{{ route('getIndex') }}">
                            <img src="{{config('settings.SITE_LOGO')}}" alt="img" />
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 header-right">
                    <div class="menu-icon">
                        <span id="hamburger" class="sidebar" aria-hidden="false" data-action="open" data-side="right">
                            <i class="fa fa-bars"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="myNav" class="sidebar right">
            <span id="cross" class="closebtn"><i class="fa fa-times"></i></span>
            <div class="overlay-content">
                <a href="{{ route('getLogout') }}">
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-sign-out"></i>Sign out</button>
                </a>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <a href="{{ route('getDashboard') }}">
                    <button type="button" class="btn btn-success btn-sm"><i class="fa fa-upgrade"></i>Dashboard</button>
                </a>
            </div>
        </div>
    </header>
    <section class="hero">
        <section class="main-content">
            <span class="payment-errors" style="color: red;margin-top:10px;"></span>
            <div class="texture-overlay"></div>
            <div class="container-fluid">
                <div class="row animate-box fadeInUp animated">
                    <div class="col-md-12 heading text-center">
                        <h2 style="color: #fff">Our Service Packages</h2>
                    </div>
                </div>
                <div class="pack-wrap">
                    <!-- container -->
                    <div id="freeTier" class="package {{ $subscription_status == null ? 'brilliant' : null }}">
                        <div class="name">Free</div>
                        <div class="price">$0</div>
                        <div class="trial">Upto 10 Shorten Links</div>
                        <hr>
                        <ul>
                            <li>
                                <strong>10</strong> Shorten Links
                            </li>
                            <li>
                                <strong>Basic</strong> Analytics
                            </li>
                            <li>
                                <strong>No</strong> Custom Links
                            </li>
                            <li>
                                <strong>No</strong> Support
                            </li>
                        </ul>
                        <button class="btn btn-default" type="submit" disabled="disabled">Subsribed</button>
                    </div>
                    <div id="basicTier" class="package {{ $subscription_status == 'tr5Basic' ? 'brilliant' : null }}">
                        <div class="name">Advanced</div>
                        <div class="price">$10</div>
                        <div class="trial">Upto 100 Shorten Links</div>
                        <hr>
                        <ul>
                            <li>
                                <strong>100</strong> Shorten Links
                            </li>
                            <li>
                                <strong>Advanced</strong> Analytics
                            </li>
                            <li>
                                <strong>Custom</strong> Links
                            </li>
                            <li>
                                <strong>Business</strong> Hour Supports
                            </li>
                        </ul>
                        @if ($subscription_status == 'tr5Basic')
                            <button class="btn btn-default" type="submit" disabled="disabled">
                                Subsribed
                            </button>
                        @else
                        <button id="basicButton" class="btn btn-default" type="button">
                            Subsribe Now
                        </button>
                        @endif
                    </div>
                    <div id="advancedTier" class="package {{ $subscription_status == 'tr5Advanced' ? 'brilliant' : null }} no-margin-right">
                        <div class="name">Pro</div>
                        <div class="price">$20</div>
                        <div class="trial">Unlimited Shorten Links</div>
                        <hr>
                        <ul>
                            <li>
                                <strong>Unlimited</strong> Shorten Links
                            </li>
                            <li>
                                <strong>Advanced</strong> Analytics
                            </li>
                            <li>
                                <strong>Custom</strong> Links
                            </li>
                            <li>
                                <strong>24 X 7</strong> Hour Supports
                            </li>
                        </ul>
                        @if ($subscription_status == 'tr5Advanced')
                            <button class="btn btn-default" type="submit" disabled="disabled">
                                Subsribed
                            </button>
                        @else
                        <button id="advancedButton" class="btn btn-default" type="button">
                            Subsribe Now
                        </button>
                        @endif
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
            </div>
        </section>
    </section>
    <div class="modal fade bs-modal-sm" id="stripeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="credit-card-box">
                        <h3 class="panel-title">We accept following cards</h3>
                        <ul class="card_logos list-inline">
                            <li class="card_visa">Visa</li>
                            <li class="card_mastercard">Mastercard</li>
                            <li class="card_amex">American Express</li>
                            <li class="card_discover">Discover</li>
                            <li class="card_jcb">JCB</li>
                            <li class="card_diners">Diners Club</li>
                        </ul>
                        <form method="POST" action="{{ route('postSubscription') }}" accept-charset="UTF-8" data-parsley-validate="data-parsley-validate" id="payment-form">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" value="" data-stripe="email" name="plan" id="plan">
                            <div class="form-group form-group-sm" id="cc-group">
                                <label for="checkout_card_number">Card number</label>
                                <input id="checkout_card_number" class="form-control input-sm stripe_card_number" required="required" data-stripe="number" data-parsley-type="number" minlength="16" maxlength="16" data-parsley-trigger="change focusout" data-parsley-class-handler="#cc-group" pattern="[0-9]*" autocomplete="off" type="text" placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            <div class="form-group form-group-sm" id="cvc-group">
                                <label for="">CVC</label>
                                <input class="form-control input-sm" required="required" data-stripe="cvc" data-parsley-type="number" data-parsley-trigger="change focusout" minlength="3" maxlength="4" data-parsley-class-handler="#cvc-group" type="text" placeholder="YYY / ZZZZ">
                            </div>
                            <div class="row">
                                <div class="form-group form-group-sm" id="exp-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="">Valid Upto</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <input type="text" class="form-control input-sm" placeholder="MM" minlength="2" maxlength="2" required="required" data-stripe="exp-month" data-parsley-type="number" data-parsley-trigger="change focusout" data-parsley-class-handler="#exp-group">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <input type="text" class="form-control input-sm" placeholder="YY" minlength="2" maxlength="2" required="required" data-stripe="exp-year" data-parsley-type="number" data-parsley-trigger="change focusout" data-parsley-class-handler="#exp-group">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="form-group form-group-sm">
                                <button type="submit" id="submitBtn" data-loading-text="<i class='fa fa-spinner'></i>" class="btn btn-lg btn-block btn-info btn-order" autocomplete="off">
                                    Pay <span id="money"></span>!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{ URL::to('/').'/public/resources/js/bootstrap.min.js'}}"></script>
    <script>
        $(document).ready(function () {
            $('#hamburger').on('click', function () {
                $('.sidebar.right').addClass('open', true);
                $('.sidebar.right').removeClass('close', true);
            });
            $('#cross').on('click', function () {
                $('.sidebar.right').toggleClass('close', true);
                $('.sidebar.right').removeClass('open', true);
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $('#freeTier').on('click', function() {
            $(this).addClass('brilliant');
            $('#basicTier').removeClass('brilliant');
            $('#advancedTier').removeClass('brilliant');
        });
        $('#basicTier').on('click', function() {
            $(this).addClass('brilliant');
            $('#freeTier').removeClass('brilliant');
            $('#advancedTier').removeClass('brilliant');
        });
        $('#advancedTier').on('click', function() {
            $(this).addClass('brilliant');
            $('#freeTier').removeClass('brilliant');
            $('#basicTier').removeClass('brilliant');
        });
        $('#basicButton').on('click', function() {
            $('#stripeModal').modal('show');
            $('#money').text('$10');
            $('#plan').val('tr5Basic');
        });
        $('#advancedButton').on('click', function() {
            $('#stripeModal').modal('show');
            $('#money').text('$20');
            $('#plan').val('tr5Advanced');
        });
    });

    </script>
    <!-- PARSLEY -->
    <script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley " role="alert "></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };

    </script>
    <script src="https://parsleyjs.org/dist/parsley.js "></script>
    <script type="text/javascript " src="https://js.stripe.com/v2/ "></script>
    <script>
    Stripe.setPublishableKey("{{ env('STRIPE_PUBLISHABLE_SECRET') }}");
    $(function() {
        $('#payment-form').submit(function(event) {
            var $form = $(this);
            var $btn = $('#submitBtn').button('loading');
            $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                formInstance.submitEvent.preventDefault();
                console.log('Submit disabled!');
                return false;
            });
            $form.find('#submitBtn').prop('disabled', true);
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#payment-form');
        if (response.error) {
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').addClass('alert alert-danger');
            $form.find('#submitBtn').prop('disabled', false);
            $('#submitBtn').button('reset');
        } else {
            var token = response.id;
            $form.append($('<input type="hidden " name="stripeToken " />').val(token));
            $form.get(0).submit();
            $('#stripeModal').modal('hide');
        }
    };

    </script>
    <script src="{{ URL( '/')}}/public/resources/js/jquery.creditCardTypeDetector.js "></script>
    <script>
    $(document).ready(function() {
        $('#checkout_card_number').creditCardTypeDetector({
            'credit_card_logos': '.card_logos'
        });
    });

    </script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
    (function(b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function() {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');

    </script>
</body>

</html>
