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
                    data-background="{{ $page->banner_image ? $page->banner_image_url : asset('frontend/assets/images/banner/5650.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ $page->heading }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ $page->heading }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="privacy-policy-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="privacy-policy-content">
                                    {!! $page->content !!}
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
