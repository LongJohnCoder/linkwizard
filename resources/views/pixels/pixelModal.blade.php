<div class="modal fade bs-modal-md" id="subdomainModal" tabindex="-1" role="dialog" aria-labelledby="subdomainModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="subdomainModalLabel">
                    Create Your Own Brand Link
                </h4>
            </div>
            <div class="modal-body" id="subdomainModalBody">
                <p>
                    You may want to customize url like following:
                </p>
                <ul class="list-unstyled">
                    <li>yourbrand.tr5.io/abcdef (as a subdomain)</li>
                    <li>tr5.io/yourbrand/abcdef (as a subdirectory)</li>
                </ul>
                <p id="subdomainWarning" style="color:#CC3300; display: none;">
                    <strong>Warning:</strong> Brand name can not be changed later. This action will not be undone!
                </p>
                <form class="form" id="subdomainForm" role="form" action="{{ route('postBrandLink') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="url_id" value="{{ $url->id }}" id="urlId" />
                    <div class="form-group">
                        <label for="subdomainBrand"></label>
                        <input type="text" name="name" id="subdomainBrand" class="form-control" placeholder="Enter your brand name here" />
                        <br>
                        <span id='subdomainAlert'></span>
                    </div>
                    <div class="form-group">
                        <label for="">I want a</label>
                        <input type="radio" id="subdomainRadio" name="type" value="subdomain" /> Subdomain
                        <input type="radio" id="subdirectoryRadio" name="type" value="subdirectory" /> Subdirectory
                        <br>
                        <span id="subdomainRadioAlert"><span>
                    </div>
                    <hr />
                    <button type="submit" id="subdomainFormBtn" class="btn btn-default btn-md pull-right">Submit</button>
                </form>
                <br />
                <script>
                    /*[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?*/
                    var evaluateSubdomainNames = function () {
                      nameRegex = new RegExp('^([a-zA-Z0-9][a-zA-Z0-9-_]*\.)*[a-zA-Z0-9]*[a-zA-Z0-9-_]*[[a-zA-Z0-9]+$');//new RegExp('^([a-z\d]){2,}$');
                      nameInput = $("#subdomainBrand").val();
                      var checkedType = 'subdomain/subdirectory';

                      if($("#subdomainRadio").prop('checked')) {
                        checkedType = "subdomain";
                      } else if($("#subdirectoryRadio").prop('checked')) {
                        checkedType = "subdirectory";
                      }

                      if (nameInput == null || nameInput.length == 0) {
                          return {msg : checkedType+" should not be blank!", status : false};
                      } else if (!nameRegex.test(nameInput)) {
                          return {msg : checkedType+" does not comply with our subdomain standards!", status : false};
                      } else {
                          return {msg : "No issues!", status : true};
                      }
                    }
                    $(document).ready(function () {

                        $(':radio').on('change',function(){
                          console.log('hit here');
                          if($("#subdomainRadio").prop('checked')) {
                            $("#subdomainRadioAlert").empty();
                          }
                          if($("#subdirectoryRadio").prop('checked')) {
                            $("#subdirectoryRadioAlert").empty();
                          }
                        })

                        $("#subdomainFormBtn").on('click',function(e){
                          console.log('here1');
                          e.preventDefault();
                          console.log('here2');
                          var res = evaluateSubdomainNames();
                          console.log('here3');
                          if(!res.status) {
                            $(this).focus();
                            $("#subdomainAlert").empty();
                            $("#subdomainAlert").text(res.msg).css("color",'red');
                            return false;
                          } else {
                            $("#subdomainAlert").empty();
                          }

                          if($("#subdomainRadio").prop('checked') || $("#subdirectoryRadio").prop('checked')) {
                            console.log('either one is checked');
                          } else {
                            console.log('either one is not checked');
                            $("#subdomainRadioAlert").text("Please select a subdomain or subdirectory").css("color",'red');
                            return false;
                          }

                          return $("#subdomainForm").submit();
                        });

                        $('#subdomainBrand').on('blur', function () {
                            var res = evaluateSubdomainNames();
                            if(!res.status) {
                              $(this).focus();
                              $("#subdomainAlert").empty();
                              $("#subdomainAlert").text(res.msg).css("color",'red');
                              if($("#subdomainRadio").prop('checked') || $("#subdirectoryRadio").prop('checked')) {
                                $("#subdomainRadioAlert").empty();
                              }
                              return false;
                            } else {
                              $("#subdomainAlert").empty();
                              return true;
                            }
                        });
                        $('#subdomainBrand').on('focus', function () {
                            $('#subdomainAlert').remove('#subAlert');
                            $('#subdomainWarning').css('display', 'block');
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-lg in" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="subdomainModalLabel">
                    Manage Redirecting Page Template For Your Custom Url
                </h4>
            </div>
            <div class="modal-body" id="uploadModalBody">
                <form class="form" role="form" action="{{ route('postBrandLogo') }}" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="url_id" id="urlId1" />
                    <div class="form-group">
                        <label for="brandLogo">Upload brand logo</label>
                        <input type="file" id="brandLogo1" name="brandLogo" class="form-control input-md" value="" />
                    </div>
                    <div class="form-group">
                        <label for="redirectingTime">Set redirecting time (in seconds)</label>
                        <input type="number" min="1" max="30" id="redirectingTime" name="redirectingTime" class="form-control input-md" value="" />
                    </div>
                    <div class="form-group">
                        <label for="redirectingTextTemplate">Set redirecting text template</label>
                        <textarea id="redirectingTextTemplate" name="redirectingTextTemplate" class="form-control input-md"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default btn-md pull-right">
                        Submit
                    </button>
                </form>
                <br />
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-sm in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body" id="editModalBody">
                <form class="form-inline" method="post">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="urlTitle">Title</label>
                            <input type="text" name="title" placeholder="Your URL Title" class="form-control input-mg" id="urlTitle" style="width: 80%" value="" />
                            <button type="button" class="btn btn-warning" id="editUrlTitle">
                                Edit
                            </button>
                            <input type="hidden" name="id" id="urlId" value="" />
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary btn-sm" data-dismiss="modal">Close </button>
            </div>
        </div>
    </div>
</div>
