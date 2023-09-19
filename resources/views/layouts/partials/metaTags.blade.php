<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(isset($metaTags))
<meta name="description" content="{{$metaTags['description']}}" />
<meta name="keywords" lan="id" content="website, laravel, app" />
<meta property="og:type" content="laravel app" />
<meta property="og:title" content="{{$metaTags['title']}}" />
<meta property="og:description" content="{{$metaTags['description']}}" />
<!-- <meta property="og:url" content="https://../" /> -->
<meta property="og:site_name" content="Laravel App" />
<meta property="og:image" content="{{ asset('img/materials/landing.jpg') }}" />
<meta property="og:image:type" content="image/jpg" />
<meta property="og:image:width" content="1366" />
<meta property="og:image:height" content="768" />
<meta name="twitter:image" content="{{ asset('img/materials/landing.jpg') }}">
<!-- Favicons -->
@if(isset($metaTags['icon']))
<link href="{{ asset('/img/logo/'.$metaTags['icon']) }}" rel="icon">
<link href="{{ asset('/img/logo/'.$metaTags['icon']) }}" rel="apple-touch-icon">
@else
<link href="{{ asset('/img/logo/logo_book_small.png') }}" rel="icon">
<link href="{{ asset('/img/logo/logo_book_small.png') }}" rel="apple-touch-icon">
@endif
@endif

