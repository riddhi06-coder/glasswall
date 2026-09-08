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
                    data-background="{{ $drhp && $drhp->banner_image_2 ? $drhp->banner_image_2_url : asset('frontend/assets/images/bread/ir.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($drhp)->page2_heading ?: 'Disclaimer' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Investors Relations</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span><a href="{{ route('frontend.ipo') }}">IPO</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($drhp)->page2_heading ?: 'Disclaimer' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section id="drhpDisclaimer" class="tp-services-area tp-services-spacing custom-pdf-wrap tp-services-spacing-3 default-margin br-20 tp-bg-gray p-relative fix">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 tp_fade_anim" data-delay=".5">

                                {!! optional($drhp)->page2_content !!}

                                <div class="d-flex gap-2">
                                    <a href="{{ optional($drhp)->pdf_url ?: '#' }}" target="_blank" rel="noopener" id="drhpConfirm" class="tp-btn tp-btn-white">
                                        <span class="tp-btn-text tp-btn-white">I Confirm</span>
                                        <span class="tp-btn-icon">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    <a href="#" id="drhpDeny" class="tp-btn tp-btn-white">
                                        <span class="tp-btn-text tp-btn-white">I Do Not Confirm</span>
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

    {{-- access denied popup — placed OUTSIDE #smooth-wrapper so the modal/backdrop position correctly (GSAP ScrollSmoother transform trap) --}}
    <div class="modal fade" id="drhpDenyModal" tabindex="-1" aria-labelledby="drhpDenyLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border:none; border-radius:14px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="drhpDenyLabel">Access Restricted</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0" style="font-size:15px; line-height:1.7; color:#444;">
                    You are not permitted to view the materials in this section of the website.
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <a href="{{ route('frontend.index') }}" class="tp-btn tp-btn-white">
                        <span class="tp-btn-text tp-btn-white">Back to Home</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.frontend.main-js')

    <script>
        (function () {
            var deny = document.getElementById('drhpDeny');
            if (deny) {
                deny.addEventListener('click', function (e) {
                    e.preventDefault();
                    var el = document.getElementById('drhpDenyModal');
                    if (window.bootstrap && el) {
                        bootstrap.Modal.getOrCreateInstance(el).show();
                    }
                });
            }

            var confirm = document.getElementById('drhpConfirm');
            if (confirm) {
                confirm.addEventListener('click', function (e) {
                    if (confirm.classList.contains('is-processing')) { e.preventDefault(); return; }
                    confirm.classList.add('is-processing');
                    confirm.style.pointerEvents = 'none';
                    confirm.style.opacity = '0.65';
                    var t = confirm.querySelector('.tp-btn-text');
                    var orig = t ? t.textContent : '';
                    if (t) t.textContent = 'Processing...';
                    // PDF opens in a new tab; re-enable shortly so the button stays usable
                    setTimeout(function () {
                        confirm.classList.remove('is-processing');
                        confirm.style.pointerEvents = '';
                        confirm.style.opacity = '';
                        if (t) t.textContent = orig;
                    }, 3000);
                });
            }
        })();
    </script>

</body>

</html>
