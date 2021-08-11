
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1 class="mt-5 mb-3">User Management</h1>
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
                    <button class="btn btn-primary mb-3 mt-3 float-right" data-toggle="modal" data-target="#insertUserModal">Add User</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job Info</th>
                                <th>Address</th>
                                <th>Contact Info</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data) && $data->count())
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $value->title }}{{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}</td>
                                        <td>
                                            <strong>Current Job Title:</strong> {{ $value->current_job_title }}<br/>
                                            <strong>Department/ Research Unit:</strong> {{ $value->department_research_unit }}<br/>
                                            <strong>Institution:</strong> {{ $value->institution }}<br/>
                                        </td>
                                        <td>@if($value->street){{ $value->street }}, @endif @if($value->town){{ $value->town }},@endif  @if($value->zip){{ $value->zip }},@endif {{ $value->country }}</td>
                                        <td><strong>E-mail:</strong> {{ $value->email }}<br/>
                                            <strong>Mobile No.:</strong> {{ $value->mobile_no }}<br/>
                                            <strong>Office Phone No.:</strong> {{ $value->contact_no }}
                                        </td>

                                        <td>
                                        @foreach ($value->roles as $role)
                                            <span class="nice">
                                                {{ $role->name }}@if( !$loop->last),
                                                @endif
                                            </span>
                                        @endforeach
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-success updateUserBtn btn-block" 
                                                data-toggle="modal" 
                                                data-target="#updateUserModal"
                                                data-id="{{ $value->id }}"
                                                data-title="{{ $value->title }}"
                                                data-first_name="{{ $value->first_name }}"
                                                data-middle_name="{{ $value->middle_name }}"
                                                data-last_name="{{ $value->last_name }}"
                                                data-current_job_title="{{ $value->current_job_title }}"
                                                data-department_research_unit="{{ $value->department_research_unit }}"
                                                data-institution="{{ $value->institution }}"
                                                data-street="{{ $value->street }}"
                                                data-town="{{ $value->town }}"
                                                data-zip="{{ $value->zip }}"
                                                data-country="{{ $value->country }}"
                                                data-email="{{ $value->email }}"
                                                data-mobile_no="{{ $value->mobile_no }}"
                                                data-contact_no="{{ $value->contact_no }}"
                                            >Update</button>
                                            <button 
                                                class="btn btn-primary assignRoleBtn btn-block" 
                                                data-toggle="modal" 
                                                data-target="#assignRoleModal"
                                                data-id="{{ $value->id }}"
                                                data-roles="@foreach ($value->roles as $role){{ $role->name }}@if(!$loop->last),@endif @endforeach"
                                            >Assign Role</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10">There are no data.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $data->links(\Request::except('page')) !!}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<form action="{{ route('admin.assign-role') }}" method="post" id="assignRole">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="assignRoleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="role_id" class="required form-control"  />
            @foreach($roles as $key => $role)
                <div class="checkbox">
                    <label><input type="checkbox" name="name[]" value="{{ $role->name }}" /> {{ $role->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</form>
<form action="{{ route('admin.add-user') }}" method="post" id="insertUserForm">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="insertUserModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New User</h5>
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
                <label for="exampleInputName1">Title</label>
                <input type="text" name="title" class="required form-control validEmail" data-label="Title" autocomplete="off" placeholder="Title" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">First Name</label>
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
                <label for="exampleInputName1">Current Job Title</label>
                <input type="text" name="current_job_title" class="required form-control" data-label="Current Job Title"placeholder="Current Job Title" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Department/Research Unit</label>
                <input type="text" name="department_research_unit" class="required form-control" data-label="Current Job Title"placeholder="Current Job Title" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Institution</label>
                <input type="text" name="institution" class="required form-control" data-label="Institution"placeholder="Institution" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Street</label>
                <input type="text" name="street" class="required form-control" data-label="Street"placeholder="Street" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Town</label>
                <input type="text" name="town" class="required form-control" data-label="Town"placeholder="Town" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Zip</label>
                <input type="text" name="zip" class="required form-control" data-label="Zip"placeholder="Zip" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Country</label>
                <input type="text" name="country" class="required form-control" data-label="Country"placeholder="Country" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Mobile No.</label>
                <input type="text" name="mobile_no" class="required form-control" data-label="Mobile No."placeholder="Mobile No." autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Office Contact No.</label>
                <input type="text" name="contact_no" class="required form-control" data-label="Office Contact No."placeholder="Office Contact No." autocomplete="off" />
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
<form action="{{ route('admin.update-user') }}" method="post" id="updateUserForm">
@csrf
@method('PUT')
    <div class="modal fade" tabindex="-1" role="dialog" id="updateUserModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">E-mail</label>
                <input type="hidden" name="id" id="update_id" class="required form-control"  />
                <input type="text" name="email" id="update_email" class="required form-control validEmail" data-label="E-mail" autocomplete="off" placeholder="E-mail" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Title</label>
                <input type="text" name="title" id="update_title" class="required form-control" data-label="Title" autocomplete="off" placeholder="Title" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">First Name</label>
                <input type="text" name="first_name" id="update_first_name" class="required form-control" data-label="First Name" autocomplete="off" placeholder="First Name" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Middle Name</label>
                <input type="text" name="middle_name" id="update_middle_name" class=" form-control" data-label="Middle"placeholder="Middle Name" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Last Name</label>
                <input type="text" name="last_name" id="update_last_name" class="required form-control" data-label="Last Name"placeholder="Last Name" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Current Job Title</label>
                <input type="text" name="current_job_title" id="update_current_job_title" class="required form-control" data-label="Current Job Title"placeholder="Current Job Title" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Department/Research Unit</label>
                <input type="text" name="department_research_unit" id="update_department_research_unit" class="required form-control" data-label="Department/Research Unit"placeholder="Department/Research Unit" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Institution</label>
                <input type="text" name="institution" class="required form-control" id="update_institution" data-label="Institution"placeholder="Institution" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Street</label>
                <input type="text" name="street" class="required form-control" id="update_street" data-label="Street"placeholder="Street" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Town</label>
                <input type="text" name="town" class="required form-control" id="update_town" data-label="Town"placeholder="Town" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Zip</label>
                <input type="text" name="zip" class="required form-control" id="update_zip" data-label="Zip"placeholder="Zip" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Country</label>
                <input type="text" name="country" id="update_country" class="required form-control" data-label="Country"placeholder="Country" autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Mobile No.</label>
                <input type="text" name="mobile_no" id="update_mobile_no" class="required form-control" data-label="Mobile No."placeholder="Mobile No." autocomplete="off" />
                <div class="input-feedback"> </div> 
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Office Contact No.</label>
                <input type="text" name="contact_no" id="update_contact_no" class="required form-control" data-label="Office Contact No."placeholder="Office Contact No." autocomplete="off" />
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


@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
    $('#insertUserModal').on('hidden.bs.modal', function() {
        var $validation = $('#insertUserForm');
        $validation[0].reset();
        $validation.find('.is-invalid').removeClass('is-invalid');
        $validation.find('.is-valid').removeClass('is-valid');
    });
    
    
 })
 $(document).on("click",".updateUserBtn",function(){
    $("#update_id").val($(this).data('id'))
    $("#update_title").val($(this).data('title'))
    $("#update_first_name").val($(this).data('first_name'))
    $("#update_middle_name").val($(this).data('middle_name'))
    $("#update_last_name").val($(this).data('last_name'))
    $("#update_current_job_title").val($(this).data('current_job_title'))
    $("#update_department_research_unit").val($(this).data('department_research_unit'))
    $("#update_institution").val($(this).data('institution'))
    $("#update_street").val($(this).data('street'))
    $("#update_town").val($(this).data('town'))
    $("#update_zip").val($(this).data('zip'))
    $("#update_country").val($(this).data('country'))
    $("#update_email").val($(this).data('email'))
    $("#update_mobile_no").val($(this).data('mobile_no'))
    $("#update_contact_no").val($(this).data('contact_no'))
 })
 $(document).on("click",".assignRoleBtn",function(){
    $("#role_id").val($(this).data('id'))
    $("#update_title").val($(this).data('title'))
    var myArr = $(this).data('roles').split(",").map(function(item) {
    return item.trim();
    });
    $("#assignRole input:checkbox").each(function(){
        if(myArr.includes($(this).val())){
            $(this).prop('checked', true);
        }else{
            $(this).prop('checked', false);
        }
    });
 })
 



function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
let err_message = "";

$(document).on("change keyup focusout","#updateUserForm :input,#insertUserModal :input",function(){
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


$(document).on("submit","#updateUserForm",function(e){
    validation = formValidation("updateUserForm");
    if(!validation)
    e.preventDefault()
})

$(document).on("submit","#insertUserForm",function(e){
    validation = formValidation("insertUserForm");
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
