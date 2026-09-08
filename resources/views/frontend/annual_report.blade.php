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
                    data-background="{{ $banner && $banner->banner_image ? $banner->banner_image_url : asset('frontend/assets/images/bread/ir.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'Annual Reports' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Investors Relations</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($banner)->banner_heading ?: 'Annual Reports' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="tp-services-area tp-services-spacing custom-pdf-wrap tp-services-spacing-3 default-margin br-20 tp-bg-gray p-relative fix">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 tp_fade_anim" data-delay=".5">
                                <div class="document-grid-two">
                                    @forelse($reports as $report)
                                        <a href="{{ $report->pdf_url }}" class="document-box" target="_blank" rel="noopener">
                                            <span class="document-title">{{ $report->title }}</span>
                                            <span class="document-icon">
                                                <img src="{{ asset('frontend/assets/images/icons/pdf.svg') }}" alt="PDF">
                                            </span>
                                        </a>
                                    @empty
                                        <p>No annual reports available yet.</p>
                                    @endforelse
                                </div>
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
