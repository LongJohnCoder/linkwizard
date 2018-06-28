<!DOCTYPE html>

<!-- head of th page -->
<html lang="en">
@include('pixels.pixel_head')

<style>
    .redirection-link-box a{
        padding-right: 5px;
    }
    .tags li {
        float: left;
    }

    /****** LOGIN MODAL ******/
    .loginmodal-container {
        padding: 30px;
        max-width: 550px;
        width: 100% !important;
        background-color: #F7F7F7;
        margin: 0 auto;
        border-radius: 2px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        font-family: Arial, Helvetica, sans-serif;
    }

    .loginmodal-container h1 {
        text-align: center;
        font-size: 1.8em;
        font-family: Arial, Helvetica, sans-serif;
    }

    .loginmodal-container input[type=submit] {
        width: 100%;
        display: block;
        margin-bottom: 10px;
        position: relative;
    }

    .loginmodal-container input[type=text], input[type=password], select {
        height: 44px;
        font-size: 16px;
        width: 100%;
        margin-bottom: 10px;
        -webkit-appearance: none;
        background: #fff;
        border: 1px solid #d9d9d9;
        border-top: 1px solid #c0c0c0;
        /* border-radius: 2px; */
        padding: 0 8px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .loginmodal-container input[type=text]:hover, input[type=password], select:hover {
        border: 1px solid #b9b9b9;
        border-top: 1px solid #a0a0a0;
        -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }

    .loginmodal {
        text-align: center;
        font-size: 14px;
        font-family: 'Arial', sans-serif;
        font-weight: 700;
        height: 36px;
        padding: 0 8px;
        /* border-radius: 3px; */
        /* -webkit-user-select: none;
          user-select: none; */
    }

    .loginmodal-submit {
        /* border: 1px solid #3079ed; */
        border: 0px;
        color: #fff;
        text-shadow: 0 1px rgba(0,0,0,0.1);
        background-color: #4d90fe;
        padding: 17px 0px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
    }

    .loginmodal-submit:hover {
        /* border: 1px solid #2f5bb7; */
        border: 0px;
        text-shadow: 0 1px rgba(0,0,0,0.3);
        background-color: #357ae8;
        /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
    }

    .loginmodal-container a {
        text-decoration: none;
        color: #666;
        font-weight: 400;
        text-align: center;
        display: inline-block;
        opacity: 0.6;
        transition: opacity ease 0.5s;
    }

    .login-help{
        font-size: 12px;
    }

    .panel-heading{
        color: #ffffff!important;
    }
    .pixel-table th{
        background-color: #e0e7f3;
        color: #777777;
        font-size: 16px;
        text-align: center;
    }
    .action-btn{
        background-color: #f2f5fa;
        border: 1px solid #cccccc;
        border-radius: 15px;
        color: #444444;
        transition: 0.2s;
    }
    .action-btn:hover{
        color: #ffffff;
        background-color: #337ab7;
        transition: 0.2s;
        /*box-shadow: 2px 2px 2px #999999;*/
    }
</style>
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
<!-- Header End -->

@if(session()->has('msg'))
    @if(session()->get('msg')=='success')
        <script>
            swal({
                title: "Success!",
                text: "Pixel has been successfully added",
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
    @elseif(session()->get('msg')=='editsuccess')
        <script>
            swal({
                title: "Success!",
                text: "Pixel has been successfully edited",
                icon: "success",
                button: "OK",
            });
        </script>
    @elseif(session()->get('msg')=='editerror')
        <script>
            swal({
                title: "Error!",
                text: "Something went wrong during the edit process, please try again",
                icon: "warning",
                button: "OK",
            });
        </script>
    @endif
@endif


{{--@include('pixels.pixelModal')--}}

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
                            <div class="panel-heading"><h4>Manage Your Pixels</h4></div>
                            <div class="panel-body">
                                <div class="text-center">
                                    @if(count($userPixels)==0)
                                        <p>You have not added any Pixel yet, click on the below button to get started!</p>
                                        <button class="btn btn-xs btn-primary" id="manage-pixel-btn" data-toggle="modal" data-target="#login-modal"><i class="fa fa-plus-square"></i> Add pixel</button>
                                    @elseif(count($userPixels)>0)
                                        <sapn class="pull-left">
                                            <button class="btn btn-xs btn-primary" id="manage-pixel-btn" data-toggle="modal" data-target="#login-modal"><i class="fa fa-plus-square"></i> New pixel</button>
                                        </sapn>
                                        <table id="pixel-table" class="table table-hover pixel-table">
                                            <thead>
                                                <tr>
                                                    <th>Pixel Name</th>
                                                    <th>Pixel Network</th>
                                                    <th>Pixel ID</th>
                                                    <th>Created On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($userPixels as $pixel)
                                                    <tr id="pixel-row-{{$pixel->id}}">
                                                        <td>{{$pixel->pixel_name}}</td>
                                                        <td>
                                                            @if($pixel->network=='gl_pixel_id')
                                                                <i class="fa fa-google"></i> Google
                                                            @elseif($pixel->network=='fb_pixel_id')
                                                                <i class="fa fa-facebook"></i> Facebook
                                                            @elseif($pixel->network=='twt_pixel_id')
                                                                <i class="fa fa-twitter"></i> Twitter
                                                            @elseif($pixel->network=='li_pixel_id')
                                                                <i class="fa fa-linkedin"></i> LinkedIn
                                                            @elseif($pixel->network=='pinterest_pixel_id')
                                                                <i class="fa fa-pinterest"></i> Pinterest
                                                            @elseif($pixel->network=='quora_pixel_id')
                                                                <i class="fa fa-code"></i> Quora
                                                            @elseif($pixel->network=='custom_pixel_id')
                                                                <i class="fa fa-code"></i> Custom
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($pixel->pixel_id))
                                                                {{$pixel->pixel_id}}
                                                            @else
                                                                {{$pixel->custom_pixel_script}}
                                                            @endif
                                                        </td>
                                                        <td>{{$pixel->created_at->diffForHumans()}}</td>
                                                        <td>
                                                            <button class="action-btn pixel-edit-btn" href="javascript:void(0);" data-id="{{$pixel->id}}" id="pixel-edit-btn-{{$pixel->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button class="action-btn pixel-delete-btn" href="javascript:void(0);" data-id="{{$pixel->id}}" id="pixel-delete-btn-{{$pixel->id}}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
            </div>

        </div>
    </div>
</div>


<!-- pixel modal -->

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h3><center>Add your pixel</center></h3><br>
            <form action="{{route('savepixel')}}" method="post">
                <div class="form-group" id="store-modal">
                    <label for="email">Select network:</label>
                    <select name="network" required>
                        <option value="fb_pixel_id">Facebook</option>
                        <option value="twt_pixel_id">Twitter</option>
                        <option value="li_pixel_id">LinkedIn</option>
                        <!-- DO NOT DELETE -->
                        <!--<option value="pinterest_pixel_id">Pinterest</option>
                        <option value="quora_pixel_id">Quora</option>-->
                        <option value="gl_pixel_id">Google</option>
                        <option value="custom_pixel_id">Custom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pwd">Pixel name:</label>
                    <input type="text" class="form-control" name="pixel_name" id="add-pixel-name" placeholder="Enter pixel name" required onblur="checkPixelName(this.value, 'Add')">
                </div>
                <div class="form-group">
                    <label for="pwd">Pixel id:</label>
                    <input type="text" class="form-control" name="pixel_id" id="add-pixel-id" placeholder="Enter pixel id" required onblur="checkPixelId(this.value, 'Add')">
                    <textarea class="form-control" name="custom_pixel_script" id="add-custom-script" placeholder="Enter your custom script" rows="6" style="resize: none; display: none;"></textarea>
                </div>
                <input type="submit" name="login" class="login loginmodal-submit" value="Save">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>
    </div>
</div>

<!-- Edit pixel modal -->

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h3><center>Edit your pixel</center></h3><br>
            <form action="{{route('editpixel')}}" method="post">
                <div class="form-group" id="edit-modal">
                    <label for="email">Select network:</label>
                    <select name="network" id="edit-pixel-network" required>
                        <option value="fb_pixel_id">Facebook</option>
                        <option value="twt_pixel_id">Twitter</option>
                        <option value="li_pixel_id">LinkedIn</option>
                        <!-- DO NOT DELETE -->
                        <!--<option value="pinterest_pixel_id">Pinterest</option>-->
                        <!--<option value="quora_pixel_id">Quora</option>-->
                        <option value="gl_pixel_id">Google</option>
                        <option value="custom_pixel_id">Custom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pwd">Pixel name:</label>
                    <input type="text" class="form-control" name="pixel_name" id="edit-pixel-name" placeholder="Enter pixel name" required onblur="checkPixelName(this.value, 'Edit')">
                </div>
                <div class="form-group">
                    <label for="pwd">Pixel id:</label>

                    <input type="text" class="form-control" name="pixel_id" id="edit-pixel-id" placeholder="Enter pixel id" onblur="checkPixelId(this.value, 'Edit')">
                    <textarea class="form-control" name="custom_pixel_script" id="edit-custom-script" placeholder="Enter your custom script" rows="6" style="resize: none;"></textarea>

                </div>
                <input type="submit" name="login" class="login loginmodal-submit" value="Save">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="id" id="pxlid" value="">
            </form>
        </div>
    </div>
</div>



@include('contents/footer')

<script>
    $(function(){
        $('.redirection-link-box').mouseover(function(){
            $('.copy-btn').show();
        });
        $('.redirection-link-box').mouseout(function(){
            $('.copy-btn').hide();
        });

        $('.redirect-urls').mouseover(function(){
            var cpId = $(this).data('id');
            $('#cp-btn-'+cpId).show();
        });

        $('.redirect-urls').mouseout(function(){
            var cpId = $(this).data('id');
            $('#cp-btn-'+cpId).hide();
        });

        $('#prev-btn').on('click', function(){
            var icon = $('#caret-icon i').prop('class');
            if(icon=='fa fa-caret-up')
            {
                $('#caret-icon i').prop('class', 'fa fa-caret-down');
            }else
            {
                $('#caret-icon i').prop('class', 'fa fa-caret-up');
            }
        });

        $('.pixel-edit-btn').on('click', function(){
            var id = $(this).data('id');
            var pixelName = $('#pixel-row-'+id).find('td:eq(0)').text();
            var pixelNetwork = $('#pixel-row-'+id).find('td:eq(1)').text();
            var pixelId = $('#pixel-row-'+id).find('td:eq(2)').text();
            pixelId = pixelId.trim();
            pixelNetwork = pixelNetwork.trim();
            var actualNetwork;

            if(pixelNetwork=='Google')
            {
                actualNetwork = 'gl_pixel_id';
            }
            else if(pixelNetwork=='Facebbok')
            {
                actualNetwork = 'fb_pixel_id';
            }
            else if(pixelNetwork=='Twitter')
            {
                actualNetwork = 'twt_pixel_id';
            }
            else if(pixelNetwork=='LinkedIn')
            {
                actualNetwork = 'li_pixel_id';
            }
            else if(pixelNetwork=='Pinterest')
            {
                actualNetwork = 'pinterest_pixel_id';
            }
            else if(pixelNetwork=='Quora')
            {
                actualNetwork = 'quora_pixel_id';
            }
            else if(pixelNetwork=='Custom')
            {
                actualNetwork = 'custom_pixel_id';
            }

            $('#edit-pixel-name').val(pixelName);
            if(pixelNetwork!='Custom')
            {
                $('#edit-pixel-id').val(pixelId);
                $('#edit-pixel-id').show();
                $('#edit-pixel-id').prop('required', true);

                $('#edit-custom-script').val('');
                $('#edit-custom-script').hide();
            }
            else if(pixelNetwork=='Custom')
            {
                $('#edit-custom-script').val(pixelId);
                $('#edit-custom-script').show();
                $('#edit-custom-script').prop('required', true);

                $('#edit-pixel-id').val('');
                $('#edit-pixel-id').hide();
            }
            $('#pxlid').val(id);
            $('#edit-pixel-network').find('option').each(function(index){
                var elementNetwork = $(this).val();
                if(elementNetwork==actualNetwork)
                {
                    $(this).prop('selected','selected');
                    return false;
                }
            });
            $('#edit-modal').modal('show');
        });

        $('.pixel-delete-btn').on('click', function(){
            var id = $(this).data('id');
            swal({
                    title: "Are you sure you want to delete this pixel?",
                    text: "Once deleted you will not be able to recover this!",
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

        // toggle textarea for custom pixel for adding
        $('#store-modal select').on('change', function(){
            var network = $(this).val();
            if(network=='custom_pixel_id')
            {
                $('#add-pixel-id').hide();
                $('#add-pixel-id').prop('required', false);
                $('#add-pixel-id').val('');
                $('#add-custom-script').show();
                $('#add-custom-script').prop('required', true);
            }
            else
            {
                $('#add-pixel-id').show();
                $('#add-pixel-id').prop('required', true);
                $('#add-custom-script').hide();
                $('#add-custom-script').val('');
                $('#add-custom-script').prop('required', false);
            }
        });

        // toggle textarea for custom pixel for editing
        $('#edit-modal select').on('change', function(){
            var network = $(this).val();
            if(network=='custom_pixel_id')
            {
                $('#edit-pixel-id').hide();
                $('#edit-pixel-id').prop('required', false);
                $('#edit-pixel-id').val('');
                $('#edit-custom-script').show();
                $('#edit-custom-script').prop('required', true);
            }
            else
            {
                $('#edit-pixel-id').show();
                $('#edit-pixel-id').prop('required', true);
                $('#edit-custom-script').hide();
                $('#edit-custom-script').val('');
                $('#edit-custom-script').prop('required', false);
            }
        });

    });


    // function copyUrl(id)
    // {
    //     var temp = $("<input>");
    //     $("body").append(temp);
    //     var data = $('#url-'+id).prop('href');
    //     data = data.trim();
    //     temp.val(data).select();
    //     document.execCommand("copy");
    //     temp.remove();
    //     var node = document.getElementById('url-'+id);
    //     if (document.body.createTextRange) {
    //         const range = document.body.createTextRange();
    //         range.moveToElementText(node);
    //         range.select();
    //     } else if (window.getSelection) {
    //         const selection = window.getSelection();
    //         const range = document.createRange();
    //         range.selectNodeContents(node);
    //         selection.removeAllRanges();
    //         selection.addRange(range);
    //     } else {
    //         console.warn("Could not select text in node: Unsupported browser.");
    //     }
    // }
</script>

<script>
    function checkPixelName(name, type)
    {
        if(name.length>0)
        {
            $.post('{{route('pixelnames')}}', {
                'name': name,
                '_token': "{{csrf_token()}}"
            }, function(data, status, xhr){
                var jsonData = JSON.parse(data);
                if(jsonData.status!=200)
                {
                    if(type=='Add')
                    {
                        $('#add-pixel-name').val('');
                        swal('Name already given, please give another name');
                    }
                    else if(type=='Edit')
                    {
                        $('#edit-pixel-name').val('');
                        swal('Name already given, please give another name');
                    }
                }
            })
        }
    }

    function checkPixelId(id, type)
    {
        if(id.length>0)
        {
            $.post('{{route('pixelnames')}}', {
                'id': name,
                '_token': "{{csrf_token()}}"
            }, function(data, status, xhr){
                var jsonData = JSON.parse(data);
                if(jsonData.status!=200)
                {
                    if(type=='Add')
                    {
                        $('#add-pixel-id').val('');
                        swal('ID already given, please give another name');
                    }
                    else if(type=='Edit')
                    {
                        $('#edit-pixel-id').val('');
                        swal('ID already given, please give another name');
                    }
                }
            })
        }
    }
</script>

<!-- ManyChat -->
<script src="//widget.manychat.com/216100302459827.js" async="async"></script>

{{-- script for summernote js --}}
<script>
    $(document).ready(function () {


        function initSummernote(preloadText) {
            $('#redirectingTextTemplate').summernote({
                height: 100,
                minHeight: null,
                maxHeight: null,
                focus: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['insert', ['link']],
                    ['misc', ['undo', 'redo', 'codeview']]
                ]
            });
            $('#redirectingTextTemplate').summernote('code', preloadText);
        }

        $('#clipboard').on('click', function () {
            new Clipboard('#clipboard');
        });




    });


    function editAction() {
        $('#editUrlTitle').on('click', function () {
            var id = $('.modal-body #urlId').val();
            var title = $('.modal-body #urlTitle').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('postEditUrlInfo') }}",
                data: {id: id, title: title, _token: "{{ csrf_token() }}"},
                success: function(response) {
                    console.log('postEditUrlInfo');
                    $('#myModal').modal('hide');
                    swal({
                        title: "Success",
                        text: "Successfully edited title",
                        type: "success",
                        html: true
                    });
                    $('#urlTitleHeading').replaceWith('<h1 id="urlTitleHeading">'+response.url.title+'</div>');
                    $('#tab-title').replaceWith('<span id="tab-title" class="title">'+response.url.title+'</span>');
                    $(".modal-body #urlTitle").val(response.url.title);
                },
                error: function(response) {
                    swal({
                        title: "Oops!",
                        text: "Cannot edit this title",
                        type: "warning",
                        html: true
                    });
                }
            });
        });
    }

</script>




<script type="text/javascript">

    var appURL = "{{url('/')}}";
    appURL = appURL.replace('https://','');
    appURL = appURL.replace('http://','');

    console.log('appURL : ',appURL);

    // var giveMyTags = function() {
    // 	$.ajax({
    // 		type 	:	"POST",
    // 		url		:	"{{route('giveMyTags')}}",
    // 		data	: {_token:'{{csrf_token()}}'},
    // 		success : function(res) {
    // 			console.log(res);
    // 			var tagsArray = [];
    // 			for(var i = 0 ; i < res.data.length ; i ++) {
    // 				var ob = {tag : res.data[i]};
    // 				console.log('each ob : ',ob);
    // 				tagsArray.push(ob);
    // 			}
    // 			console.log('final tags : ',tagsArray);
    // 			$('#shortTagsContentss').selectize({
    // 				maxItems: null,
    // 				valueField: 'tag',
    // 				labelField: 'tag',
    // 				searchField: 'tag',
    // 				options: tagsArray,
    // 				create: true
    // 			});
    // 		},
    // 		error : function(res) {
    // 			console.log(res);
    // 		}
    // 	});
    // }

    window.onload = function(){
        console.log('reached here');
        //giveMyTags();
    }

    // var $select = $('#shortTagsContentss').selectize({
    // 				maxItems: null,
    // 				valueField: 'tag',
    // 				labelField: 'tag',
    // 				searchField: 'tag',
    // 				options: [
    // 					{tag: 'tag1'},{tag:'tag2'},{tag:'tag3'}
    // 				],
    // 				create: true
    // 			});

    var maintainSidebar = function(thisInstance) {
        //facebook analytics checkbox for short urls
        if (thisInstance.id === "checkboxAddFbPixelid" && thisInstance["name"] === "chk_fb_short") {
            if(thisInstance.checked) {
                $('#fbPixelid').show();
            } else {
                $('#fbPixelid').hide();
                $('#fbPixelid').val('');
            }
        }

        //facebook analytics checkbox for custom urls
        if (thisInstance.id === "checkboxAddFbPixelid1" && thisInstance["name"] === "chk_fb_custom") {
            if(thisInstance.checked) {
                $('#fbPixelid1').show();
            } else {
                $('#fbPixelid1').hide();
                $('#fbPixelid1').val('');
            }
        }

        //google analytics checkbox for short urls
        if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
            if(thisInstance.checked) {
                $('#glPixelid').show();
            } else {
                $('#glPixelid').hide();
                $('#glPixelid').val('');
            }
        }

        //google analytics checkbox for custom urls
        if (thisInstance.id === "checkboxAddGlPixelid1" && thisInstance["name"] === "chk_gl_custom") {
            if(thisInstance.checked) {

                $('#glPixelid1').show();
            } else {
                $('#glPixelid1').hide();
                $('#glPixelid1').val('');
            }
        }

        //addtags for short urls
        if (thisInstance.id === "shortTagsEnable" && thisInstance["name"] === "shortTagsEnable") {
            if(thisInstance.checked) {
                $('#shortTagsArea').show();
            } else {
                $('#shortTagsArea').hide();
                $("#shortTagsContents").tagsinput('removeAll');
            }
        }

        //addtags for custom urls
        if (thisInstance.id === "customTagsEnable" && thisInstance["name"] === "customTagsEnable") {
            if(thisInstance.checked) {
                $('#customTagsArea').show();
            } else {
                $('#customTagsArea').hide();
                $("#customTagsContents").tagsinput('removeAll');
            }
        }

        //add short descriptions for short urls
        if (thisInstance.id === "shortDescriptionEnable" && thisInstance["name"] === "shortDescriptionEnable") {
            if(thisInstance.checked) {
                $('#shortDescriptionContents').show();
            } else {
                $('#shortDescriptionContents').hide();
                $('#shortDescriptionContents').val('');
            }
        }

        //add short descriptions for short urls
        if (thisInstance.id === "customDescriptionEnable" && thisInstance["name"] === "customDescriptionEnable") {
            if(thisInstance.checked) {
                $('#customDescriptionContents').show();
            } else {
                $('#customDescriptionContents').hide();
                $('#customDescriptionContents').val('');
            }
        }
    }

    $(document).ready(function() {

        // $('#dashboard-tags-to-search').on('beforeItemAdd', function(event) {
        // 	var string = $(this).text();
        // 	$(this).html(string.replace(/,/g , ''));
        //   // event.item: contains the item
        //   // event.cancel: set to true to prevent the item getting added
        // });

        $("#dashboard-search-btn").on('click',function() {
            console.log('came here : submitting form');
            var data = $("#dashboard-search-form").serialize();
            $("#dashboard-search-form").submit();
        });

        // $("#dashboard-search-form").on('submit',function(e){
        // 	console.log('form submit handler called');
        // 	e.preventDefault();
        // });

        $("#dashboard-search").on('click',function() {
            var tags = $("#dashboard-tags-to-search").tagsinput('items');
            var text = $("#dashboard-text-to-search").val();
            console.log('tags :',tags,' text: ',text);
        });

        // $('.shortTagsContents').tagsinput({
        //   	allowDuplicates: false,
        // 		maxChars: 20,
        //     // itemValue: 'id',  // this will be used to set id of tag
        //     // itemText: 'label' // this will be used to set text of tag
        // });
        // $('.customTagsContents').tagsinput({
        //   	allowDuplicates: false,
        // 		maxChars: 20,
        //     // itemValue: 'id',  // this will be used to set id of tag
        //     // itemText: 'label' // this will be used to set text of tag
        // });
        // $('.dashboard-tags-to-search').tagsinput({
        //   	allowDuplicates: false,
        // 		maxChars: 20,
        // 		maxTags: 3
        //     // itemValue: 'id',  // this will be used to set id of tag
        //     // itemText: 'label' // this will be used to set text of tag
        // });


        $(":checkbox").on("change", function() {
            maintainSidebar(this);
        });



        // $('#checkboxAddGlPixelid1, input[type="checkbox"]').on('click', function(){
        // 	if($(this).prop("checked") == true){
        // 			$('#glPixelid1').show();
        //   }
        //   else if($(this).prop("checked") == false){
        // 			$('#glPixelid1').hide();
        // 			$('#glPixelid1').val('');
        //   }
        // });
        //
        // $('#checkboxAddFbPixelid1, input[type="checkbox"]').on('click', function(){
        // 	if($(this).prop("checked") == true){
        // 			$('#fbPixelid1').show();
        //   }
        //   else if($(this).prop("checked") == false){
        // 			$('#fbPixelid1').hide();
        // 			$('#fbPixelid1').val('');
        //   }
        // });

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

        $('[data-toggle="tooltip"]').tooltip();
        $('#hamburger').on('click', function () {
            $('.sidebar.right').addClass('open', true);
            $('.sidebar.right').removeClass('close', true);
        });
        $('#cross').on('click', function () {
            $('.sidebar.right').toggleClass('close', true);
            $('.sidebar.right').removeClass('open', true);
        });
        $('#tr5link').on('click', function () {
            $('.tr5link').addClass('open', true);
            $('.tr5link').removeClass('close', true);
        });

        $('#customLink').on('click', function () {
            $('.sharebar').addClass('open', true);
            $('.sharebar').removeClass('close', true);
        });
        $('#cross2').on('click', function () {
            $('.sharebar').addClass('close', true);
            $('.sharebar').removeClass('open', true);
        });
        $('#noTr5Link').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });
        $('#noCustomLink').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });


    });
</script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>

<script type="text/javascript">
    $(document).ready(function(){


        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $(".list-group ul li").click(function(){
            $(this).addClass("active");
            $(".list-group ul li").not($(this)).removeClass("active");
            $(window).scrollTop(500);
            var index = $(this).index();
            $("div.tab-content").removeClass("active");
            $("div.tab-content").eq(index).addClass("active");
        });
    });
</script>


<script>
    $(document).ready(function () {
        var options = {
            theme:"custom",
            content:'<img style="width:80px;" src="{{ URL::to('/').'/public/resources/img/company_logo.png' }}" class="center-block">',
            message:"Please wait a while",
            backgroundColor:"#212230"
        };
        $('#swalbtn1').click(function(){

            var actualUrl = $('#givenActualUrl').val();
            var customUrl = $('#makeCustomUrl').val();
                    @if (Auth::user())
            var userId = {{ Auth::user()->id }};
                    @else
            var userId = 0;
                    @endif

            var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid1").prop('checked');
            var fbPixelid							= 	$("#fbPixelid1").val();
            var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid1").prop('checked');
            var glPixelid							= 	$("#glPixelid1").val();
            var allowTag							=   $("#customTagsEnable").prop('checked');
            var tags 									= 	$("#customTagsContents").tagsinput('items');
            var allowDescription      = 	$("#customDescriptionEnable").prop('checked');
            var searchDescription			= 	$("#customDescriptionContents").val();

            $.ajax({
                type:"POST",
                url:"/check_custom",
                data: {custom_url: customUrl , _token:'{{csrf_token()}}'},
                success:function(response){
                    console.log('check_custom');
                    console.log(response);
                    if(response == 1)
                    {
                        console.log(response);
                        if (ValidURL(actualUrl))
                        {
                            if (ValidCustomURL(customUrl))
                            {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('postCustomUrlTier5') }}",
                                    data: {
                                        checkboxAddFbPixelid 	: checkboxAddFbPixelid,
                                        fbPixelid							: fbPixelid,
                                        checkboxAddGlPixelid 	: checkboxAddGlPixelid,
                                        glPixelid 						: glPixelid,
                                        actual_url						: actualUrl,
                                        custom_url						: customUrl,
                                        user_id								: userId,
                                        allowTag							: allowTag,
                                        tags									: tags,
                                        allowDescription			: allowDescription,
                                        searchDescription			: searchDescription,
                                        _token: "{{ csrf_token() }}"
                                    }, success: function (response) {
                                        console.log('postCustomUrlTier5');
                                        if(response.status=="success") {
                                            var shortenUrl = response.url;
                                            var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
                                            swal({
                                                title: "Shorten Url:",
                                                text: displayHtml,
                                                type: "success",
                                                html: true
                                            }, function() {
                                                window.location.reload();
                                            });
                                            new Clipboard('#clipboardswal');
                                            $('#clipboardswal').on('click', function () {
                                                window.location.reload();
                                            });
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
                                    }, error: function(response) {
                                        console.log('Response error!');
                                        HoldOn.close();
                                    }, statusCode: {
                                        500: function() {
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
                            }
                            else
                            {
                                swal({
                                    type: "warning",
                                    title: null,
                                    text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
                                    html: true
                                });
                            }
                        }
                        else
                        {
                            swal({
                                type: "warning",
                                title: null,
                                text: "Please Enter An URL"
                            });
                        }
                    }
                    else
                    {
                        $("#err_cust").show();
                        //url already used by this user
                    }

                }
            });
        });



        function ValidURL(str) {

            if(str.indexOf("http://") == 0) {
                return true;
            } else if(str.indexOf("https://") == 0) {
                return true;
            } else {
                return false;
            }

            // var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
            // var url = str;
            // if (!regexp.test(url)) {
            //     return false;
            // } else {
            //     return true;
            // }
        }

        function ValidCustomURL(str) {
            var regexp = new RegExp("^[a-zA-Z0-9_]+$");
            var url = str;
            if (!regexp.test(url)) {
                return false;
            } else {
                return true;
            }
        }

        $('#swalbtn').click(function() {
            var url = $('#givenUrl').val();
            var validUrl = ValidURL(url);
                    @if (Auth::user())
            var userId = {{ Auth::user()->id }};
                    @else
            var userId = 0;
                    @endif

            var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid").prop('checked');
            var fbPixelid							= 	$("#fbPixelid").val();
            var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid").prop('checked');
            var glPixelid							= 	$("#glPixelid").val();
            var allowTag							=   $("#shortTagsEnable").prop('checked');
            var tags 									= 	$("#shortTagsContents").tagsinput('items');
            var allowDescription      = 	$("#shortDescriptionEnable").prop('checked');
            var searchDescription			= 	$("#shortDescriptionContents").val();

            if(url) {
                if(validUrl) {
                    HoldOn.open(options);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('postShortUrlTier5') }}",
                        data: {
                            url										: url,
                            user_id								: userId,
                            checkboxAddFbPixelid 	: checkboxAddFbPixelid,
                            fbPixelid 						: fbPixelid,
                            checkboxAddGlPixelid 	: checkboxAddGlPixelid,
                            glPixelid 						: glPixelid,
                            allowTag							: allowTag,
                            tags									: tags,
                            allowDescription			: allowDescription,
                            searchDescription			: searchDescription,
                            _token: "{{ csrf_token() }}"},
                        success: function (response) {
                            console.log('postShortUrlTier5');
                            if(response.status=="success") {
                                var shortenUrl = response.url;
                                var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
                                swal({
                                    title: "Shorten Url:",
                                    text: displayHtml,
                                    type: "success",
                                    html: true
                                }, function() {
                                    window.location.reload();
                                });
                                new Clipboard('#clipboardswal');
                                $('#clipboardswal').on('click', function () {
                                    window.location.reload();
                                });
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
                        }, error: function(response) {
                            console.log('Response error!');
                            HoldOn.close();
                        }, statusCode: {
                            500: function() {
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
                    var errorMsg="Enter A Valid URL";
                    swal({
                        title: null,
                        text: errorMsg,
                        type: "error",
                        html: true
                    });
                }
            } else {
                var errorMsg="Please Enter An URL";
                swal({
                    title: null,
                    text: errorMsg,
                    type: "warning",
                    html: true
                });
            }
        });

    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
    });
</script>




</body>
</html>
