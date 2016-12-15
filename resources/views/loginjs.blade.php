<script src="http://t4t5.github.io/sweetalert/dist/sweetalert-dev.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onReturnCallback&render=explicit" async defer></script>

<script type="text/javascript">

    $(document).ready(function() {

        $("#tier5_us").click(function(){
            window.location.href = "http://tier5.us";
        });

        $("#login1").click(function(){
            $("#signup_btn").click();
        });
        $("#signup1").click(function(){
            $("#login_btn").click();
        });
        

        $(".menu-icon").click(function(){
            $(this).toggleClass("close");
            $('.mobile-menu ul').slideToggle(500);
        });

        // previous functions here


         $('#useremail').on('blur', function() {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2}){1}$');
            if (emailInput.length === 0) {
                $(this).focus();
                $('#useremailValidation').remove('#useremailValidation');
                $(this).parent().append("<span id='useremailValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
                $('#useremailValidation').remove('#useremailValidation');
                $(this).parent().append("<span id='useremailValidation' style='color: red'>Please enter a valid email address.</span>");
                return false;
            } else {
                $('#useremailValidation').remove('#useremailValidation');
                return true;
            }
        });

    $('#useremail').on('keypress', function() {
            $('#useremailValidation').remove('#useremailValidation');
        });

        $('#passwordlogin').on('blur', function() {
            passwordInput = $(this).val();
            if (passwordInput.length === 0) {
                $(this).focus();
                $('#passwordloginValidation').remove('#passwordloginValidation');
                $(this).parent().append("<span id='passwordloginValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else {
                $('#passwordloginValidation').remove('#passwordloginValidation');
                return true;
            }
        });

        $('#passwordlogin').on('keypress', function() {
            $('#passwordloginValidation').remove('#passwordloginValidation');
        });

        $('#Name').on('blur', function(e) {
            nameRegex = new RegExp('^([a-zA-Z\. ]){2,}$');
            nameInput = $(this).val();
            if (nameInput.length === 0) {
                $(this).focus();
                $('#NameValidation').remove('#NameValidation');
                $(this).parent().append("<span id='NameValidation' style='color: red'>Name field should not be blank.</span>");
                return false;
            } else if (!nameRegex.test(nameInput)) {
                $(this).focus();
                $('#NameValidation').remove('#NameValidation');
                $(this).parent().append("<span id='NameValidation' style='color: red'>Please enter a valid name. Name should contain letters and space.</span>");
                return false;
            } else {
                $('#NameValidation').remove('#NameValidation');
                return true;
            }
        });

        $('#Name').on('keypress', function () {
            $('#NameValidation').remove('#NameValidation');
        });

        $('#Email').on('blur', function () {
            emailInput = $(this).val();
            emailRegex = new RegExp('^([a-zA-Z0-9-_\.])+@([a-z0-9]+[\.]+[a-z]{2,}([\.]*[a-z]){0,2}){1}$');
            if (emailInput.length === 0) {
                $(this).focus();
                $('#EmailValidation').remove('#EmailValidation');
                $(this).parent().append("<span id='EmailValidation' style='color: red'>Email field should not be blank.</span>");
                return false;
            } else if (!emailRegex.test(emailInput)) {
                $(this).focus();
                $('#EmailValidation').remove('#EmailValidation');
                $(this).parent().append("<span id='EmailValidation' style='color: red'>Please enter a valid email address.</span>");
                return false;
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('postEmailCheck') }}',
                    data: {
                        email: emailInput,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.exist) {
                            $('#Email').focus();
                            $('#EmailValidation').remove('#EmailValidation');
                            $('#Email').parent().append("<span id='EmailValidation' style='color: red'>This email is already registered.</span>");
                            return false;
                        } else {
                            $('#EmailValidation').remove('#EmailValidation');
                            return true;
                        }
                    },
                    error: function (response) {
                        console.log('Response error!');
                    },
                    statusCode: function (response) {
                        console.log('Internal server error!');
                    }
                });
                $('#EmailValidation').remove('#EmailValidation');
                return true;
            }
        });

        $('#Email').on('keypress', function () {
            $('#EmailValidation').remove('#EmailValidation');
        });

        $('#password').on('keyup', function() {
            passwordRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            passwordInput = $(this).val();
            if (passwordInput.length === 0) {
                $(this).focus();
                $('#passwordValidation').remove('#passwordValidation');
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password field should not be blank.</span>");
                return false;
            } else if (!passwordRegex.test(passwordInput)) {
                $(this).focus();
                $('#passwordValidation').remove('#passwordValidation');
                $(this).parent().append("<span id='passwordValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else {
                $('#passwordValidation').remove('#passwordValidation');
                return true;
            }
        });

        /*$('#password').on('keypress', function () {
            $('#passwordValidation').remove('#passwordValidation');
        });*/

        $('#password_confirmation').on('keyup', function() {
            password_confirmationRegex =  new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*_+\-=?\.]).{8,}');
            password_confirmationInput = $(this).val();
            passwordInput = $('#password').val();
            if (password_confirmationInput.length === 0) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Confirm password field should not be blank.</span>");
                return false;
            } else if (!password_confirmationRegex.test(password_confirmationInput)) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password should be atleast eight characters long and contain one lowercase, one uppercase, one numeric and one special character.</span>");
                return false;
            } else if (passwordInput !== password_confirmationInput) {
                $(this).focus();
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                $(this).parent().append("<span id='password_confirmationValidation' style='color: red'>Password and confirm password should match.</span>");
                return false;
            } else {
                $('#password_confirmationValidation').remove('#password_confirmationValidation');
                return true;
            }
        });

        var onReturnCallback = function() {
            alert("grecaptcha is ready!");
        };

        function validateHumanity() {
            submit.preventDefault();
            var captcha_response = grecaptcha.getResponse();
            alert(captcha_response);
            if(captcha_response.length == 0) {
                $('#reCAPTCHA_div').parent().append("<span id='humancheckValidation' style='color: red'>Prove that you are not a robot!</span>");
                return false;
            } else {
                $('#humancheckValidation').remove('#humancheckValidation');
                return true;
            }
        }



        var options = {
            theme: "custom",
            content: '<img style="width:80px;" src="{{ URL::to(' / ').' / public / resources / img / company_logo.png ' }}" class="center-block">',
            message: "Please wait a while",
            backgroundColor: "#212230"
        };
        $('#swalbtn').click(function() {
            var url = $('#givenUrl').val();
            var validUrl = ValidURL(url);
            @if(Auth::user())
            var userId = {
                {
                    Auth::user() - > id
                }
            };
            @else
            var userId = 0;
            @endif
            if (url) {
                if (validUrl) {
                    HoldOn.open(options);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('postShortUrlTier5') }}",
                        data: {
                            url: url,
                            user_id: userId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                var shortenUrl = response.url;
                                var displayHtml = "<a href=" + shortenUrl + " target='_blank' id='newshortlink'>" + shortenUrl + "</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink'><i class='fa fa-clipboard'></i> Copy</button>";
                                swal({
                                    title: "Shorten Url:",
                                    text: displayHtml,
                                    type: "success",
                                    html: true
                                });
                                new Clipboard('#clipboardswal');
                                HoldOn.close();
                            } else {
                                swal({
                                    title: null,
                                    text: "Please paste an actual URL",
                                    type: "warning",
                                    html: true
                                });
                                HoldOn.close();
                            }
                        },
                        error: function(response) {
                            console.log('Response error!');
                            HoldOn.close();
                        },
                        statusCode: {
                            500: function() {
                                console.log('500 internal server error!');
                                swal({
                                    title: null,
                                    text: "Access Forbidden, Please paste a valid URL!",
                                    type: "error",
                                    html: true
                                });
                                HoldOn.close();
                            }
                        }
                    });
                } else {
                    var errorMsg = "Enter A Valid URL";
                    swal({
                        title: null,
                        text: errorMsg,
                        type: "error",
                        html: true
                    });
                }
            } else {
                var errorMsg = "Please Enter An URL";
                swal({
                    title: null,
                    text: errorMsg,
                    type: "warning",
                    html: true
                });
            }
        });

        function ValidURL(str) 
        {
            var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
            var url = str;
            if (!regexp.test(url)) {
                return false;
            } else {
                return true;
            }
        }

        //previous functions here
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".videosection img").click(function(e){
            $(this).hide();
            $(this).parent().find(".video")[0].src += "&autoplay=1";
            e.preventDefault();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.carousel-control').click(function(){
            $(this).addClass("clicked");
            $('.carousel-control').not($(this)).removeClass("clicked");
        });
    });
</script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.flexisel.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $("#flexiselDemo3").flexisel({
            visibleItems: 4,
            itemsToScroll: 1,         
            autoPlay: {
                enable: true,
                interval: 5000,
                pauseOnHover: true
            }        
        });
    });
</script>

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