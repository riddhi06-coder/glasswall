<!DOCTYPE html>
<html lang="en">

<head>

    @include('components.frontend.head')

    <style>
        /* The EPD table is entered via the rich-text editor as a bare <figure class="table">,
           so it lacks Bootstrap's .table .table-bordered classes. Reproduce that look here. */
        .custom-epd-wrap figure.table { width: 100%; margin: 0; overflow-x: auto; }
        .custom-epd-wrap figure.table table { width: 100%; border-collapse: collapse; text-align: center; }
        .custom-epd-wrap figure.table th,
        .custom-epd-wrap figure.table td { border: 1px solid #dee2e6; padding: .75rem; vertical-align: middle; }
        .custom-epd-wrap figure.table thead th { border-bottom-width: 2px; font-weight: 600; }
    </style>

</head>

<body>

    @include('components.frontend.header')

    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main>

                <!-- hero area start -->
                <section
                    class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
                    data-background="{{ $esg && $esg->banner_image ? $esg->assetUrl($esg->banner_image) : asset('frontend/assets/images/bread/esg.webp') }}">
                    <div class="container">

                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($esg)->banner_heading ?: 'ESG' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($esg)->banner_heading ?: 'ESG' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <!-- about-area,start  -->
                <section class="md-wrap">
                    <div class="container">
                        <div class="row tp-align-center">
                            <!-- Left Side -->
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                <div class="md-img">
                                    <img
                                        class="tp_fade_anim br-20"
                                        data-duration=".9"
                                        data-delay=".7"
                                        src="{{ $esg ? $esg->assetUrl($esg->director_image) : '' }}"
                                        alt="Glass Wall Systems" />
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="col-xl-7 col-lg-7">
                                <div class="md-text">
                                    <span class="tp-section-sub-title mb-15">From MD's Desk</span>
                                    <h2 class="tp-section-title tp-about-title mb-25 tp_fade_anim" data-duration=".9" data-delay=".2">
                                        {{ optional($esg)->director_heading }}
                                    </h2>

                                    <div class="tp_fade_anim" data-duration=".9" data-delay=".4">
                                        <div class="mb-20">{!! optional($esg)->director_desc !!}</div>
                                        <h3>{{ optional($esg)->director_name }}</h3>
                                        <p>- {{ optional($esg)->director_position }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- feature-area,start -->
                <section class="tp-value-area">
                    <div class="container-wide">
                        <div
                            class="tp-overlay-2 tp-value-spacing br-20 fixed_attachment tp-bg fix"
                            data-background="{{ $esg && $esg->innovation_bg_image ? $esg->assetUrl($esg->innovation_bg_image) : '' }}">
                            <div class="row">
                                <div class="col-xl-5 offset-xl-1 col-lg-5">
                                    <div class="tp-section-title-wrap tp-value-heading pb-45">
                                        <span class="tp-section-sub-title tp-section-sub-title-sec mb-12">Our ESG Priorities</span>
                                        <h2 class="tp-section-title margin-0 tp-text-white">
                                            {{ optional($esg)->innovation_heading }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-7">
                                    <div class="tp-value-wrap">
                                        <div class="row gx-0 tp-value-left-border">
                                            @foreach(optional($esg)->innovationFeatures ?? [] as $f)
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="tp-value-item">
                                                        <div class="tp-value-icon-wrap tp-flex-center tp-justify-between mb-25">
                                                            <span class="tp-value-icon">
                                                                @include('frontend._esg_icon', ['file' => $f->image, 'alt' => $f->feature])
                                                            </span>
                                                            <p class="margin-0">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                                                        </div>
                                                        <div class="tp-value-content">
                                                            <h4>{{ $f->feature }}</h4>
                                                            <p>{{ $f->description }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- feature-area,end -->

                <!-- about-area,start  -->
                <section class="sustainability-wrap">
                    <div class="container">
                        <div class="row tp-align-center">
                            <!-- Right Side -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="sustainability-text tp-text-center">
                                    <span class="tp-section-sub-title mb-15">Sustainablity Goals</span>
                                    <h2 class="tp-section-title tp-about-title mb-25 tp_fade_anim" data-duration=".9" data-delay=".2">
                                        {{ optional($esg)->dev_heading }}
                                    </h2>

                                    <div class="tp_fade_anim" data-duration=".9" data-delay=".4">
                                        <div class="mb-20">{!! optional($esg)->dev_desc !!}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Left Side -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="sustainability-img">
                                    <img
                                        class="tp_fade_anim br-20"
                                        data-duration=".9"
                                        data-delay=".7"
                                        src="{{ $esg ? $esg->assetUrl($esg->dev_image) : '' }}"
                                        alt="Glass Wall Systems" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- contect-area,start  -->
                <section class="tp-contect-area custom-counter-wrap">
                    <div class="container-wide">
                        <div
                            class="tp-contect-spacing br-20 tp-linear-bg-3 jarallax p-relative fix"
                            data-background="{{ $esg && $esg->driving_bg_image ? $esg->assetUrl($esg->driving_bg_image) : '' }}">
                            <div class="container">
                                <div class="tp-contect-main tp-bg-secoundery br-20 pt-70 pb-70 p-relative fix">
                                    <div class="tp-contect-shape-inner p-absolute">
                                        <img
                                            class="tp_fade_anim"
                                            data-fade-from="top"
                                            data-fade-offset="50"
                                            src="{{ asset('frontend/assets/img/bg/contect-shape-2.png') }}"
                                            alt="" />
                                    </div>
                                    <div class="row tp-justify-center z-index-1">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="tp-section-title-wrap tp-contect-heading tp-text-center mb-65">
                                                <span class="tp-section-sub-title mb-12">Sustainable Impact</span>
                                                <h2 class="tp-section-title">{{ optional($esg)->driving_heading }}</h2>
                                            </div>
                                            <div class="tp-fact-grid">
                                                @foreach(optional($esg)->drivingCounts ?? [] as $c)
                                                    @php
                                                        $cnum  = preg_replace('/[^0-9]/', '', $c->count) ?: '0';
                                                        $cunit = preg_replace('/[0-9.,\s]/', '', $c->count);
                                                    @endphp
                                                    <div class="tpfact">
                                                        <div class="tpfact__icon">
                                                            @include('frontend._esg_icon', ['file' => $c->image, 'alt' => ''])
                                                        </div>
                                                        <h3 class="tpfact__title">
                                                            <span class="odometer" data-count="{{ $cnum }}">0</span>
                                                            @if($cunit)<span class="tpfact__plus">{{ $cunit }}</span>@endif
                                                        </h3>
                                                        <p class="tpfact__label">{{ $c->feature }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- contect-area,end  -->

                <!-- work-area,start  -->
                <section class="tp-work-area">
                    <div class="container-wide">
                        <div class="tp-work-main tp-bg fix br-20 jarallax" data-background="{{ asset('frontend/assets/images/bg/work-bg.webp') }}">
                            <div class="container">
                                <div class="tp-work-heading mb-60">
                                    <div class="row tp-align-end">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="tp-section-title-wrap tp-text-center">
                                                <span class="tp-section-sub-title mb-15 tp_fade_anim" data-delay=".1">Years Talk</span>
                                                <h2 class="tp-section-title margin-0 tp_fade_anim" data-delay=".3">
                                                    {{ optional($esg)->impact_heading }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tp-work-wrap">
                                    @foreach(optional($esg)->impacts ?? [] as $im)
                                        <div class="tpwork">
                                            <div class="tpwork__thumb p-relative fix">
                                                <img src="{{ $esg->assetUrl($im->image) }}" alt="{{ $im->impact }}" />
                                                <h3 class="tpwork__num">{{ $im->year }}</h3>
                                            </div>
                                            <div class="tpwork__content">
                                                <h4 class="tpwork__title mb-15">{{ $im->impact }}</h4>
                                                <p>{{ $im->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- work-area,end  -->

                <!-- about-area,start  -->
                <section class="stackholder-wrap">
                    <div class="container">
                        <div class="row tp-align-center">
                            <!-- Right Side -->
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                <div class="stackholder-text tp-text-center">
                                    <span class="tp-section-sub-title mb-15">Stakeholder</span>
                                    <h2 class="tp-section-title tp-about-title mb-25 tp_fade_anim" data-duration=".9" data-delay=".2">
                                        {{ optional($esg)->stakeholder_heading }}
                                    </h2>

                                    <div class="tp_fade_anim" data-duration=".9" data-delay=".4">
                                        <div class="mb-20">{!! optional($esg)->stakeholder_desc !!}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Left Side -->
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                <div class="stackholder-img">
                                    <img
                                        class="tp_fade_anim br-20"
                                        data-duration=".9"
                                        data-delay=".7"
                                        src="{{ $esg ? $esg->assetUrl($esg->stakeholder_image) : '' }}"
                                        alt="Glass Wall Systems" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="tp-services-area custom-waste-wrap tp-services-spacing tp-services-spacing-3 default-margin br-20 p-relative fix">
                    <div class="container">
                        <div class="tp-services-heading mb-60">
                            <div class="row tp-align-end">
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp-services-card-wrap tp-text-center">
                                        <h2 class="tp-section-title margin-0 tp_fade_anim" data-delay=".3">
                                            {{ optional($esg)->waste_heading }}
                                        </h2>
                                        <div>{!! optional($esg)->waste_desc !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach(optional($esg)->wasteFeatures ?? [] as $w)
                                <div class="col-xl-3 col-md-6 tp_fade_anim" data-delay=".{{ 5 + $loop->index }}">
                                    <div class="tpserv__card tp-text-center br-20 bg-blue fix mb-30">
                                        <div class="tpserv__card-icon">
                                            @if($w->image)
                                                <img src="{{ $esg->assetUrl($w->image) }}" alt="{{ $w->feature }}">
                                            @endif
                                        </div>
                                        <h3 class="tpserv__card-title tp-fs-24">
                                            {{ $w->feature }}
                                        </h3>
                                        <p>{{ $w->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- services-area,start  -->
                <section class="tp-services-area custom-epd-wrap  tp-services-spacing-4 fix pt-0">
                    <div class="container">
                        <div class="tp-services-heading">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="tp-section-title-wrap tp-text-center">
                                        <span class="tp-section-sub-title mb-15 tp_fade_anim" data-duration=".9">EPDs</span>
                                        <h2 class="tp-section-title tp_fade_anim" data-duration=".9" data-delay=".2">
                                            {{ optional($esg)->env_heading }}
                                        </h2>
                                        <p>{{ optional($esg)->env_short_desc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row tpservices2__up tp-justify-center tp-align-center">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! optional($esg)->env_specification_desc !!}
                            </div>
                        </div>
                    </div>
                </section>
                <!-- services-area,end  -->

            </main>

            @include('components.frontend.footer')
        </div>
    </div>

    @include('components.frontend.main-js')

    <script>
        // Dynamic images load after GSAP measures the page, which leaves the
        // scroll-triggered fade animations stuck. Recalculate once everything is in.
        window.addEventListener('load', function () {
            function refresh() {
                if (window.ScrollTrigger) window.ScrollTrigger.refresh(true);
                if (window.ScrollSmoother && ScrollSmoother.get()) ScrollSmoother.get().refresh();
            }
            if (window.imagesLoaded) {
                imagesLoaded(document.body, refresh);
            } else {
                setTimeout(refresh, 400);
            }
        });
    </script>

</body>

</html>
