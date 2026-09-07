<!DOCTYPE html>
<html lang="en">

<head>

    @include('components.frontend.head')

</head>

<body>

    @include('components.frontend.header')

    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main>
                <!-- hero area start -->
                <section
                    class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
                    data-background="{{ $design && $design->banner_image ? $design->assetUrl($design->banner_image) : asset('frontend/assets/images/bread/design.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($design)->banner_heading ?: 'Design and Engineering' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Infrastructure</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($design)->banner_heading ?: 'Design and Engineering' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="design-info-wrap">
                    <div class="container">
                        <div class="design-intro">
                            <div class="tp-section-title-wrap tp-text-center">
                                <h2 class="tp-section-title tp_fade_anim" data-duration=".9" data-delay=".2">{{ optional($design)->section_heading }}</h2>
                            </div>
                            <div>{!! optional($design)->description !!}</div>
                        </div>

                        <div class="technology-grid">
                            <div class="technology-quote">
                                <!--<span class="quote-icon"><img src="assets/images/icons/text.svg"/></span>-->
                                <p>{{ optional($design)->features_heading }}</p>
                            </div>

                            @foreach(optional($design)->features ?? [] as $feature)
                                <div class="technology-card">
                                    <div>
                                        <h3>{{ $feature->feature }}</h3>
                                        <div>{!! $feature->description !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="container team-images">
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                @if($design && $design->features_image)
                                    <img src="{{ $design->assetUrl($design->features_image) }}" alt="{{ optional($design)->features_heading }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </section>



            </main>

            @include('components.frontend.footer')
        </div>
    </div>

    @include('components.frontend.main-js')

</body>

</html>