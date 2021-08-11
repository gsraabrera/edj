@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 65vh">
        <h1 style="font-size: 100px; font-weight: bold;">Whoops!</h1>
        <p>Unauthorized. Don't worry though, there is always a way to go back home.</p>
        <a href="{{ url('/') }}">
            <button class="btn btn-primary">Go to homepage</button>
        </a>
    </div>
</div>
@endsection
