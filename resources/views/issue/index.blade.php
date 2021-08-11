
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">My Submitted Articles</div> -->
                
                <div class="card-body">
                <h1>Issues</h1>
                    @if ($errors->any())
                      <div class="alert alert-danger" >
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <button class="btn btn-primary mb-3 mt-5 float-right" data-toggle="modal" data-target="#addIssueModal" data-backdrop="static" >Add Issue</button>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Cover Image</th>
                                <th>Volume</th>
                                <th>Issue No.</th>
                                <th>Year</th>
                                <th>Date Published</th>
                                <th width="200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data) && $data->count())
                                @foreach($data as $key => $value)
                                    <tr>
                                    
                                        <td>
                            
                                            <a href="{{url('/cover_image/'.$value->cover_image)}}" data-toggle="lightbox">
                                                <img src="{{url('/cover_image/'.$value->cover_image)}}" class="img-fluid" width="120px">
                                            </a>
            
                                        </td>
                                        <td>{{ $value->volume }}</td>
                                        <td>{{ $value->issue_no }}</td>
                                        <td>{{ $value->year }}</td>
                                        <td>{{ $value->date_published }}</td>
                                        <td>
                                            <a href="{{ route('issue.show',$value->id) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                            <button 
                                                class="btn btn-success btnUpdateIssue" 
                                                data-toggle="modal"
                                                 data-target="#updateIssueModal" 
                                                 data-backdrop="static"
                                                 data-id="{{ $value->id }}"
                                                 data-issue_no="{{ $value->issue_no }}"
                                                 data-volume="{{ $value->volume }}"
                                                 data-year="{{ $value->year }}"
                                                 data-date_published="{{ $value->date_published }}"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                                                                        <button 
                                                class="btn btn-danger btnDeleteIssue" 
                                                data-toggle="modal"
                                                 data-target="#deleteIssueModal" 
                                                 data-backdrop="static"
                                                 data-id="{{ $value->id }}"
                                                 data-url="{{route('issue.delete',$value->id)}}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
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

<form action="{{ route('issue.insert') }}" id="addIssueForm" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="addIssueModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Issue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Volume</label>
                <input type="text" class="form-control required" data-label="Volume" name="volume">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Issue No.</label>
                <input type="text" class="form-control required" data-label="Issue No" name="issue_no">
                <div class="input-feedback"> </div>
            </div>

            <div class="form-group md-form">
                <label for="exampleInputName1">Year</label>
                <input type="number" class="form-control required" data-label="Year" name="year">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Date Published</label>
                <input type="date" class="form-control required" data-label="Date Published" name="date_published">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Cover</label>
                <input type="file" class="form-control required" data-label="Cover" name="cover_image" accept="image/png, image/gif, image/jpeg">
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
<form action="{{ route('issue.update') }}" id="updateIssueForm" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PUT') }}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateIssueModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Issue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Volume</label>
                <input type="hidden" class="form-control required" data-label="id" name="id" id="update_id">
                <input type="text" class="form-control required" data-label="Volume" name="volume" id="update_volume">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Issue No.</label>
                <input type="text" class="form-control required" data-label="Issue No" name="issue_no" id="update_issue_no">
                <div class="input-feedback"> </div>
            </div>

            <div class="form-group md-form">
                <label for="exampleInputName1">Year</label>
                <input type="number" class="form-control required" data-label="Year" name="year" id="update_year">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Date Published</label>
                <input type="date" class="form-control required" data-label="Date Published" name="date_published" id="update_date_published">
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Cover</label>
                <input type="file" class="form-control required" data-label="Cover" name="cover_image" accept="image/png, image/gif, image/jpeg">
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

<form action="{{ route('issue.delete','3') }}" id="deleteIssueForm" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('DELETE') }}
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteIssueModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Issue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Volume</label>
                <input type="hidden" class="form-control required" data-label="id" name="id" id="delete_id">
                Are you sure want to delete this item?
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


<div class="backdrop"></div>
<div class="box">
  <div style="height:40px;">
  <div class="close">x</div>
  </div>

  <div style="height:600px;">
  <img src="" id="imgBox" style="height:100%; display: block;
  margin-left: auto;
  margin-right: auto;">
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $('.backdrop').animate({'opacity':'.50'}, 300, 'linear').css('display', 'block');
            $("#imgBox").attr("src",$(this).attr('href'))
            $('.box').fadeIn();
        });
        $('.close, .backdrop').click(function(){
            $('.backdrop').animate({'opacity':'0'}, 300, 'linear', function(){
                $('.backdrop').css('display', 'none');
            });
            $('.box').fadeOut();
        });
    });
    $(document).on('click', '.btnUpdateIssue', function (event) {
        $("#update_id").val($(this).data('id'))
        $("#update_issue_no").val($(this).data('issue_no'))
        $("#update_volume").val($(this).data('volume'))
        $("#update_year").val($(this).data('year'))
        $("#update_date_published").val($(this).data('date_published'))
    });
    $(document).on('click', '.btnDeleteIssue', function (event) {
        $("#delete_id").val($(this).data('id'))
        $("#deleteIssueForm").attr("action",$(this).data('url'))
    });
    
    
</script>

@endsection