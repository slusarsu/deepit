<head>
    <meta charset="utf-8">
    <title>{{$site['name']}} - {{$title ?? $site['seoTitle']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="{{$seoDescription ?? $site['seoDescription']}}">
    <meta name="keywords" content="{{$seoKeyWords ?? $site['seoKeyWords']}}">
    <meta name="author" content="{{$seoAuthor ?? $site['author']}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">

    <!-- theme meta -->
    <meta name="theme-name" content="reporter" />

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/bootstrap.min.css')}}">

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    {!! $site['googleTagManager'] !!}
    {!! $site['metaPixelCode'] !!}
    {!! $site['customHeaderCode'] !!}

    @stack('header-code')

    <style>
        {!! $site['customCss'] !!}
    </style>

</head>
