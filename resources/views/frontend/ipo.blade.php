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
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'IPO' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Investors Relations</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($banner)->banner_heading ?: 'IPO' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="tp-services-area tp-services-spacing custom-pdf-wrap tp-services-spacing-3 default-margin br-20 tp-bg-gray p-relative fix">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 tp_fade_anim" data-delay=".5">
                                <div class="document-grid">

                                    {{-- DRHP -> disclaimer flow --}}
                                    @if($drhp)
                                        <a href="{{ route('frontend.ipo_disclaimer') }}" class="document-box">
                                            <span class="document-title">DRHP</span>
                                            <span class="document-icon">
                                                <img src="{{ asset('frontend/assets/images/icons/pdf.svg') }}" alt="PDF">
                                            </span>
                                        </a>
                                    @endif

                                    {{-- Standalone documents --}}
                                    @foreach($standalone as $doc)
                                        <a href="{{ $doc->pdf_url }}" class="document-box" target="_blank" rel="noopener">
                                            <span class="document-title">{{ $doc->title }}</span>
                                            <span class="document-icon">
                                                <img src="{{ asset('frontend/assets/images/icons/pdf.svg') }}" alt="PDF">
                                            </span>
                                        </a>
                                    @endforeach

                                    {{-- Grouped documents (Industry Report, Abridged Prospectus, ...) --}}
                                    @foreach($grouped as $groupName => $subgroups)
                                        @php($header = $headers[$groupName] ?? null)
                                        <div class="document-box document-box-parent">

                                            <div class="document-parent-title">
                                                @if($header && $header->pdf)
                                                    <a href="{{ $header->pdf_url }}" target="_blank" rel="noopener"><span>{{ $groupName }}</span></a>
                                                @else
                                                    <a href="#" onclick="return false;"><span>{{ $groupName }}</span></a>
                                                @endif
                                            </div>

                                            @foreach($subgroups as $subName => $subDocs)
                                                <div class="document-category">
                                                    @if($subName !== '')
                                                        <div class="document-category-title">
                                                            <span>{{ $subName }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="document-subgrid">
                                                        @foreach($subDocs as $doc)
                                                            <a href="{{ $doc->pdf_url }}" target="_blank" rel="noopener" class="document-subbox">
                                                                <span>{{ $doc->title }}</span>
                                                                <img src="{{ asset('frontend/assets/images/icons/pdf.svg') }}" alt="PDF">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endforeach

                                    @if(! $drhp && $standalone->isEmpty() && $grouped->isEmpty())
                                        <p>No documents available yet.</p>
                                    @endif

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
