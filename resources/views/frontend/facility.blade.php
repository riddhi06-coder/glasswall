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
                    data-background="{{ $facility && $facility->banner_image ? $facility->assetUrl($facility->banner_image) : asset('frontend/assets/images/bread/facility.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($facility)->banner_heading ?: 'Facility' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Infrastructure</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($facility)->banner_heading ?: 'Facility' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="tp-about-area facility-wrap tp-about-spacing-3 p-relative fix">

                    <div class="container">

                        <div class="row">

                            <div class="col-lg-6">
                                <!--<div class="tp-about-image br-20 p-relative">-->
                                <!--   <img class=" tp_fade_anim" data-delay=".2" data-duration=".9" src="assets/images/home/facility.webp" alt="">-->
                                <!--</div>-->
                                <div class="tp-about-heading pb-70 tp-text-center ml-35">
                                    <h2 class="tp-section-title margin-0">{{ optional($facility)->about_heading }}</h2>






                                </div>
                            </div>

                            <div class="col-lg-6">

                                <div class="tp-about-content tp-about-content-2 ml-35">
                                    <div class="tp-about-deg tp-about-deg-2 tp-about-deg-border pb-65 mb-35 tp_fade_anim" data-duration=".9" data-delay=".3">
                                        {!! optional($facility)->about_description !!}
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <!-- about-area,end  -->

                <section class="facade-feature-section">
                    <div class="container">
                        <div class="row g-5 align-items-stretch">

                            @foreach(optional($facility)->features ?? [] as $feature)
                                <div class="col-md-6">
                                    <div class="facade-feature-box h-100">
                                        <div class="facade-feature-icon">
                                            @if($feature->image)
                                                <img src="{{ $feature->image_url }}" alt="{{ $feature->title }}">
                                            @endif
                                        </div>

                                        <div class="facade-feature-content">
                                            <h3 class="facade-feature-title">{{ $feature->title }}</h3>
                                            <p class="facade-feature-text">{{ $feature->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </section>

                <!-- testimonail-area,start  -->
                <section class="facility-area tp-testimonail-area ">
                    <div class="container-wide">
                        <!--<div class="tp-solid-bg tp-bg br-20 p-relative jarallax" data-background="assets/images/home/facility.webp">-->
                        <!--</div>-->
                        @if($facility && $facility->counter_image)
                            <img src="{{ $facility->assetUrl($facility->counter_image) }}" />
                        @endif

                    </div>
                    <!--<div class="facility-text-wrap">-->
                    <!--      <div class="tp-text-center">-->
                    <!--        <div class="col-lg-12">-->
                    <!--     <p>At GWS, sustainability means pairing high-quality engineering with advanced CNC machinery to minimize errors and drastically reduce material waste.</p>-->
                    <!--        </div>-->
                    <!--      </div>-->

                    <!--    </div>-->
                    <div class="tp-testi-card">

                        <div class="tp-testi-card-right">
                            <div class="tp-fact-grid">

                                @foreach(optional($facility)->counters ?? [] as $counter)
                                    <div class="tpfact">
                                        <div class="tpfact__icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <path d="M3 9h18M9 3v18"></path>
                                            </svg>
                                        </div>
                                        <h3 class="tpfact__title">
                                            <span class="odometer" data-count="{{ (int) preg_replace('/[^0-9]/', '', $counter->count) }}">0</span>@if($counter->suffix)<span class="{{ trim($counter->suffix) === '+' ? 'tpfact__plus' : 'tpfact__text' }}">{{ $counter->suffix }}</span>@endif
                                        </h3>
                                        <p class="tpfact__label">{{ $counter->label }}</p>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </section>
                <!-- testimonail-area,end  -->

                <section class="tp-services-area default-margin tp-services-spacing tp-bg-gray fix">
                    <div class="container">
                        <div class="tp-services-heading mb-60">
                            <div class="row tp-align-end">
                                <div class="col-md-12">
                                    <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                                        <h2 class="tp-section-title mb-20">{{ optional($facility)->process_heading }}</h2>
                                        <div>{!! optional($facility)->process_description !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row unit-section">
                            @foreach(optional($facility)->galleries ?? [] as $gallery)
                                <div class="col-md-4">
                                    <div class="unit-item">
                                        <img src="{{ $gallery->image_url }}" class="br-20" alt="{{ $gallery->heading ?: 'image' }}">
                                        @if($gallery->heading)
                                            <div class="unit-title tp_fade_anim" data-duration=".9" data-delay=".3">
                                                {{ $gallery->heading }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="equipment-strength-section">
                    <div class="container">
                        <div class="row g-4">

                            @foreach(optional($facility)->strengths ?? [] as $strength)
                                <div class="col-lg-6">
                                    <div class="equipment-card">
                                        <div class="equipment-card__heading">
                                            <span class="equipment-card__number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                            <h2>{{ $strength->title }}</h2>
                                        </div>

                                        {!! str_replace('<ul>', '<ul class="equipment-list">', $strength->description) !!}
                                    </div>
                                </div>
                            @endforeach

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