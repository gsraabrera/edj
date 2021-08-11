
@extends('layouts.app')

@section('content')


<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <nav aria-label="breadcrumb" class="mb-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Archive</li>
                    </ol>
                </nav>
                <h3 class="green-text font-weight-bold mb-3">Archive: {{ $data->first()->year }}</h3>
                    @foreach ($data as $value)
                    <div class="card mb-3 ">
                        <div class="card-body" style="border-left: #00563F solid 3px; background: #f9f9f9;">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{url('/cover_image/'.$value->cover_image)}}" class= "shadow-sm" style="max-width:100%;">
                                </div>
                                <div class="col-md-10">
                                    <a href="{{ route('issue.issue',$value->slug) }}">
                                        <h5 class="green-text font-weight-bold  align-middle ">
                                                            Vol {{ $value->volume }} No {{ $value->issue_no }} {{ $value->year }}: Ecosystems and Development Journal
                                        </h5>
                                    </a>
                                    <p>Date Published: {{ $value->date_published }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection