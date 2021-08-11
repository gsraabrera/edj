
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
                        </ol>
                    </nav>
                    <h1>{{ $page->name }}</h1>
                    <hr/>
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection