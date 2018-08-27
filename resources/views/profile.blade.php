@extends('layout/layout')
@section('content')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
@if(session()->has('msg'))
    @if(session()->get('msg')=='success')
        <script>
            swal({
                title: "Success!",
                text: "Profile information has been successfully added",
                type: "success",
                button: "OK",
            });
        </script>
    @elseif(session()->get('msg')=='error')
        <script>
            swal({
                title: "Error!",
                text: "Something went wrong during the process, please try again",
                type: "warning",
                button: "OK",
            });
        </script>
    @elseif(session()->get('msg')=='imgErr')
        <script>
            swal({
                title: "Invalid Image format",
                text: "Please select an image with jpg png or gif file format",
                type: "warning",
                button: "OK",
            });
        </script>
    @endif
@endif
@if(\Session::has('errs'))
  <div class="alert alert-danger">
      <p>{{\Session::get('errs')}}</p>
  </div>
@endif

@if(\Session::has('forget_success'))
  <div class="alert alert-success">
      <p>{{\Session::get('forget_success')}}</p>
  </div>
@endif
<!-- Header End -->
<div class="main-dashboard-body">
    <section class="main-content">
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
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Manage Your Settings</h4></div>
                <ul class="nav nav-tabs" style="padding-top:20px; border-bottom: 1px solid #337ab7;">
                    <li class="active "><a data-toggle="tab" href="#reset-password">Reset Password</a></li>
                    <li ><a data-toggle="tab" href="#redirection">Redirection Settings</a></li>
                    <li ><a data-toggle="tab" href="#zapier">Zapier Intigration</a></li>
                    <li ><a data-toggle="tab" href="#pixel">Manage Pixels</a></li>
                </ul>
                <div class="tab-content">
                    <div id="reset-password" class="tab-pane fade in active">
                        <div class="element-main">
                            <h2>Reset Your Existing Password Here</h2>
                            <form class="form" method="post" action="{{route('setPasswordSettings')}}" id="set-passwrd-form">
                            {{csrf_field()}}

                            <!-- Text input-->
                            <div class="control-group form-group">
                              <label for="Name" class="control-label">Registered Email:</label>
                              <div class="controls">
                                  <input class="form-control" type="email" name="email" placeholder="Your e-mail address" value="{{$user->email}}" readonly>
                              </div>
                            </div>
                            <!-- Old Password input-->
                            <div class="control-group form-group">
                              <label for="password" class="control-label">Old Password:</label>
                              <div class="controls">
                                  <input class="form-control" type="password" name="old_password" placeholder="Set Password" value="" id="old_password1">
                              </div>
                            </div>
                            <!-- New Password input-->
                            <div class="control-group form-group">
                                <label for="password" class="control-label">New Password:</label>
                                <div class="controls">
                                  <input class="form-control" type="password" name="new_password" placeholder="Set Password" value="" id="new_password1">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="control-group form-group">
                                <label for="password_confirmation" class="control-label">Confirm New Password:</label>
                                <div class="controls">
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Set Confirm Password" value="" id="password_confirmation1">
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="control-group form-group">
                                <div class="controls">
                                    <input class="form-control btn btn-success" type="submit" value="submit">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div id="zapier" class="tab-pane">
                        <div class="element-main">
                            <h2>Intigrate Zapier</h2>
                            <div class="control-group form-group">
                                <label for="Name" class="control-label">Invitation Link :</label>
                                <div class="controls">
                                    <input class="form-control" value="{{env('ZAPIER_LINK')}}" readonly>
                                </div>
                            </div>
                           
                            <div class="control-group form-group" style="display:@if($user->zapier_key=='') block @else none @endif" id="create-zapier-key-block">
                                <label for="Name" class="control-label">Create Zapier Token :</label>
                                <div class="controls">
                                    <button class="btn btn-block btn-success" id="create-zapier-key">Create</button>
                                </div>
                            </div>
                          
                            <div class="control-group form-group" style="display:@if($user->zapier_key=='') none @else block @endif" id="zapier_key_show">
                                <label for="Name" class="control-label">Zapier Token :</label>
                                <div class="controls">
                                    <input class="form-control" value="{{$user->zapier_key}}" id="zapier_key" readonly>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div id="redirection" class="tab-pane">
                        <div class="element-main">
                            <h2>Set Redirection Settings</h2>
                            <form action="{{route('saveprofile')}}" method="post" id="profileSettings" enctype="multipart/form-data">
                            <div class="control-group form-group" style="padding:20px;">
                                <div class="controls row alert">
                                    <div class="col-md-9">
                                        <label class="control-label"> Don't show default redirection page</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="redirection_page_type_one" id="redirect_type_one" {{$checkRedirectPageOne}}>
                                    </div>
                                </div>
                                <div class="controls row alert">
                                    <div class="col-md-9">
                                        <label class="control-label"> Show default redirection page</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="redirection_page_type_zero" id="redirect_type_zero" {{$checkRedirectPageZero}}>
                                    </div>
                                </div>
                                <div class="controls row alert" id="redirection_time_div" style="display: {{$checkRedirectPageOne == 'checked' ? 'none' : 'block'}};">
                                    <div class="row alert">
                                        <div class="col-md-9">
                                            <label class="control-label"> Choose default theme colour </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="color" name="pageColor" value="{{$skinColour}}">
                                        </div>
                                    </div>
                                    <div class="row alert">
                                        <div class="col-md-9">
                                            <label class="control-label"> Choose default brand logo </label>
                                            <small>{{$default_brand_logo == 1 ? '(Already uploaded a brand logo. You can choose another file to change the brand logo)' : ''}}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" name="default_image" id="default_image" accept="image/*">
                                            <span id="imageError" style="display: none; color: red"> <br>*This image is not valid. Please choose another image</span>
                                        </div>
                                    </div>
                                    <div class="row alert">
                                        <div class="col-md-9">
                                            <label class="control-label"> Redirection time</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type='number' name='default_redirection_time' class='form-control redirection_time' id='default_redirection_time' min='1' max='30' value='{{$redirectionTime}}'>
                                        </div>
                                    </div>
                                    <div class="row alert">
                                        <div class="col-md-9">
                                            <label class="control-label"> Redirection text</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type='text' name='default_redirection_text' class='form-control redirection_time' id='default_redirection_text' value='{{$redirecting_text}}' placeholder="Redirecting...">
                                        </div>
                                    </div>
                                </div>
                                <div class="controls row">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" class="btn btn-block btn-primary" name="profile_btn" value="Confirm Changes" onclick="return profileValidate()">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div id="pixel" class="tab-pane">
                        <div class="element-main">
                            <h2>Manage Your Pixels</h2>
                            @if(count($userPixels)==0)
                                <h4>You have not added any Pixel yet, click on the below button to get started!</h4>
                                <button class="btn btn-xs btn-primary" id="manage-pixel-btn" data-toggle="modal" data-target="#login-modal"><i class="fa fa-plus-square"></i> Add pixel</button>
                            @elseif(count($userPixels)>0)
                                <sapn class="pull-left" style="padding-bottom:20px;">
                                    <button class="btn btn-xs btn-primary" id="manage-pixel-btn" data-toggle="modal" data-target="#login-modal"><i class="fa fa-plus-square"></i> New pixel</button>
                                </sapn>
                                <table id="pixel-table" class="table table-hover pixel-table">
                                    <thead>
                                        <tr>
                                            <th>Pixel Name</th>
                                            <th>Pixel Provider</th>
                                            <th width="50%">Pixel ID</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userPixels as $pixel)
                                            <tr id="pixel-row-{{$pixel->id}}">
                                                <td>{{$pixel->pixel_name}}</td>
                                                <td>
                                                    @if($pixel->pixel_provider_id=='1')
                                                        <i class="fa fa-facebook"></i> Facebook
                                                    @elseif($pixel->pixel_provider_id=='2')
                                                        <i class="fa fa-google"></i> Google
                                                    @elseif($pixel->pixel_provider_id=='3')
                                                        <i class="fa fa-linkedin"></i> LinkedIn
                                                    @elseif($pixel->pixel_provider_id=='4')
                                                        <i class="fa fa-twitter"></i> Twitter
                                                    @elseif($pixel->pixel_provider_id=='5')
                                                        <i class="fa fa-pinterest"></i> Pinterest
                                                    @elseif($pixel->pixel_provider_id=='6')
                                                        <i class="fa fa-code"></i> Custom
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($pixel->pixel_id))
                                                        {{$pixel->pixel_id}}
                                                    @else
                                                        <div>{{$pixel->pixel_script}}</div>
                                                    @endif
                                                </td>
                                                <td>{{$pixel->created_at->diffForHumans()}}</td>
                                                <td><center>
                                                    <button class="action-btn pixel-edit-btn" href="javascript:void(0);" data-id="{{$pixel->id}}" id="pixel-edit-btn-{{$pixel->id}}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="action-btn pixel-delete-btn" href="javascript:void(0);" data-id="{{$pixel->id}}" id="pixel-delete-btn-{{$pixel->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button></center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <!-- pixel modal -->

        <div id="login-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="pull-right" id="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <h3><center>Add your pixel</center></h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('savepixel')}}" method="post">
                        <div class="form-group" id="store-modal">
                            <label for="email">Select network:</label>
                            <select name="provider_code" class="form-control" required>
                                @foreach($defaultPixels as $provider_code => $provider)
                                    <option value="{{$provider_code}}">{{$provider}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Pixel name:</label>
                            <input type="text" class="form-control" name="pixel_name" id="add-pixel-name" placeholder="Enter pixel name" required onblur="checkPixelName(this.value, 'Add')">
                        </div>
                        <div class="form-group">
                            <label for="pwd" id="script-id">Pixel id:</label>
                            <input type="text" class="form-control" name="pixel_id" id="add-pixel-id" placeholder="Enter pixel id" required onblur="checkPixelId(this.value, 'Add')">
                            <textarea class="form-control" name="custom_pixel_script" id="add-custom-script" placeholder="Enter your custom script" rows="6" style="resize: none; display: none;"></textarea>
                        </div>
                        <div class="custom-script-position" style="display: none;">
                            <div class="form-group">
                                <label for="">Script's Position:</label>
                                </br>
                                <input type="radio" name="script_position" id="header-pixel-script" value="0" checked> Header
                                <input type="radio" name="script_position" id="footer-pixel-script" value="1"> Footer
                            </div>
                        </div>
                        <input type="submit" name="login" class="btn btn-primary form-control" value="Save">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="pull-right" id="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <h3><center>Edit your pixel</center></h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('editpixel')}}" method="post">
                        <div class="form-group" id="edit-modal">
                            <label for="email">Network:</label>
                            <input name="provider_name" id="edit-pixel-provider" class="form-control" disabled>
                            <input type="hidden" name="edit_id" id="edit_pixel_id">
                            <input type="hidden" name="provider_name" id="edit-pixel-provider-val" class="form-control">
                            <input type="hidden" name="provider_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Pixel name:</label>
                            <input type="text" class="form-control" name="pixel_name" id="edit-pixel-name" placeholder="Enter pixel name" required onblur="checkPixelName(this.value, 'Edit')">
                        </div>
                        <div class="form-group" id="edit-custom-id-div">
                            <label for="pwd">Pixel id:</label>
                            <input type="text" class="form-control" name="pixel_id" id="edit-pixel-id" placeholder="Enter pixel id" onblur="checkPixelId(this.value, 'Edit')">
                        </div>
                        <div class="form-group" id="edit-custom-script-div">
                            <label for="pwd">Pixel Script:</label>
                            <textarea class="form-control" name="custom_pixel_script" id="edit-custom-script" placeholder="Enter your custom script" rows="6" style="resize: none;"></textarea>
                        </div>
                        <div class="custom-script-position-edt" style="display: none;">
                            <div class="form-group">
                                <label for="">Script's Position:</label>
                                </br>
                                <input type="radio" name="script_position" id="header-pixel-script-edt" value="0" checked> Header
                                <input type="radio" name="script_position" id="footer-pixel-script-edt" value="1"> Footer
                            </div>
                        </div>
                        <input type="submit" name="login" class="login loginmodal-submit" value="Save">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="id" id="pxlid" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('contents/footer')
<script>
    $(document).ready(function(){
        $('#create-zapier-key').on('click', function () {
            var zapier_key=$('#zapier_key').val();
            $.ajax({
                type:"POST",
                url:"{{ route('createZapierKey') }}",
                data: { _token:'{{csrf_token()}}'},
                success:function(response){
                    //console.log(response);
                    if(response.code==200){
                        $('#create-zapier-key-block').hide();
                        $('#zapier_key').val(response.api_key);
                        $('#zapier_key_show').show();
                        swal({
                            title: "Success",
                            text: "Zapier Key Generated Successfully!",
                            type: "success",
                        }); 
                    }else{
                        swal({
                            title: "Error",
                            text: "Try Again!",
                            type: "error",
                        }); 
                    }
                }
            });
        });

       $('#redirect_type_one').on('click', function(){
            var redirectTypeZeroCheck =  $('#redirect_type_zero').prop('checked');
            if (redirectTypeZeroCheck==true) {
                $("#redirection_time_div").hide();
                $('#redirect_type_zero').prop('checked', false);
            }else{
                $("#redirection_time_div").show();
                $('#redirect_type_zero').prop('checked', true);
            }
       });

        $('#redirect_type_zero').on('click', function(){
            $("#redirection_time_div").show();
            $("#default_redirection_time").val("5");
            var redirectTypeOneCheck =  $('#redirect_type_one').prop('checked');
            if (redirectTypeOneCheck==true) {
                $('#redirect_type_one').prop('checked', false);
                $('#default_redirection_time').prop('disabled', false);
            } else {
                $('#default_redirection_time').prop('disabled', false);
                $('#redirect_type_one').prop('checked', true);
                $("#redirection_time_div").hide();
            }
        });
        /* Edit pixel script */
        $('.pixel-edit-btn').on('click',function() {
            var id = $(this).data('id');
            var pixelName = $('#pixel-row-'+id).find('td:eq(0)').text();
            var pixelProvider = $('#pixel-row-'+id).find('td:eq(1)').text().trim();
            var pixelIdOrScript = $('#pixel-row-'+id).find('td:eq(2)').text().trim();
            var scriptPos = $('#pixel-row-'+id).find('td:eq(3)').text();
            $('#edit-modal').modal('show');
            $('#edit_pixel_id').val(id);
            $('#edit-pixel-provider').val(pixelProvider);
            $('#edit-pixel-provider-val').val(pixelProvider);
            $('#edit-pixel-name').val(pixelName);
            if(pixelProvider=='Custom') {
                $('#edit-custom-id-div').hide();
                $('#edit-pixel-id').prop('required', false);
                $('#edit-pixel-id').val('');
                $('#edit-custom-script-div').show();
                $('#edit-custom-script').val(pixelIdOrScript);
                $('.custom-script-position-edt').show();
                $('#edit-custom-script').prop('required', true);
            } else {
                $('#edit-custom-id-div').show();
                $('#edit-pixel-id').prop('required', true);
                $('#edit-pixel-id').val(pixelIdOrScript);
                $('#edit-custom-script-div').hide();
                $('#edit-custom-script').val('');
                $('#edit-custom-script').prop('required', false);
            }
        });
        /* Delete pixel script */
        $('.pixel-delete-btn').on('click', function(){
            var id = $(this).data('id');
            swal({
                    title: "Are you sure you want to delete this pixel?",
                    text: "Once deleted you will not be able to recover this!\nThis pixel may be used by some shortlinks.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                    $.post("{{route('deletepixel')}}", {
                        'id': id,
                        '_token': "{{csrf_token()}}"
                    },
                    function(data, status, xhr){
                        if(xhr.status==200)
                        {
                            var jsonData = JSON.parse(data);
                            if(jsonData.status==200)
                            {
                                if(jsonData.row>0)
                                {
                                    $('#pixel-row-'+jsonData.row).hide(200);
                                    swal("Success!", "You have successfully deleted the pixel!", "success");
                                }
                            }
                            else
                            {
                                swal("Oops!", jsonData.message, "warning");
                            }
                        }
                    });
                });
        });

        $('#pixel-table').DataTable();
    });
</script>
<script>
    // toggle textarea for custom pixel for adding
    $('#store-modal select').on('change', function(){
        var pixelNetwork = $(this).val();
        if(pixelNetwork=='CS') {
            $('#add-pixel-id').hide();
            $('#add-pixel-id').prop('required', false);
            $('#add-pixel-id').val('');
            $('#add-custom-script').show();
            $('#add-custom-script').prop('required', true);
            $('.custom-script-position').show();
            $('#script-id').text('Pixel Script:');
        } else {
            $('#add-pixel-id').show();
            $('#add-pixel-id').prop('required', true);
            $('#add-custom-script').hide();
            $('#add-custom-script').val('');
            $('#header-pixel-script').prop('checked', true);
            $('#footer-pixel-script').prop('checked', false);
            $('#add-custom-script').prop('required', false);
            $('.custom-script-position').hide();
            $('#script-id').text('Pixel Id:');
        }
    });

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
    /* Image Validation */
    $('#default_image').change(function(){
        var fileName = $('#default_image').val().split('\\').pop();
        var extension = fileName.substr( (fileName.lastIndexOf('.') +1) ).toLowerCase();
        var allowedExt = new Array("jpg","png","gif");
        if ($.inArray(extension,allowedExt) > -1) {
            $('#imageError').hide();
        } else {
            $('#imageError').show();
        }
    });
    /* Function for image validation */
    function profileValidate() {
        if ($('#redirect_type_zero').prop('checked')==true){
            var fileName = $('#default_image').val().split('\\').pop();
            if (fileName != '') {
                var extension = fileName.substr( (fileName.lastIndexOf('.') +1) ).toLowerCase();
                var allowedExt = new Array("jpg","png","gif");
                if ($.inArray(extension,allowedExt) > -1) {
                    $('#imageError').hide();
                } else {
                    $('#imageError').show();
                    swal({
                            type: 'warning',
                            title: 'Invalid Image format',
                            text: 'Please select an image with jpg png or gif file format'
                        });
                        return false;
                }
            }
        } else {
            return true;
        }
    }
    /* Check the pixel name is already exist or not */
    function checkPixelName(name, type) {
        var id = $("#edit_pixel_id").val();
        if (name.length>0) {
            $.post('{{route('pixelnames')}}', {
                'name': name,
                'type': type,
                'id': id,
                '_token': "{{csrf_token()}}"
            }, function(data, status, xhr){
                var jsonData = JSON.parse(data);
                if (jsonData.status!=200) {
                    $('#add-pixel-name').val('');
                    $('#edit-pixel-name').val('');
                    swal('Name already given, please give another name');
                }
            })
        }
    }

    /* Check the pixel id is already exist or not */
    function checkPixelId(id, type) {
        if(id.length>0) {
            $.post('{{route('pixelids')}}', {
                'id': id,
                'type': type,
                '_token': "{{csrf_token()}}"
            }, function(data, status, xhr){
                var jsonData = JSON.parse(data);
                if(jsonData.status!=200)
                {
                    $('#add-pixel-id').val('');
                    $('#edit-pixel-id').val('');
                    swal('ID already given, please give another name');
                }
            })
        }
    }
</script>
@stop