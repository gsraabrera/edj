
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                        <div class="card-body">
                            <div class="row  ml-5">
                                <div class="col-md-3">
                                 <img src="{{url('/cover_image/'.$data->cover_image)}}" style="max-width:100%;">
                                </div>
                                <div class="col-md-9">
                                    <h4 class="font-weight-bold green-text mt-5" >
                                        Vol {{ $data->volume }} No {{ $data->issue_no }} {{ $data->year }}: Ecosystems and Development Journal{{ $data->name }}
                                    </h4>
                                    <h5>
                                        Date Published: {{ $data->date_published }}
                                    </h5>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="card mt-5">
                <!-- <div class="card-header">My Submitted Articles</div> -->
                
                <div class="card-body">

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



                    <button class="btn btn-primary mb-3 mt-5 float-right" data-toggle="modal" data-target="#addArticleModal" data-backdrop="static" >Add Issue</button>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th width="200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data->articles) && $data->articles->count())
                                @foreach($data->articles as $key => $value)
                                    <tr>
                                    
                                        <td>
                                            <strong>Title:</strong><br/>
                                            {{ $value->title }}<br/>

                                            <strong>Abstract:</strong><br/>
                                            {!! $value->abstract !!} 

                                            <strong>Authors:</strong>
                                            @foreach ($value->authors as $authors)
                                                <span>
                                                    {{ $authors->name}}@if( !$loop->last), @endif
                                                </span>
                                            @endforeach
                                            <br/>  

                                            <strong>keywords:</strong>
                                            @foreach ($value->keywords as $keywords)
                                                <span>
                                                    {{ $keywords->keyword}}@if( !$loop->last), @endif
                                                </span>
                                            @endforeach
                                            <br/><br/>            
                                            <a class="btn btnUpdateArticle btn-outline-primary" href="{{url('/published_articles/'.$value->file)}}" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                                PDF
                                            </a><br/> 
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-success btnUpdateArticle btn-block" 
                                                data-toggle="modal"
                                                 data-target="#updateArticleModal" 
                                                 data-backdrop="static"
                                                 data-id="{{ $value->id }}"
                                                 data-title="{{ $value->title }}"
                                                 data-abstract="{{ $value->abstract }}"
                                                 data-keywords="{{ $value->keywords }}"
                                                 data-authors="{{ $value->authors }}"
                                                 data-url="{{route('published-article.update',$value->id)}}"
                                            >
                                                <i class="fas fa-edit"></i>
                                                Edit Article
                                            </button>
                                            <button 
                                                class="btn btn-danger btnDeleteIssue btn-block" 
                                                data-toggle="modal"
                                                data-target="#deleteIssueModal" 
                                                data-backdrop="static"
                                                data-id="{{ $value->id }}"
                                                data-url="{{route('published-article.delete',$value->id)}}"
                                            >
                                                <i class="fas fa-trash"></i>
                                                Delete Article
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

                </div>
                
            </div>
        </div>
    </div>
</div>

<form action="{{ route('published-article.insert') }}" id="addArticleForm" method="post" enctype="multipart/form-data">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="addArticleModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Article</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Title</label>
                <textarea id="titleEditorAdd" class="form-control required" data-label="Title" name="title"></textarea>
                <input type="hidden" class="form-control required" data-label="Title" name="issue_id" value="{{ $data->id }}">
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Abstract</label>
                <textarea id="abstractEditorAdd" class="form-control required" data-label="Abstract" name="abstract"></textarea>
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">PDF</label>
                <input type="file" class="form-control required" data-label="PDF" name="file"  accept="application/pdf">
                <div class="input-feedback"> </div>
            </div>
            <hr/>
            <div class="mt-3 keywordDiv">
                <p><strong>Keywords</strong></p>
                <button class="btn btn-primary addKeywordBtn">Add Keyword</button>
                <div class="keywordInputDiv"></div>
            </div>
            <div class="mt-3 authorDiv">
                <p><strong>Authors</strong></p>
                <button class="btn btn-primary addAuthorBtn">Add Author</button>
                <div class="authorInputDiv"></div>
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
<form action="" id="updateArticleForm" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PUT') }}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateArticleModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Article</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Title</label>
                <textarea  id="update_title" class="form-control required" data-label="Title" name="title"></textarea>
                <input type="hidden" class="form-control required" data-label="Title" name="issue_id" value="{{ $data->issue_id }}">
                <input type="hidden" class="form-control required" data-label="Title" id="edit_id" name="id" value="{{ $data->id }}">
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">Abstract</label>
                <textarea id="update_abstract" class="form-control required" data-label="Abstract" name="abstract"></textarea>
                <div class="input-feedback"> </div>
            </div>
            <div class="form-group md-form">
                <label for="exampleInputName1">PDF</label>
                <input type="file" class="form-control required" data-label="PDF" name="file"  accept="application/pdf">
                <div class="input-feedback"> </div>
            </div>
            <hr/>
            <div class="mt-3 keywordDiv">
                <p><strong>Keywords</strong></p>
                <button class="btn btn-primary addKeywordBtn">Add Keyword</button>
                <div class="keywordInputDiv"></div>
            </div>
            <div class="mt-3 authorDiv">
                <p><strong>Authors</strong></p>
                <button class="btn btn-primary addAuthorBtn">Add Author</button>
                <div class="authorInputDiv"></div>
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
            <h5 class="modal-title">Delete Article</h5>
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


<!-- keywords -->
<form action="{{ route('keyword.insert') }}" id="addKeyForm" method="post">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="addKeywordModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Keywords</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group md-form">
                <label for="exampleInputName1">Keyword</label>
                 
                <input type="text" id="add_published_article_id" class="form-control required" data-label="Title" name="published_article_id">

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
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

<script>

    CKEDITOR.replace( 'abstractEditorAdd', {

        toolbar: [
		{ name: 'document', items: [ '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', ] },
	    ],
        height: 200
    });
    CKEDITOR.replace( 'update_abstract', {

        toolbar: [
        { name: 'document', items: [ '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
        [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
        '/',																					// Line break - next group will be placed in new line.
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', ] },
        ],
        height: 200
    });
    
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
    $(document).on('click', '.btnUpdateArticle', function (event) {
        $(".keywordInputDiv").empty()
        $("#update_id").val($(this).data('id'))
        CKEDITOR.instances['update_abstract'].setData($(this).data('abstract'));
        $("#update_title").val($(this).data('title'))
        $("#updateArticleForm").attr("action",$(this).data('url'))

        $($(this).data('keywords') ).each(function( index ) {
            $("#updateArticleModal .addKeywordBtn").trigger("click")
            $("#updateArticleModal .keywordIdInp:last").val(this.id)
            $("#updateArticleModal .keywordInp:last").val(this.keyword)
        })
        
        $($(this).data('authors') ).each(function( index ) {
            $("#updateArticleModal .addAuthorBtn").trigger("click")
            $("#updateArticleModal .authorIdInp:last").val(this.id)
            $("#updateArticleModal .authorInp:last").val(this.name)
        })
        
    });
    $(document).on('click', '.btnDeleteIssue', function (event) {
        $("#delete_id").val($(this).data('id'))
        $("#deleteIssueForm").attr("action",$(this).data('url'))
    });

    // $(document).on('click', '.addKeywordModal', function (event) {
    //     $("#add_published_article_id").val($(this).data('id'))
    //     $("#update_title").val($(this).data('title'))
    //     $("#updateArticleForm").attr("action",$(this).data('url'))
    // });
    $(document).on('click','.addKeywordBtn',function(event){
        event.preventDefault();
        $(this).closest('.keywordDiv').find('.keywordInputDiv').append(`
            <div class="input-group md-form mt-3">
                <input type="hidden" class="form-control required keywordIdInp" autocomplete="off" name="keyword_id[]" value="0">
                <input type="text" class="form-control required keywordInp" autocomplete="off" name="keyword[]">
                <div class="input-group-append">
                    <button class="btn btn-outline-danger removeThisItemBtn " tabindex="-1" type="button"><i class="fas fa-times"></i></button>
                </div>
                <div class="input-feedback"> </div>
            </div>
        `).addClass("added"+$.now())
    })

    $(document).on('click','.addAuthorBtn',function(event){
        event.preventDefault();
        $(this).closest('.authorDiv').find('.authorInputDiv').append(`
            <div class="input-group md-form mt-3">
                <input type="hidden" class="form-control required authorIdInp" autocomplete="off" name="author_id[]" value="0">
                <input type="text" class="form-control required authorInp" autocomplete="off" name="author[]">
                <div class="input-group-append">
                    <button class="btn btn-outline-danger removeThisItemBtn " tabindex="-1" type="button"><i class="fas fa-times"></i></button>
                </div>
                <div class="input-feedback"> </div>
            </div>
        `).addClass("added"+$.now())
    })
    $(document).on('click','.removeThisItemBtn',function(event){
        event.preventDefault();
        $(this).closest('.input-group').remove();
    })
    
    
    
</script>

@endsection