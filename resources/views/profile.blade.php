<!DOCTYPE html>

<!-- head of th page -->
<html lang="en">
@include('pixels.pixel_head')
<body>
<!-- head end -->

<link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
<script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
<script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
<!-- Header Start -->
<!-- Link Preview Files -->
<script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreview.js'}}"></script>
<script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreviewRetrieve.js'}}"></script>
<link href="{{URL::to('/').'/public/Link-Preview-master/css/linkPreview.css'}}" rel="stylesheet" type="text/css">
<!-- End Of Link Preview Files -->
<!-- Datatable files -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<!-- End of datatable files -->
@include('pixels.pixel_header')

@if(session()->has('msg'))
    @if(session()->get('msg')=='success')
        <script>
            swal({
                title: "Success!",
                text: "Profile information has been successfully added",
                icon: "success",
                button: "OK",
            });
        </script>
    @elseif(session()->get('msg')=='error')
        <script>
            swal({
                title: "Error!",
                text: "Something went wrong during the process, please try again",
                icon: "warning",
                button: "OK",
            });
        </script>
    @endif
@endif
<!-- Header End -->
<div class="main-dashboard-body">
    <div class="main-content">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="container">
                        <form action="{{route('saveprofile')}}" method="post" enctype="multipart/form-data">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Manage Your Profile</h4></div>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <table class="table profile-table" border="0">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="redirection_page_type_one" id="redirect_type_one" {{$checkRedirectPageOne}}>
                                                </td>
                                                <td>
                                                    <h6> DON'T SHOW DEFAULT REDIRECTION PAGE</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="redirection_page_type_zero" id="redirect_type_zero" {{$checkRedirectPageZero}}>
                                                </td>
                                                <td>
                                                    <h6>SHOW DEFAULT REDIRECTION PAGE</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    REDIRECTION TIME
                                                </td>
                                                <td>
                                                    <input type='number' name='default_redirection_time' class='form-control redirection_time' id='default_redirection_time' min='1' max='30' value='{{$redirectionTime}}' disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    SELECT SKIN COLOUR
                                                </td>
                                                <td>
                                                    <input type="color" name="pageColor" value='{{$skinColour}}'>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    SELECT DEFAULT IMAGE
                                                </td>
                                                <td>
                                                    <input type="file" name="default_image" id="default_image" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" class="btn btn-block btn-primary" name="profile_btn" value="Confirm Changes" onclick="return profileValidate()">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('contents/footer')
<script>
    $(document).ready(function(){
       $('#redirect_type_one').on('click', function(){
            var redirectTypeZeroCheck =  $('#redirect_type_zero').prop('checked');
            if (redirectTypeZeroCheck==true) {
                $('#redirect_type_zero').prop('checked', false);
                $('#default_redirection_time').prop('disabled', true);
            } else {
                $('#default_redirection_time').prop('disabled', true);
            }
       });

        $('#redirect_type_zero').on('click', function(){
            var redirectTypeOneCheck =  $('#redirect_type_one').prop('checked');
            if (redirectTypeOneCheck==true) {
                $('#redirect_type_one').prop('checked', false);
                $('#default_redirection_time').prop('disabled', false);
            } else {
                $('#default_redirection_time').prop('disabled', false);
            }
        });
    });
</script>
<script>
    $(function(){
        $('#default_redirection_time').bind('keyup change click' ,function(){
            var countDownTime = $(this).val();
            if (countDownTime.match(/[0-9]|\./)) {
                if (countDownTime<=30 && countDownTime>=1) {
                    $('#default_redirection_time').val(countDownTime);
                }
                if (countDownTime>30) {
                    $('#default_redirection_time').val(30);
                }
                if (countDownTime<=0) {
                    $('#default_redirection_time').val(1);
                }
            } else {
                swal({
                    type: 'warning',
                    title: 'Notification',
                    text: 'Countdown time should be numeric and minimum 1 & maximum 30.'
                });
                $('#default_redirection_time').val(5);
            }
        });
    });

    function profileValidate()
    {
        if ($('#redirect_type_one').prop('checked')==false) {
            if ($('#redirect_type_zero').prop('checked')==false) {
                swal({
                    type: 'warning',
                    title: 'Notification',
                    text: 'Please select one of the redirection type before proceeding'
                });
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(this).on('click', '.menu-icon', function(){
        $(this).addClass("close");
        $('#userdetails').slideToggle(500);
        $('#myNav1').hide();
        $('#myNav2').hide();
    });
      $("#basic").click(function(){
        $('.menu-icon').addClass("close");
        $('#myNav1').slideToggle(500);
        $('#myNav2').hide();
        $('#userdetails').hide();
        maintainSidebar(this);
    });
    $("#advanced").click(function(){
        $('.menu-icon').addClass("close");
        $('#myNav2').slideToggle(500);
        $('#myNav1').hide();
        $('#userdetails').hide();
        maintainSidebar(this);
    });

    $(this).on('click', '.close', function(){
        $('.userdetails').hide();
        $(this).removeClass("close");
    });
  });
</script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
e=o.createElement(i);r=o.getElementsByTagName(i)[0];
e.src='//www.google-analytics.com/analytics.js';
r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
ga('create','UA-XXXXX-X');ga('send','pageview');
</script>
</body>
</html>