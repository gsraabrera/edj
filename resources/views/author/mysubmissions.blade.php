
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mt-5 mb-3">My Submitted Articles</h1>
            <div class="card green-border-top">
                <div class="card-body ">
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
                    <a href="{{ route('submit-article') }}">
                        <button class="btn btn-primary mb-3 mt-5 float-right" >Submit an article</button>
                    </a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Abstract</th>
                                <th>Date Submitted</th>
                                <th width="200px;" style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data) && $data->count())
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $value->title }}</td>
                                        <td>{{ $value->abstract }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td style="text-align:center;" width="20px" class="col-2">
                                            <a href="{{ route('author-article',$value->id) }}">
                                            <button class="btn btn-primary"><i class="fas fa-eye"></i> View</button>
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
@endsection
