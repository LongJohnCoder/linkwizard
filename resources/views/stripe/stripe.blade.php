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
                                <table>
                                    <tr>
                                        <td>
                                                <input id="cvc_number" class="form-control input-sm" style="width:150px" required="required" data-stripe="cvc" data-parsley-type="number" data-parsley-trigger="change focusout" minlength="3" maxlength="4" data-parsley-class-handler="#cvc-group" type="PASSWORD" placeholder="YYY / ZZZZ">            
                                        </td>
                                        <td>
                                                <button class="btn" style="width:100px" id="show_hide">show</button>
                                        </td>
                                    </tr>
                                </table>            
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
        <script type="text/javascript">
            $(document).ready(function(){
                $('#show_hide').click(function(){
                    if($('#show_hide').text() == 'show')
                    {
                        $('#show_hide').text('hide');
                        $('#cvc_number').attr('type' , 'text');
                    }
                    else
                    {
                        $('#show_hide').text('show');
                        $('#cvc_number').attr('type' , 'PASSWORD');
                    }
                });
            });
        </script>
    </div>