
@extends('layouts.app')
@section('style')
<link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mt-5 mb-3">Submit Article</h1>
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
                <div id="stepper4" class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step active" data-target="#test-vl-1">
                            <button type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="test-vl-1" aria-selected="true">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Submission Guidelines</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step" data-target="#test-vl-2">
                            <button type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Details</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step" data-target="#test-vl-3">
                            <button type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-2" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Co-authors</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step" data-target="#test-vl-4">
                            <button type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-2" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Keywords</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#test-vl-5">
                                <button type="button" class="step-trigger" role="tab" id="stepper4trigger5" aria-controls="test-vl-3" aria-selected="false" disabled="disabled">
                                    <span class="bs-stepper-circle">5</span>
                                    <span class="bs-stepper-label">Validate</span>
                                </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                      <form class="needs-validation" action="{{ route('author.submit') }}" id="journal_submission_form" method="post" enctype="multipart/form-data">
                      @csrf
                          <div id="test-vl-1" role="tabpanel" class="bs-stepper-pane fade active dstepper-block" aria-labelledby="stepper4trigger1">
                            <p class="card-description">Read the guideline and check the box at the bottom of the page to confirm you will comply with these guidelines.</p> 
                            <hr/>
                            <p><strong>TYPES OF ARTICLES</strong><br />
            Articles must be original, unpublished, not more than 25 pages long (including the abstract, tables,figures, maps, and appendices), and not submitted to other publications for consideration. We accept the<br />
            following types of articles:<br />
            Research articles should deal with recent findings and data that offer original, innovative, and scientific results relevant to sustainable development; and present new knowledge on systems and how it relates to the society, the economy, and the environment, and its potential application.<br />
            Policy development articles must present insights into well?researched and validated development and policy experiences exploring technological aspects in the tropical forest ecosystems and natural resources environment context; findings of practice?oriented research aimed at coping with development challenges and are embedded in national and international policy debates; must cite key documents; and explore the development of ecosystems.<br />
            Research notes refer to submitted articles with important findings and require immediate publication but cannot be considered as a journal article.</p>

            <p><br />
            <strong>RECOMMENDED FORMAT</strong><br />
            1. Manuscripts should be processed in Microsoft Word 1993?2007 (A4 paper, double?spaced, 12?points Times New Roman) and in American English language. Articles should be submitted with the following sections:<br />
            Title &ndash; should be less than 20 words and must contain the subject and the significance or purpose of the study (to be followed by list of author/s and affiliation/s, and corresponding author&rsquo;s e?mail address) on one page.<br />
            Abstract ? not more than 250 words and a list of at most five keywords.<br />
            Introduction<br />
            Methodology &ndash; should specify the techniques used and the details of the study area, as well as the limitations of the study<br />
            Results and Discussion<br />
            Conclusion<br />
            Literature Cited<br />
            List of Figures and Tables<br />
            Acknowledgments &ndash; paragraph composed of at most three sentences<br />
            2. Manuscripts (including tables, figures, photos, maps, and appendices) should be submitted by e?mail or online submission.</p>

            <p>3. Manuscripts with multiple authors are requested to have the co?authorship agreement form signed and submitted.</p>

            <p>&nbsp;</p>

            <p><strong>OTHER DETAILS</strong><br />
            1. Use the metric system for data that require units of measure.<br />
            2. Use italic type for scientific names, local names and terms, and non?English terms.<br />
            3. Submit all figures as separate files; do not integrate them within the text.<br />
            4. Use the table functions of your word processing program, not spreadsheets, to make tables.<br />
            5. Use the equation editor of your word processing program or Math Type for equations.<br />
            6. Number the pages using the automatic numbering function.<br />
            7. Use continuous line numbering.<br />
            8. Place figure legends or tables at the end of the manuscript.<br />
            9. Use left paragraph alignment only (do not justify lines; allow the automatic line wrap to function).<br />
            10. Start all heads flush left.<br />
            11. Use 2 line spacing all throughout (do not automatically insert extra space before or after paragraphs).</p>

            <p>&nbsp;</p>

            <p><strong>CITING REFERENCES</strong><br />
            1. Authors cited in the text, figures, and table captions should be listed in the Literature Cited section.<br />
            2. Authors cited as &ldquo;et al.&rdquo; in the text should all be enumerated in the References Cited.<br />
            3. For citing bibliographic references, refer to the format guidelines here.</p>

            <p>&nbsp;</p>

            <p><strong>REVIEW PROCESS</strong><br />
            Manuscripts undergo a double?blind peer review. Effort should be made by the author to prevent his or<br />
            her identity from being known during the review process.</p>
                            <hr/>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input required" data-label="checkbox" id="materialUnchecked">
                                <label class="form-check-label" for="materialUnchecked">Check read and will comply with these guidelines.</label>
                              </div>
                            <br/>

                            <button class="btn btn-primary" onclick="stepper4.next()">Next</button>
                          </div>
                          <div id="test-vl-2" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepper4trigger2">
                            <div class="form-group md-form">
                              <label for="title" class="d-flex">Article Title</label>
                              <textarea class="form-control required md-textarea" data-label="Article title"  id="title" name="title"  ></textarea> 
                              <div class="input-feedback"> </div>
                            </div>
                            <div class="form-group md-form">
                              <label for="exampleInputName1">Abstract</label>
                              <textarea class="form-control required md-textarea" data-label="Abstract"  id="abstract" name="abstract" ></textarea> 
                              <div class="input-feedback"> </div>
                            </div>
                            <div class="form-group md-form">
                              <label for="exampleInputName1">Cover Letter</label>
                              <input type="file" class="form-control required" data-label="Cover letter"  accept="application/pdf" name="cover_letter" id="cover_letter">
                              <div class="input-feedback"> </div>
                            </div>
                            <div class="form-group md-form">
                              <label for="exampleInputName1">Signed authors’ agreement form</label>
                              <input type="file" class="form-control required" data-label="Article document"  accept="application/pdf" name="signed_author_agreement" id="signed_author_agreement">
                              <div class="input-feedback"> </div> 
                            </div>
                            <div class="form-group md-form">
                              <label for="exampleInputName1">Article Document</label>
                              <input type="file" class="form-control required" data-label="Article document"  accept=".docx,application/msword" name="file" id="upload_file">
                              <div class="input-feedback"> </div> 
                            </div>

                            <!-- <div class="custom-file" style="margin-bottom:30px;">
                              <input type="file" class="custom-file-input required" data-label="Manuscript File" accept=".docx,application/msword" id="upload_file"
                                aria-describedby="inputGroupFileAddon01" name="file">
                              <label class="custom-file-label" for="upload_file">Choose File</label>
                            </div> -->
                            
                            <button class="btn btn-primary" onclick="stepper4.previous()">Previous</button>
                            <button class="btn btn-primary" onclick="stepper4.next()">Next</button>
                          </div>
                          
                          <div id="test-vl-3" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepper4trigger3">
                            <button  class="btn btn-primary btn-fw" id="add_author_btn" style="margin-bottom:50px; margin-top: 30px; color:white;">Add Co-author</button>
                            
                            <div class="table-responsive">
                              <table class="table " id="author_table">
                                <thead style="background: #f3f3f3;"></thead>
                                <tbody></tbody>
                              </table>
                            </div>
    

                            <button class="btn btn-primary" onclick="stepper4.previous()">Previous</button>
                            <button class="btn btn-primary" onclick="stepper4.next()">Next</button>
                          </div>
                          <div id="test-vl-4" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepper4trigger4">
                            <button  class="btn btn-primary btn-fw" id="add_keyword_btn" style="margin-bottom:50px; margin-top: 30px; color:white;">Add Keyword</button>

                            <div class="table-responsive">
                              <table class="table  " id="keyword_table">
                                <thead style="background: #f3f3f3;"></thead>
                                <tbody></tbody>
                              </table>
                            </div>
    

                            <button class="btn btn-primary" onclick="stepper4.previous()">Previous</button>
                            <button class="btn btn-primary" onclick="stepper4.next()">Next</button>
                          </div>
                          <div id="test-vl-5" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepper4trigger5">

                             <h3 >Review & Submit</h3>
                                  <p class="card-description">Review the submission details below. You can submit only if all required information included.</p>
                                  <hr style="margin-bottom:50px;"/> 

                                  <h4 >Manuscript Details</h4>
                                  <div class="form-group">
                                    <label for="exampleInputName1">Manuscript Title</label>
                                    <textarea class="form-control" id="rev_title" readonly="" ></textarea> 
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputName1">Abstract</label>
                                    <textarea class="form-control" id="rev_abstract" readonly="" ></textarea> 
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Cover Letter</label>
                                    <input type="text" class="form-control" id="rev_cover_letter" readonly="" >
                                  </div>
                                  <div class="form-group">
                                    <label>Article</label>
                                    <input type="text" class="form-control" id="rev_file" readonly="" >
                                  </div>
                                  <hr style="margin-bottom:60px;"/> 
                                  <h4 >Co-Authors</h4>
                                  <input type="hidden" class="form-control required " data-label="First name" name="first_name[]" value="{{ Auth::user()->first_name }}">
                                  <input type="hidden" class="form-control required " data-label="First name" name="middle_name[]" value="{{ Auth::user()->middle_name }}">
                                  <input type="hidden" class="form-control required " data-label="First name" name="last_name[]" value="{{ Auth::user()->last_name }}">
                                  <input type="hidden" class="form-control required " data-label="First name" name="email[]" value="{{ Auth::user()->email }}">
                                  <input type="hidden" class="form-control required"   name="type[]" value="Author">
                                  <table class="table table-bordered" id="author_table_rev">
                                    <thead></thead>
                                    <tbody></tbody>
                                  </table>
                                  <hr style="margin-bottom:60px;"/> 
                                  <h4 >Keywords</h4>
                                  <table class="table table-bordered" id="keyword_table_rev">
                                    <thead></thead>
                                    <tbody></tbody>
                                  </table>
                            <button class="btn btn-primary mt-5" onclick="stepper4.previous()">Previous</button>
                            <button type="submit" id="submit_journal_btn" class="btn btn-primary mt-5">Submit</button>
                          </div>
                        </form>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script>
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
let err_message = "";

$(document).on("change keyup focusout","#journal_submission_form :input",function(){
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


function formValidation(form,scope){
	// $(`#${form} .${}`)
 
	err_message = ""
	let result = true

	$(`#${form} #${scope} :input`).each(function(){
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



var stepper4 = new Stepper($('#stepper4')[0])

$('#stepper4')[0].addEventListener('show.bs-stepper', function (event) {
  var form = $('#stepper4')[0].querySelector('.bs-stepper-content form')
  var stepperPanList = [].slice.call($('#stepper4')[0].querySelectorAll('.bs-stepper-pane'))
  // You can call preventDefault to stop the rendering of your step
  form.classList.remove('was-validated')


  var nextStep = event.detail.indexStep
  var currentStep = nextStep

  if (currentStep > 0) {
    currentStep--
  }
  
  var stepperPan = stepperPanList[currentStep]
  
  validation = formValidation("journal_submission_form",stepperPan.getAttribute('id'));
  if(validation!=true){
      event.preventDefault()
  }
  if ((stepperPan.getAttribute('id') === 'test-form-1' && !inputMailForm.value.length) ||
  (stepperPan.getAttribute('id') === 'test-form-2' && !inputPasswordForm.value.length)) {
    event.preventDefault()
    form.classList.add('was-validated')
  }
})

$(document).on("click","#add_author_btn",function(){
	const trid = Date.now();
	if( !$('#author_tbl_header').length )
	{
	    $("#author_table thead")
		.append(`
			<tr id="author_tbl_header">
				<th cope="col">First Name</th>
				<th cope="col">Middle</th>
				<th cope="col">Last Name</th>
				<th cope="col">Email</th>
				<th cope="col">Action</th>
			</tr>
		`)
	}
	$("#author_table tbody")
		.append(`
			<tr data-id="${trid}">
				<td>
					
					<div class="form-group md-form">
						<input type="text" class="form-control required first_name" id="coauth_first_name_${trid}" data-label="First name" name="first_name[]">
            <input type="hidden" class="form-control required"   name="type[]" value="Co-Author">
						<div class="input-feedback"></div>
					</div>
				</td>
				<td>
					<div class="md-form">
						<input type="text" class="form-control middle_name" id="coauth_middle_name_${trid}"  data-label="Middle Name"  name="middle_name[]">
						
					</div>
				</td>
				<td>
					<div class="form-group md-form">
						<input type="text" class="form-control required last_name" id="coauth_last_name_${trid}"  data-label="Last Name"  name="last_name[]">
						<div class="input-feedback"></div>
					</div>
				</td>
				<td>
					<div class="form-group md-form">
						<input type="text" class="form-control required validEmail last_name" id="coauth_email_name_${trid}"  data-label="Email"  name="email[]">
						<div class="input-feedback"></div>
					</div>
				</td>
				<td style="">
					<a class="text-danger delete_tr" data-toggle="tooltip" data-placement="top" title="Remove this item">
						<i class="fas fa-trash "></i>

					</a>
				</td>
			</tr>
		`)
	if( !$('#author_tbl_header_rev').length )
	{
	$("#author_table_rev thead")
		.append(`
			<tr id="author_tbl_header_rev">
				<td>First Name</td>
				<td>Middle</td>
				<td>Last Name</td>
				<td>Email</td>
			</tr>
		`)
	}	
	$("#author_table_rev tbody")
		.append(`
			<tr id="${trid}">
				<td class="first_name_rev"></td>
				<td class="middle_name_rev"></td>
				<td class="last_name_rev"></td>
				<td class="email_rev"></td>
			</tr>
		`)
})

$(document).on("click",".delete_tr",function(event){
	event.preventDefault();
	let tr = $(this).parent().parent().attr("data-id");
	$(this).parent().parent().remove();
	$("#"+tr).remove();

})


$(document).on("click","#add_keyword_btn",function(){
	const trid = Date.now();
	if( !$('#keyword_tbl_header').length )
	{
	    $("#keyword_table thead")
		.append(`
			<tr id="keyword_tbl_header">
				<th>Keyword</th>
				<th>Action</th>
			</tr>
		`)
	}
	$("#keyword_table tbody")
		.append(`
			<tr data-id='${trid}'>
				<td>
					<div class="md-form form-group">
						<input type="text" class="form-control required" id="keyword" id="keyword_inp_${trid}" data-label="Keyword"   name="keyword[]">
						<div class="input-feedback"></div>
					</div>
				
				</td>
				<td >
					<a class="text-danger delete_tr" data-toggle="tooltip" data-placement="top" title="Remove this item">
						<i class="fas fa-trash "></i>
					</a>
				</td>
			</tr>
		`)


	if( !$('#keyword_tbl_header_rev').length )
	{
	    $("#keyword_table_rev thead")
		.append(`
			<tr id="keyword_tbl_header_rev">
				<th>Keyword</th>
			</tr>
		`)
	}
	$("#keyword_table_rev tbody")
		.append(`
			<tr id='${trid}'>
				<td></td>
			</tr>
		`)	
});


// for review
$(document).on("change","#title",function(){
	$("#rev_title").val($(this).val())
})
$(document).on("change","#abstract",function(){
	$("#rev_abstract").val($(this).val())
})

$(document).on("change","#upload_file",function(e){
	const filename = $(this).val().split('\\').pop();
	$("#rev_file").val(filename);
})
$(document).on("change","#cover_letter",function(e){
	const filename = $(this).val().split('\\').pop();
	$("#rev_cover_letter").val(filename);
})


$(document).on("change","#author_table tbody input",function(e){
	const tr = $(this).closest("tr").attr("data-id");
	$("#"+tr+" td:eq( "+$(this).closest("td").index()+" )").html($(this).val());
})
$(document).on("change","#keyword_table tbody input",function(e){
	const tr = $(this).closest("tr").attr("data-id");
	$("#"+tr+" td:eq( "+$(this).closest("td").index()+" )").html($(this).val());
})
$(document).on("submit","#journal_submission_form",function(e){
  e.preventDefault();
})
$(document).on("click","#submit_journal_btn",function(e){
    $("#journal_submission_form").submit();
})

</script>
@endsection