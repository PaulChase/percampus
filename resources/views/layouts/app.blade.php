<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PDD32MW');

    </script>
    <!-- End Google Tag Manager -->

    {{-- propeller ads verification code --}}

    <meta name="propeller" content="635054a5ad2dc2fc887ac53247fd6639">

    {{-- propeller ads  code --}}
    {{-- @if (config('app.env') !== "local")
           <script>(function(s,u,z,p){s.src=u,s.setAttribute('data-zone',z),p.appendChild(s);})(document.createElement('script'),'https://inklinkor.com/tag.min.js',5023501,document.body||document.documentElement)</script>
    @endif --}}
  

    {{-- google ads code --}}
    {{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2073252647616982"
     crossorigin="anonymous">
    </script> --}}

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="keywords"
        content="campus marketplace, buy and sell on campus, percampus, scholarships for university students, sell products on campus,sell products on a university campus,{{ $post->user->campus->name ?? '' }}, {{ $post->title ?? '' }}, {{ $post->subcategory->slug ?? '' }},  {{ $post->subcategory->category->name ?? '' }} ">

    <meta name="description" content="@yield('description')">


    <meta name="author" content="{{ $post->user->name ?? 'percampus' }}">

    {!! OpenGraph::generate() !!}

    {{-- just stoped working all of sudden --}}
    {!! Twitter::generate() !!}
    {{-- <meta property="twitter:title" content="@yield('title')"> --}}

    {{-- for social media sharing --}}
    {{-- <meta property="og:site_name" content="Percampus">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:type" content="website">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="@yield('image_url')"> --}}


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Percampus') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- jquery script --}}
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>






    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon"
        href="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/percampus.ico"
        type="image/x-icon">
    {{-- for SEO --}}
    <link rel="canonical" href="{{ url()->current() }}" />


    {{-- load font awesome from cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;0,600;0,700;0,900;1,400;1,600;1,700&display=swap"
        rel="stylesheet">
    <style>
        .gigtext {

            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

    </style>

    @livewireStyles
</head>

<body class="bg-grey-50 h-full w-full text-gray-600 font-sourcesans">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDD32MW" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    @include('include.navbar')

    <main>
        @include('include/messages')
        @yield('content')
    </main>
    @include('include.categories')
    @include('include.footer')

    @yield('js')



    @livewireScripts
</body>

</html>
