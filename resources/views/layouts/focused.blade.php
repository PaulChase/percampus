<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PDD32MW');</script>
    <!-- End Google Tag Manager -->

    {{-- google ads code --}}
    {{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2073252647616982"
     crossorigin="anonymous">
    </script> --}}

      {{-- propeller ads verification code --}}

    <meta name="propeller" content="635054a5ad2dc2fc887ac53247fd6639">

    {{-- propeller ads  code --}}
     <script>(function(s,u,z,p){s.src=u,s.setAttribute('data-zone',z),p.appendChild(s);})(document.createElement('script'),'https://inklinkor.com/tag.min.js',5023501,document.body||document.documentElement)</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      {{-- for SEO --}}
      <link rel="canonical" href="{{url()->current()}}" />

    <link rel="shortcut icon" href="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/percampus.ico" type="image/x-icon">


    {{-- load font awesome from cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;0,600;0,700;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">
    {{-- <link href="{{ asset('css/fs/css/all.min.css') }}" rel="stylesheet"> --}}
    
     {{-- jquery script --}}
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <style>
        /* #menu-toggle:checked + #menu {
            display: block;
        } */

        .gigtext {
            
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        
    </style>

    
</head>
<body class="bg-grey-50 h-full w-full text-gray-600 font-sourcesans">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDD32MW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
        <main class="">
        
            @yield('focus')
        </main>
   
    
@yield('js')
</body>
</html>
