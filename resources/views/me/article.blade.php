
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-3 mt-5">Article Information</h1>
            <div class="card py-3 green-border-top">
                <div class="card-body">

                    @if ($errors->any())
                      <div class="alert alert-danger" >
                          <strong>Whoops!</strong> There were some problems with your input.<br><br>
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            
                         </button>
                      </div>
                    @endif
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150px">Title</th>
                                    <td>{{$data->title}}</td>
                                </tr>
                                <tr>
                                    <th>Abstract</th>
                                    <td>{{$data->abstract}}</td>
                                </tr>
                                <tr>
                                    <th>Authors</th>
                                    <td>
                                        @foreach ($data->authors as $value)
                                            <span class="nice">
                                                {{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}
                                                @if( !$loop->last)
                                                ,
                                                @endif
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keywords</th>
                                    <td>
                                        @foreach ($data->keywords as $value)
                                            <span class="nice">
                                                {{ $value->keyword}}@if( !$loop->last), @endif
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>
                                        <a href="{{route('me.download-file', [$data->id,'cover_letter','t'=>date('YmdHis')])}}" target="_blank">
                                            <button class="btn btn-primary">View Cover Letter</button>
                                        </a>
                                        <a href="{{route('me.download-file', [$data->id,'signed_author_agreement','t'=>date('YmdHis')])}}" target="_blank">
                                            <button class="btn btn-primary">View Signed authors’ agreement form</button>
                                        </a>
                                        <a href="{{route('me.download-file', [$data->id,'article','t'=>date('YmdHis')])}}" target="_blank">
                                            <button class="btn btn-primary">Download Article</button>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Status: </h5>
                                    <h3><strong>{{$data->status}}</strong></h3>
                                    Date Submitted:<br/>
                                    <strong> {{date('d-m-Y', strtotime($data->created_at))}}</strong>
                                </div>
         
                            </div>
                            @forelse($data->editor_in_chief_decisions as $decisions)
                                @if($decisions->reviewed_file === $data->file)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5>Decision: </h5>
                                        <h4><strong>{{$decisions->decision}}</strong></h4>
                                        Comment:<br/>
                                        {{ $decisions->comment }}
                                    </div>
                                </div>
                                @endif
                            @empty
                                @forelse($data->subject_matter_editor_recommendations as $recommendations)
                                    @if($recommendations->reviewed_file === $data->file)
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <h5>Recommendation: </h5>
                                            <h4><strong>{{$recommendations->recommendation}}</strong></h4>
                                            Comment:<br/>
                                            {{ $recommendations->comment }}
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                @endforelse
                            @endforelse
                            <div class="dropdown mt-3">
                                        <button 
                                            class="btn btn-primary dropdown-toggle btn-block" 
                                            type="button" id="dropdownMenuButton" 
                                            data-toggle="dropdown" 
                                            aria-haspopup="true" 
                                            aria-expanded="false"
                                            
                                        >
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" id="update_file_menu" data-toggle="modal" data-target="#exampleModal">Update Article File</a>
                                            <a class="dropdown-item" href="#" id="forwardSMEBtn"  data-toggle="modal" data-target="#forwardSMEModal">Forward to SME</a>    
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#forwardEICModal">Forward to EIC</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#notifyModal">Notify Author</a>
                                            
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of article information -->
    <!-- reviewer -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card green-border-top">
                <div class="card-body">
                    <h1 class="mt-5">Reviewer</h1>
                    
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addReviewerModal" data-backdrop="static" data-keyboard="false">Add Reviewer</button>
                    <table class="table table-bordered">
                        <tr>
                            <th>Reviewer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($data->reviewers as $value)
                            <tr>
                                <td>
                                    <strong>{{ $value->title }} {{ $value->first_name}} {{ $value->middle_name}} {{ $value->last_name }}</strong><br/>
                                    {{ $value->email}}<br/>
                                    Institution: {{ $value->institution }}<br/>
                                    Office Contact No.: {{ $value->office_contact_no}}<br/>
                                    Mobile No.: {{ $value->mobile_no}}
                                </td>
                                <td>
                                    <strong>{{ $value->status}}</strong><br/> 
                                    {{ date('d-m-Y', strtotime($value->updated_at)) }}
                                </td>
                                <td>
                                    @if($value->status === '-')
                                        <button 
                                            class="btn btn-primary mb-3 float-right reviewerInvitationBtn" 
                                            data-toggle="modal" 
                                            data-target="#SendReviewerInvitationModal" 
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            data-id="{{ $value->id }}"
                                            data-title="{{ $data->title }}"
                                            data-name="{{ $value->title }} {{ $value->first_name}} {{ $value->last_name }}"
                                        >
                                            Send Invitation
                                        </button>
                                    @elseif($value->status === 'Review Submitted')
                                        @foreach($value->reviewer_recommendations as $index => $recommendation)
                        

                                        <button 
                                            class="btn btn-primary mb-3 float-right viewRecommendationBtn" 
                                            data-toggle="modal" 
                                            data-target="#recommendationSubmitModal" 
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            data-id="{{ $recommendation->id }}"
                                            data-q1="{{ $recommendation->q1 }}"
                                            data-q2="{{ $recommendation->q2 }}"
                                            data-q3="{{ $recommendation->q3 }}"
                                            data-q4="{{ $recommendation->q4 }}"
                                            data-q5="{{ $recommendation->q5 }}"
                                            data-q6="{{ $recommendation->q6 }}"
                                            data-q7="{{ $recommendation->q7 }}"
                                            data-q8="{{ $recommendation->q8 }}"
                                            data-q9="{{ $recommendation->q9 }}"
                                            data-q10="{{ $recommendation->q10 }}"
                                            data-q11="{{ $recommendation->q11 }}"
                                            data-q12="{{ $recommendation->q12 }}"
                                            data-recommendation="{{ $recommendation->recommendation }}"
                                            data-markup_document="{{ $recommendation->markup_document }}"
                                            data-recommendation_file="{{ $recommendation->recommendation_file }}"
                                        >
                                            View Recommendation
                                        </button>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end of reviewer -->
</div>


<!-- modal -->
<form action="{{ route('me.update-file') }}" id="updateFile" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Article File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Article Document</label>
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="file" class="form-control required" data-label="Article document"  accept=".docx,application/msword" name="file" id="upload_file">
                <div class="input-feedback"> </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>
<form action="{{ route('me.notify') }}" id="notifyAuthor" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="notifyModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Notify the Author</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Subject</label>
                <input type="text" class="form-control" name="subject" value="Manuscript: {{ $data->manuscript_reference_no }} has an update">
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Message</label>
                <input type="hidden" name="id" value="{{ $data->id }}">
                <textarea name="body" id="notificationArea">{{ $template }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>
<form action="{{ route('me.add-reviewer') }}" id="reviewerAdd" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="addReviewerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Reviewer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">E-mail</label>
                <input type="text" name="email" class="required form-control validEmail" data-label="E-mail" autocomplete="off" placeholder="E-mail" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">First Name</label>
                <input type="hidden" name="article_id" value="{{ $data->id }}">
                <input type="text" name="first_name" class="required form-control" data-label="First Name" autocomplete="off" placeholder="First Name" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Middle Name</label>
                <input type="text" name="middle_name" class=" form-control" data-label="Middle"placeholder="Middle Name" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Last Name</label>
                <input type="text" name="last_name" class="required form-control" data-label="Last Name"placeholder="Last Name" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Institution</label>
                <input type="text" name="institution" class="form-control" data-label="Institution"placeholder="Institution" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Mobile No.</label>
                <input type="text" name="mobile_no" class="required form-control" data-label="Mobile No."placeholder="Mobile No." autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Office Contact No.</label>
                <input type="text" name="office_contact_no" class="required form-control" data-label="Office Contact No."placeholder="Office Contact No." autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>
<form action="{{ route('me.send-invitation') }}" id="SendReviewerInvitationForm" method="post" >
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="SendReviewerInvitationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Send Invitation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <input type="hidden" name="id" id="reviewer_id">
                Are you sure you want to send this invitation?
                <div class="input-feedback"> </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Confirm</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>
<form action="{{ route('me.forward-sme') }}" id="forwardSMEForm" method="post" >
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="forwardSMEModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Forward to SME</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <select id="SMEUsersSelect" name="temp_user_owner" class="form-control"></select>
                <div class="input-feedback"> </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Forward</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>

<form action="{{ route('me.forward-eic') }}" id="forwardEICForm" method="post" >
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="forwardEICModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Forward to EIC</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <input type="hidden" name="id" value="{{ $data->id }}">
                Are you sure you want to forward this to the EIC?
                <div class="input-feedback"> </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Confirm</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>



<!-- reviewer submitted recommendation -->
<div class="modal fade" tabindex="-1" role="dialog" id="recommendationSubmitModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Recommendation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <h5 style="font-weight:bold;">Assessment</h5>
        <div class="form-group md-form">
                <label for="exampleInputName1">1. Are the results new and original?</label>
                <div id="q1"></div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">2. Is the title of the article clear and reflect the article’s content?</label>
                <p id="q2"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">3. Is the abstract an adequate summary of the paper?</label>
                <p id="q3"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">4. Are the keywords suitably selected?</label>
                <p id="q4"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">5. Is the introduction clear and well organized?</label>
                <p id="q6"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">6. Are the methods comprehensively described? Did the authors include proper references to previously published methodology?</label>
                <p id="q6"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">7. What is your comment/s on the results and discussion? Are data and its interpretations shown logically and precisely?</label>
                <p id="q7"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">8. Are the conclusions firmly based on the observations or reasoning given? </label>
                <p id="q8"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">9. Is the list of references, tables, and figures complete? Does it match the citations in the article?</label>
                <p id="q9"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">10. If you think the work merits publication, is the presentation the most efficient possible and appropriate for the journal?  </label>
                <p id="q10"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">11. Is the use of language satisfactory?</label>
                <p id="q11"></p>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">12. Other specific suggestions to improve the overall quality of the paper?</label>
                <p id="q12"></p>
            </div>
            <h5 style="font-weight:bold;">Recommendation:</h5>
            <div class="form-group md-form">
                <p id="recommendation"></p>
            </div>
            <div>
                <h5 style="font-weight:bold;">Markup Document</h5>
                <div class="form-group md-form">
                    <p id="markup_document"></p>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
    CKEDITOR.replace( 'notificationArea', {
     height: 600
    } );
    setTimeout(function() {
        $(".alert").hide()
    }, 10000);
    $('#addReviewerModal').on('hidden.bs.modal', function() {
        var $validation = $('#reviewerAdd');
        $validation[0].reset();
        $validation.find('.is-invalid').removeClass('is-invalid');
        $validation.find('.is-valid').removeClass('is-valid');
    });
    
    
 })
 $(document).on("click",".reviewerInvitationBtn",function(){
    $("#reviewer_id").val($(this).data('id'))
 })
 $(document).on("click","#forwardSMEBtn",function(){
    
    $.getJSON( "{{route('sme.users')}}", function( data ) {
        console.log(data)
        $.each(data, function (i, item) {
            $('#SMEUsersSelect').append($('<option>', { 
                value: item.id,
                text : `${item.first_name} ${item.last_name}`
            }));
            $("#SMEUsersSelect").val($("#SMEUsersSelect option:first").val());
        });
        
    });
 })
 $(document).on("click",".viewRecommendationBtn",function(){
    $("#recommendationSubmitModal #q1").text($(this).data('q1'))
    $("#recommendationSubmitModal #q2").text($(this).data('q2'))
    $("#recommendationSubmitModal #q3").text($(this).data('q3'))
    $("#recommendationSubmitModal #q4").text($(this).data('q4'))
    $("#recommendationSubmitModal #q5").text($(this).data('q5'))
    $("#recommendationSubmitModal #q6").text($(this).data('q6'))
    $("#recommendationSubmitModal #q7").text($(this).data('q7'))
    $("#recommendationSubmitModal #q8").text($(this).data('q8'))
    $("#recommendationSubmitModal #q9").text($(this).data('q9'))
    $("#recommendationSubmitModal #q10").text($(this).data('q10'))
    $("#recommendationSubmitModal #q11").text($(this).data('q11'))
    $("#recommendationSubmitModal #q12").text($(this).data('q12'))
    $("#recommendationSubmitModal #recommendation").text($(this).data('recommendation'))
    // $("#recommendationSubmitModal  #markup_document").text($(this).data('markup_document'))
    if($(this).data('markup_document')){
        $("#recommendationSubmitModal  #markup_document").html(`<a href="{{route('me.download-file', [$data->id,'markup_document','t'=>date('YmdHis')])}}" id="markup_link" target="_blank">
            Markup Document
        </a>`)
        const new_url = $('#markup_link').attr("href")+"&id="+$(this).data('id')
        $('#markup_link').attr('href', new_url);
    }
 })
 



function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
let err_message = "";

$(document).on("change keyup focusout","#updateFile :input",function(){
  if($(this).hasClass("required")){
			if($(this).attr('type')=='checkbox'){
				if(!$(this).prop('checked')){
                    $(this).addClass("is-invalid")
					err_message += `<li>${$(this).data("label")} is required</li>`
          $(this).closest(".input-feedback").addClass("invalid-feedback").append(`<li>${$(this).data("label")} is required</li>`)
					result = false
				}else{
              $(this).removeClass("is-invalid")
                    // $(this).addClass("is-valid")
        }
			}else{
          if($(this).val() !== null && $(this).val() === ""){
                $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`Please Provide a valid ${$(this).data("label")}`)
				        err_message += `<li>Please Provide a valid ${$(this).data("label")}</li>`
				        result =  false
                }else{
                    $(this).removeClass("is-invalid")
                    $(this).addClass("is-valid")
                    
                }
            }
	
		}
		if($(this).hasClass("validEmail")){
			if(!isValidEmailAddress($(this).val())){
        $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
				result = false
				err_message += `<li>${$(this).data("label")} is not valid</li>`
			}
		}
})
$(document).on("change keyup focusout","#reviewerAdd :input",function(){

  if($(this).hasClass("required")){
			if($(this).attr('type')=='checkbox'){
				if(!$(this).prop('checked')){
                    $(this).addClass("is-invalid")
					err_message += `<li>${$(this).data("label")} is required</li>`
          $(this).closest(".input-feedback").addClass("invalid-feedback").append(`<li>${$(this).data("label")} is required</li>`)
					result = false
				}else{
              $(this).removeClass("is-invalid")
                    // $(this).addClass("is-valid")
        }
			}else{
          if($(this).val() !== null && $(this).val() === ""){
                $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`Please Provide a valid ${$(this).data("label")}`)
				        err_message += `<li>Please Provide a valid ${$(this).data("label")}</li>`
				        result =  false
                }else{
                    $(this).removeClass("is-invalid")
                    $(this).addClass("is-valid")
                    
                }
            }
	
		}
		if($(this).hasClass("validEmail")){
			if(!isValidEmailAddress($(this).val())){
        $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
				result = false
				err_message += `<li>${$(this).data("label")} is not valid</li>`
			}
		}
})

$(document).on("submit","#reviewerAdd",function(e){
    validation = formValidation("reviewerAdd");
    if(!validation)
    e.preventDefault()
})

$(document).on("submit","#updateFile",function(e){
    validation = formValidation("updateFile");
    if(!validation)
    e.preventDefault()
})





function formValidation(form){
 
	err_message = ""
	let result = true

	$(`#${form} :input`).each(function(){
		if($(this).hasClass("required")){
			if($(this).attr('type')=='checkbox'){
				if(!$(this).prop('checked')){
                    $(this).addClass("is-invalid")
					err_message += `<li>${$(this).data("label")} is required</li>`
          $(this).closest(".input-feedback").addClass("invalid-feedback").append(`<li>${$(this).data("label")} is required</li>`)
					result = false
				}else{
              $(this).removeClass("is-invalid")
                    // $(this).addClass("is-valid")
        }
			}else{
          if($(this).val() !== null && $(this).val() === ""){
                $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`Please Provide a valid ${$(this).data("label")}`)
				        err_message += `<li>Please Provide a valid ${$(this).data("label")}</li>`
				        result =  false
                }else{
                    $(this).removeClass("is-invalid")
                    $(this).addClass("is-valid")
                    
                }
            }
	
		}
		if($(this).hasClass("validEmail")){
			if(!isValidEmailAddress($(this).val())){
        $(this).removeClass("is-valid")
                $(this).addClass("is-invalid")
				result = false
				err_message += `<li>${$(this).data("label")} is not valid</li>`
			}
		}
	});
	return result;
}




</script>
@endsection