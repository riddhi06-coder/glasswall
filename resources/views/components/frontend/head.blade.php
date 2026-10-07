    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K5CF8RLQ');</script>
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

    {{-- ===== Dynamic SEO (managed in admin → SEO Manager) ===== --}}
    <title>{{ optional($seo ?? null)->meta_title ?: config('app.name', 'Glass Wall Systems') }}</title>
    @if(optional($seo ?? null)->meta_description)
    <meta name="description" content="{{ $seo->meta_description }}" />
    @endif
    <link rel="canonical" href="{{ optional($seo ?? null)->canonical ?: url()->current() }}" />

    @if(optional($seo ?? null)->hreflang)
    {!! $seo->hreflang !!}
    @else
    <link rel="alternate" href="{{ url()->current() }}" hreflang="en-in" />
    <link rel="alternate" href="{{ url()->current() }}" hreflang="x-default" />
    @endif

    @if(optional($seo ?? null)->og_tag)
    {!! $seo->og_tag !!}
    @endif
    @if(optional($seo ?? null)->twitter_card_tag)
    {!! $seo->twitter_card_tag !!}
    @endif
    {{-- ===== /Dynamic SEO ===== --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/assets/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/spacing.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer-min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome-pro.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/media.css') }}" />
