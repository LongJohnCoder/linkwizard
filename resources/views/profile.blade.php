@extends('layout/layout')
@section('content')

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
                        
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Manage Your Settings</h4></div>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#zapier">Zapier</a></li>
                                        <li ><a data-toggle="tab" href="#redirection">Redirection</a></li>
                                        <!-- <li ><a data-toggle="tab" href="#zapier">Pixel</a></li> -->
                                    </ul>
                                    <div class="tab-content">
                                        <div id="zapier" class="tab-pane fade in active">
                                            <div class="panel-body">
                                                <h3>Zapier</h3>
                                                <div class="row">
                                                    <div class="col-md-12 form-group" >
                                                        <label>Invitation Link :</label>
                                                        <br>
                                                        <b class="form-control">{{env('ZAPIER_LINK')}}</b>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label id="lebelforzapiertoken">@if((isset($user->zapier_key)) && ($user->zapier_key!="")) Zapier Token @else Create Zapier Token @endif:</label>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <b type="text" name="zapier_key" id="zapier_key" class="form-control" style="display:@if((isset($user->zapier_key)) && ($user->zapier_key=="")) none; @endif">{{$user->zapier_key}}</b>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        @if(($user->zapier_key==""))
                                                            <button class="btn-success" id="create-zapier-key">Create</button>
                                                        @endif       
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div id="redirection" class="tab-pane">
                                        <form action="{{route('saveprofile')}}" method="post" enctype="multipart/form-data">
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
                                                        {{-- <tr>
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
                                                        </tr> --}}
                                                    </table>
                                                </div>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="submit" class="btn btn-block btn-primary" name="profile_btn" value="Confirm Changes" onclick="return profileValidate()">
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        
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
@stop

