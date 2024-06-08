<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} || {{ $metadata['page_title'] }}</title>
    <meta name="title" content="{{ $metadata['page_title'] }}">
    <meta name="description" content="{{ $metadata['seo_description'] }}" />
    <meta name="keywords" content="{{ $metadata['seo_keyword'] }}" />
    <meta name="application-name" content="http://localhost" />
    <meta name="copyright" content="©️ 2023 aaloy.com. All rights reserved." />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link href="{{ asset('public/frontend/assets/css/home.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/frontend/assets/css/header.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/loader.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.5/js.cookie.min.js"></script>
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
    @yield('styles')
</head>
<body> 
    <div class="animationload" style="display: none;">
        <div class="osahanloading"></div>
    </div>

    @yield('content')     

    <!-- scroll -->
    <div id="scroll" style="display: none;"><span></span></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/frontend/assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="{{ asset('public/frontend/assets/js/common.js') }}"></script>
    @yield('javascripts')
</body>
</html>