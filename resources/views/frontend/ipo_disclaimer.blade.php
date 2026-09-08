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
                    data-background="{{ $drhp && $drhp->banner_image ? $drhp->banner_image_url : asset('frontend/assets/images/bread/ir.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($drhp)->page1_heading ?: 'Disclaimer' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Investors Relations</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span><a href="{{ route('frontend.ipo') }}">IPO</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($drhp)->page1_heading ?: 'Disclaimer' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section id="drhpDisclaimer" class="tp-services-area tp-services-spacing custom-pdf-wrap tp-services-spacing-3 default-margin br-20 tp-bg-gray p-relative fix">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 tp_fade_anim" data-delay=".5">

                                {!! optional($drhp)->page1_content !!}

                                <div class="d-flex gap-2">
                                    <a href="{{ route('frontend.ipo_disclaimer_confirm') }}" id="drhpContinue" class="tp-btn tp-btn-white">
                                        <span class="tp-btn-text tp-btn-white">Continue</span>
                                        <span class="tp-btn-icon">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>
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

    <script>
        (function () {
            var btn = document.getElementById('drhpContinue');
            if (!btn) return;
            btn.addEventListener('click', function (e) {
                if (btn.classList.contains('is-processing')) { e.preventDefault(); return; }
                btn.classList.add('is-processing');
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.65';
                var t = btn.querySelector('.tp-btn-text');
                if (t) t.textContent = 'Processing...';
                // default navigation proceeds to the confirm page
            });
        })();
    </script>

</body>

</html>
