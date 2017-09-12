<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#E95420" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!--
        <link rel='stylesheet' href='{{ asset('css/bootstrap.min.css') }}' />
        <link rel='stylesheet' href='{{ asset('css/navbar-fixed-side.css') }}' />
        -->
        <link rel='stylesheet' href='{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}' />
        <link rel='stylesheet' href='{{ asset('css/app.css') }}' />
        
        <link href="{{ asset('img/favicon.ico') }}" type="image/png" rel="icon">
        
        <title>@yield('title')</title>
    </head>
            @if ( Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri() == '/' )
                <body class="landing-page-bg">
                <div class="container">
                    @yield('content')
                </div>
            @else
                <body>
                <div class="container-fluid" style="overflow-x:hidden;">
                    <div class="row">
                        <div class="col-sm-3 col-lg-2">
                            @include('includes.nav')
                        </div>
                        <div class="col-sm-9 col-lg-10">
                            @yield('content')
                        </div>
                    </div>
                </div>
              <script>
                $(document).ready( function() {
                    var url = "{{ Request::fullUrl() }}";
                  for(var i = 0; i < $("#sidebar-nav li").length; i++) {
                    if ( url.indexOf($("#sidebar-nav li:eq(" + i + ") a").attr("href")) != -1 )
                      $("#sidebar-nav li:eq(" + i + ")").addClass("active-nav");
                  }
                });
              </script>
            @endif
        @include('includes.footer')
    </body>
</html>