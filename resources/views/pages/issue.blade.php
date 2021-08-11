@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vol {{ $data->volume }} No {{ $data->issue_no }} {{ $data->year }}: Ecosystems and Development Journal</li>
                        </ol>
                        
                    </nav>
                    <div style="background:#f3f3f3">
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
                    <h4 class="mt-5 font-weight-bold mb-3">Articles</h4>
                    
                    @if(!empty($data->articles) && $data->articles->count())
                    <table class="table table-bordered table-hover">
                        @foreach($data->articles as $key => $article)
                        <div class="card  mb-3" style="    border-left: solid 3px #00563F;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                            <a href="{{ route('article',['issueSlug'=>$data->slug,'slug'=>$article->id]) }}">
                                            <h5 class="font-weight-bold green-text">{{ $article->title }}</h5>
                                        </a>
                                        <p>
                                                    @foreach ($article->authors as $authors)
                                                        <span  style="font-style: italic;">
                                                            {{ $authors->name}}@if( !$loop->last), @endif
                                                        </span>
                                                    @endforeach
                                            <br/>
                                            <strong>keywords:</strong>
                                                    @foreach ($article->keywords as $keywords)
                                                        <span>
                                                            {{ $keywords->keyword}}@if( !$loop->last), @endif
                                                        </span>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-outline-primary btn-block"  href="{{url('/published_articles/'.$article->file)}}" target="_blank">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </table>

                    @else
                        <p class="mt-3">No Article found.</p>
                    @endif
 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection