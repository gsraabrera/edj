@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 65vh">
        <h1 style="font-size: 50px; font-weight: bold;">Whoops!</h1>
        <h1 style="font-size: 120px; font-weight: bolder;">404</h1>
        <p>It seems like we couldn't find the page you were looking for</p>
        <a href="{{ url('/') }}">
            <button class="btn btn-primary">Go to homepage</button>
        </a>
    </div>
</div>
@endsection
