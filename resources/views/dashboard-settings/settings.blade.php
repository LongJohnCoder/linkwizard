@extends('layout/layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container" style="padding: 20px 0px 20px 0px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#zapier">Zapier</a></li>
                </ul>

                <div class="tab-content">
                    <div id="zapier" class="tab-pane fade in active">
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
            </div>
        </section>
    </div>
    <script type="text/javascript">
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
                            $('#lebelforzapiertoken').html("Zapier Token");
                            $('#create-zapier-key').hide();
                            $('#zapier_key').html(response.api_key);
                            $('#zapier_key').show();
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

            $('#save-redirect-time').on('click', function () {
                var btn_value=$('#save-redirect-time').html();
                if(btn_value=="Edit"){
                    $('#save-redirect-time').html("Save");
                    $('#redirect_time').removeAttr('readonly').focus();
                }else{
                    var redirection_time=$('#redirect_time').val();
                    $.ajax({
                        type:"POST",
                        url:"{{ route('modifyDefaultRedirectTime') }}",
                        data: { redirection_time:redirection_time,_token:'{{csrf_token()}}'},
                        success:function(response){
                            //console.log(response);
                            if(response.code==200){
                                $('#redirect_time').val(response.redirection_time). attr("readonly", "true");
                                $('#save-redirect-time').html("Edit");
                                swal({
                                    title: "Success",
                                    text: "Default Redirection Url Saved!",
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
                }
            });
        });
    </script>
@stop