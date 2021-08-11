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
                            <li class="breadcrumb-item active" aria-current="page" ><a href="{{ route('issue.issue',$data->issue_slug) }}">Vol {{ $data->volume }} No {{ $data->issue_no }} {{ $data->year }}: Ecosystems and Development Journal</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Article</li>
                        </ol>
                        
                    </nav>
                    <h2 class="green-text">{{ $data->title }}</h2>
                            <p style="font-style: italic;">
                                                    @foreach ($data->authors as $authors)
                                                        <span>
                                                            {{ $authors->name}}@if( !$loop->last), @endif
                                                        </span>
                                                    @endforeach
                                                    <br/>  

                                <br/>
                            </p>

                    <h5 class="font-weight-bold">Abstract</h5>
                    {!! $data->abstract !!}
                    <p>
                    <strong>keywords:</strong>
                                @foreach ($data->keywords as $keywords)
                                    <span>
                                        {{ $keywords->keyword}}@if( !$loop->last), @endif
                                    </span>
                                @endforeach
                    </p>
                    <p>
                    <strong>Full Text:</strong>
                    <div class="row">
                        <div class="col-md-2">
                        <a class="btn btnUpdateArticle btn-outline-primary btn-block" href="{{url('/published_articles/'.$data->file)}}">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection