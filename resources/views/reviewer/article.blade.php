
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
             <h1 class="mb-3 mt-5">Article Information</h1>
            <div class="card green-border-top">
                <div class="card-body">

                    @if ($errors->any())
                      <div class="alert alert-danger">
                          <strong>Whoops!</strong> There were some problems with your input.<br><br>
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                    @endif
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    
                    <div class="row py-3">
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
                                    <th>Keywords</th>
                                    <td>
                                        @foreach ($data->keywords as $value)
                                            <span class="nice">
                                                {{ $value->keyword}}@if( !$loop->last), @endif
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                                @if($data->status!="Invitation Sent" && $data->status!="Declined" && $data->file)
                                <tr>
                                    <th></th>
                                    <td>
                                        <a href="{{route('reviewer.download-file', [$data->reviewer_id,'article','t'=>date('YmdHis')])}}">
                                            <button class="btn btn-primary">Download Article</button>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        
                        <div class="col-md-3">
                   
                            <div class="card">
                                <div class="card-body">
                                    <h5>Status: </h5>
                                    @if($data->status=="Invitation Sent")
                                        <h5><strong>Awaiting for response</strong></h5>
                                    @else
                                        <h5><strong>{{$data->status}}</strong></h5>
                                    @endif
                                    
                                </div>
                            </div>
                            @if($data->status=="Invitation Sent")
                            <div class="card mt-3">
                                <div class="card-body">
                                    <strong>Respond to invitation: </strong>
                                    <a href="{{ route('reviewer.accept',$data->ref) }}">
                                        <button class="mt-3 btn btn-primary btn-block">Accept</button>
                                    </a>
                                    <a href="{{ route('reviewer.decline',$data->ref) }}">
                                    <button class="mt-3 btn btn-primary btn-block">Decline</button>
                                    </a>
                                </div>
         
                            </div>
                            @endif
                            @if($data->status=="Accepted")
                            <div class="card mt-3">
                                <div class="card-body">
                                    <strong>Review submission option: </strong>
                                        <button class="mt-3 btn btn-primary btn-block" data-toggle="modal" data-target="#recommendationModal">Submit Review</button>
                                        <button class="mt-3 btn btn-primary btn-block" data-toggle="modal" data-target="#recommendationModal">Upload Review Document</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of article information -->

</div>


<!-- modal -->
<form action="{{ route('reviewer.review',$data->reviewer_id) }}" id="updateFile" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="recommendationModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Make Recommendation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <h5 style="font-weight:bold;">Assessment</h5>
        <div class="form-group md-form">
                <label for="exampleInputName1">1. Are the results new and original?</label>
                <input type="text" name="q1" class="required form-control" data-label="to this question" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">2. Is the title of the article clear and reflect the article’s content?</label>
                <input type="hidden" name="article_id" value="{{ $data->id }}">
                <input type="hidden" name="recommendation_type" value="submit">
                <input type="text" name="q2" class="required form-control" data-label="to this question" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">3. Is the abstract an adequate summary of the paper?</label>
                <input type="text" name="q3" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">4. Are the keywords suitably selected?</label>
                <input type="text" name="q4" class="required form-control"   autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">5. Is the introduction clear and well organized?</label>
                <input type="text" name="q5" class="form-control required"   autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">6. Are the methods comprehensively described? Did the authors include proper references to previously published methodology?</label>
                <input type="text" name="q6" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">7. What is your comment/s on the results and discussion? Are data and its interpretations shown logically and precisely?</label>
                <input type="text" name="q7" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">8. Are the conclusions firmly based on the observations or reasoning given? </label>
                <input type="text" name="q8" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">9. Is the list of references, tables, and figures complete? Does it match the citations in the article?</label>
                <input type="text" name="q9" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">10. If you think the work merits publication, is the presentation the most efficient possible and appropriate for the journal?  </label>
                <input type="text" name="q10" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">11. Is the use of language satisfactory?</label>
                <input type="text" name="q11" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">12. Other specific suggestions to improve the overall quality of the paper?</label>
                <input type="text" name="q12" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <h5 style="font-weight:bold;">Recommendation:  Please check the appropriate box.</h5>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="recommendation" id="flexRadioDefault1" value="Accept for publication" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                    Accept for publication
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="recommendation" id="flexRadioDefault2"  value="Paper as presently written maybe accepted for publication after complying with the required revisions.">
                <label class="form-check-label" for="flexRadioDefault2">
                    Paper as presently written maybe accepted for publication after complying with the required revisions:
                </label>
                <div class="form-check" style="margin-left:30px;">
                    <input  class="form-check-input" type="radio" name="recommendation1" id="flexRadioDefault2" value="Need to see the revised paper before making final recommendation." >
                    <label class="form-check-label" for="flexRadioDefault2">
                        Need to see the revised paper before making final recommendation.
                    </label>
                </div>
                
                <div class="form-check" style="margin-left:30px;">
                    <input  class="form-check-input" type="radio" name="recommendation1" id="flexRadioDefault2" value="No need to see the revised paper, the EIC can decide whether to accept or reject." >
                    <label class="form-check-label" for="flexRadioDefault2">
                        No need to see the revised paper, the EIC can decide whether to accept or reject.
                    </label>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="recommendation" id="flexRadioDefault2" value="Paper should be published as a Research Note/Short Communication." >
                <label class="form-check-label" for="flexRadioDefault2">
                    Paper should be published as a Research Note/Short Communication.
                </label>
            </div>
            <div class="form-group md-form mt-3" >
                <h5 style="font-weight:bold;">Markup Document (Optional)</h5>
                <input type="file" name="markup_document" accept=".docx,application/msword" class="form-control" autocomplete="off" />
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

<form action="{{ route('reviewer.review',$data->reviewer_id) }}" id="updateFile" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="recommendationModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Make Recommendation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <h5 style="font-weight:bold;">Assessment</h5>
        <div class="form-group md-form">
                <label for="exampleInputName1">1. Are the results new and original?</label>
                <input type="text" name="q1" class="required form-control" data-label="to this question" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">2. Is the title of the article clear and reflect the article’s content?</label>
                <input type="hidden" name="article_id" value="{{ $data->id }}">
                <input type="text" name="q2" class="required form-control" data-label="to this question" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">3. Is the abstract an adequate summary of the paper?</label>
                <input type="text" name="q3" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">4. Are the keywords suitably selected?</label>
                <input type="text" name="q4" class="required form-control"   autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">5. Is the introduction clear and well organized?</label>
                <input type="text" name="q5" class="form-control required"   autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">6. Are the methods comprehensively described? Did the authors include proper references to previously published methodology?</label>
                <input type="text" name="q6" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">7. What is your comment/s on the results and discussion? Are data and its interpretations shown logically and precisely?</label>
                <input type="text" name="q7" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">8. Are the conclusions firmly based on the observations or reasoning given? </label>
                <input type="text" name="q8" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">9. Is the list of references, tables, and figures complete? Does it match the citations in the article?</label>
                <input type="text" name="q9" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">10. If you think the work merits publication, is the presentation the most efficient possible and appropriate for the journal?  </label>
                <input type="text" name="q10" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">11. Is the use of language satisfactory?</label>
                <input type="text" name="q11" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">12. Other specific suggestions to improve the overall quality of the paper?</label>
                <input type="text" name="q12" class="required form-control" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <h5 style="font-weight:bold;">Recommendation: Please check the appropriate box.</h5>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>

@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
    $('#addReviewerModal').on('hidden.bs.modal', function() {
    // alert("test")
        var $validation = $('#reviewerAdd');
        $validation[0].reset();
        $validation.find('.is-invalid').removeClass('is-invalid');
        $validation.find('.is-valid').removeClass('is-valid');
    });
    
    
 })
 $(document).on("click",".reviewerInvitationBtn",function(){
    console.log($(this).data('id'))
    $("#reviewer_id").val($(this).data('id'))
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
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`This field is required`)
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
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`This field is required`)
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
                $(this).closest(".form-group").find(".input-feedback").addClass("invalid-feedback").html(`This field is required`)
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