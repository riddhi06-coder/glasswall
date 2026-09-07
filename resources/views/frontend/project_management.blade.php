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
                    data-background="{{ $pm && $pm->banner_image ? $pm->assetUrl($pm->banner_image) : asset('frontend/assets/images/bread/pro-manage.webp') }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($pm)->banner_heading ?: 'Project Management' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span><a href="#">Infrastructure</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($pm)->banner_heading ?: 'Project Management' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="three-cards-wrap position-relative overflow-hidden">
                    <div class="container">

                        <div class="three-cards-intro text-center">
                            <div>{!! optional($pm)->description !!}</div>
                        </div>

                        <div class="row g-4">

                            <!-- Card 1 -->
                            <div class="col-lg-12 col-md-12">

                                <div class="row g-12">
                                    <div class="glass-wall-pointers">

                                        @foreach(optional($pm)->pointers ?? [] as $pointer)
                                            @php
                                                $iconAbs   = $pointer->image ? public_path('project-mgmt/'.$pointer->image) : null;
                                                $iconIsSvg = $pointer->image && strtolower(pathinfo($pointer->image, PATHINFO_EXTENSION)) === 'svg' && is_file($iconAbs);
                                            @endphp
                                            <div class="pointer-card">
                                                @if($iconIsSvg)
                                                    {!! file_get_contents($iconAbs) !!}
                                                @elseif($pointer->image)
                                                    <img src="{{ $pointer->image_url }}" alt="">
                                                @endif
                                                <p>{{ $pointer->pointer }}</p>
                                            </div>
                                        @endforeach

                                    </div>
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