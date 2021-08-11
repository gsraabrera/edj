<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials/_head')
<body>
    
    <div id="app">
        @include('partials/_nav')

        <main  style="min-height:60vh;">
            @yield('content')
        </main>
        @include('partials/_footer')
    </div>

</body>
@yield('scripts')
</html>
