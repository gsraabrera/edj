
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-3 mt-5">Article Information</h1>
            <div class="card green-border-top">
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
                                        <a href="{{route('author.download', [$data->id,'cover_letter','t'=>date('YmdHis')])}}" target="_blank">
                                            <button class="btn btn-primary">View Cover Letter</button>
                                        </a>
                                        <a href="{{route('author.download', [$data->id,'signed_author_agreement','t'=>date('YmdHis')])}}" target="_blank">
                                            <button class="btn btn-primary">View Signed authors’ agreement form</button>
                                        </a>
                                        <a href="{{route('author.download', [$data->id,'article','t'=>date('YmdHis')])}}" target="_blank">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
