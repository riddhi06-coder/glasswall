<!DOCTYPE html>
<html lang="en">

<head>

    @include('components.frontend.head')

    <style>
      .ty-wrap { padding-top: 130px; padding-bottom: 130px; }
      .ty-icon {
        width: 104px; height: 104px; border-radius: 50%;
        background: #e8f7f0; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 30px; box-shadow: 0 10px 30px rgba(10,138,95,.18);
      }
      .ty-icon svg { width: 50px; height: 50px; }
      .ty-wrap p { font-size: 16px; line-height: 1.7; color: #5b6472; }
    </style>

</head>

<body>

    @include('components.frontend.header')

    <div id="smooth-wrapper">
        <div id="smooth-content">

            <main>

                <!-- Hero Start -->
                <section
                    class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
                    data-background="{{ asset('frontend/assets/images/banner/5650.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">

                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">
                                    Thank You
                                </h1>
                            </div>

                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span>
                                    <a href="{{ url('/') }}">Home</a>
                                </span>

                                <span class="tp-breadcrumb-dvdr">-</span>

                                <span>Thank You</span>
                            </div>

                        </div>
                    </div>
                </section>
                <!-- Hero End -->


                <!-- Thank You Body Start -->
                <section class="ty-wrap fix">
                    <div class="container">

                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">

                                <div class="ty-icon">
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#0a8a5f"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="#0a8a5f"
                                            stroke-opacity=".25"></circle>

                                        <path d="M8 12.5l2.5 2.5L16 9"></path>
                                    </svg>
                                </div>

                                <span
                                    class="tp-section-sub-title mb-15 tp_fade_anim"
                                    data-duration=".9">
                                    Submission Received
                                </span>

                                <h2
                                    class="tp-section-title mb-20 tp_fade_anim"
                                    data-duration=".9"
                                    data-delay=".2"
                                    id="tyHeading">
                                    Thank You!
                                </h2>

                                <p class="mb-40" id="tyMessage">
                                    Your submission has been received successfully.
                                    Our team will get back to you shortly.
                                    A confirmation email is on its way to your inbox.
                                </p>

                                <div
                                    class="tp-about-btn tp_fade_anim d-flex justify-content-center"
                                    data-delay=".3">
                                    <a href="{{ url('/') }}" class="tp-btn">

                                        <span class="tp-btn-text">
                                            Back to Home
                                        </span>

                                        <span class="tp-btn-icon">
                                            <svg
                                                width="12"
                                                height="12"
                                                viewBox="0 0 12 12"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.75 10.75L10.75 0.75"
                                                    stroke="currentcolor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round" />

                                                <path
                                                    d="M0.75 0.75H10.75V10.75"
                                                    stroke="currentcolor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>

                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>
                <!-- Thank You Body End -->

            </main>

            @include('components.frontend.footer')

        </div>
    </div>

    @include('components.frontend.main-js')

</body>

</html>