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
                    data-background="{{ $resource && $resource->banner_image ? $resource->assetUrl($resource->banner_image) : asset('frontend/assets/images/bread/ir.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($resource)->banner_heading ?: 'Investor Resources' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>Investors Relations</span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($resource)->banner_heading ?: 'Investor Resources' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="design-info-wrap">
                    <div class="container">
                        @if($resource)
                        <div class="design-info">
                            <div class="design-info-header">
                                <div class="design-info-person-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div>
                                    <h2>{{ $resource->name }}</h2>
                                    <p>{{ $resource->designation }}</p>
                                </div>
                            </div>
                            <div class="design-info-content">
                                <div class="design-info-left">
                                    <div class="design-info-item">
                                        <div class="design-info-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div>
                                            <span>Call</span>
                                            <a href="tel:{{ preg_replace('/\s+/', '', $resource->phone) }}">{{ $resource->phone }}</a>
                                        </div>
                                    </div>
                                    <div class="design-info-item">
                                        <div class="design-info-icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div>
                                            <span>Email Id</span>
                                            <a href="mailto:{{ $resource->email }}">{{ $resource->email }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="design-info-right">
                                    <div class="design-info-item">
                                        <div class="design-info-icon">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div>
                                            <span>{{ $resource->company_name }}</span>
                                            <p>{{ $resource->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

            </main>

            @include('components.frontend.footer')
        </div>
    </div>

    @include('components.frontend.main-js')

</body>

</html>
