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

          <section class="tp-hero-slider-area p-relative">
      
            <div class="swiper tp-hero-slider-active">
              <div class="swiper-wrapper">
                @foreach($banners as $banner)
                  @php $mediaUrl = asset('home/bannerimagevideo/'.$banner->banner_media); @endphp
                  <div class="swiper-slide">
                    <div class="tp-hero-slider {{ $banner->media_type === 'image' ? 'tp-bg' : '' }} tp-overlay-3"
                      @if($banner->media_type === 'image') data-background="{{ $mediaUrl }}" @endif>
                      @if($banner->media_type === 'video')
                        <video class="tp-hero-slider-video" autoplay muted loop playsinline
                          style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;">
                          <source src="{{ $mediaUrl }}">
                        </video>
                      @endif
                      <div class="container">
                        <div class="row align-items-center min-vh-100">
                          <div class="col-lg-6 col-md-6">
                            <div class="tp-hero-slider-main">
                              <div class="tp-hero-slider-content">
                                <h1 class="tp-hero-slider-title tp-section-title tp-section-title-larg tp-text-white">
                                  {!! $banner->banner_heading !!}
                                </h1>
                                <div class="tp-hero-slider-btn pt-25">
                                  <p class="margin-0 tp-text-white fw-500 pb-50">{{ $banner->banner_title }}</p>
                                  <a href="#" class="tp-btn">
                                    <span class="tp-btn-text">Explore Our Work</span>
                                    <span class="tp-btn-icon">
                                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                      </svg>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="tp-hero-slider-pagination d-none d-md-flex"></div>
            </div>
          </section>

          <section class="tp-about-area home-us-about tp-about-spacing-3 tp_fade_line_wrap p-relative fix">
            <div
              class="tp-about-shape-home p-absolute d-none d-md-block tp_fade_anim"
              data-fade-from="right"
              data-delay=".7"
              data-duration="3"
              data-fade-offset="200"
            >
              <img src="assets/images/about-shape-home.webp" alt="" />
            </div>
            <div class="container">
              <div class="tp-about-heading tp-text-center">
                <div class="col-lg-12">
                  @if(optional($about)->description)
                    {!! $about->description !!}
                  @endif
                </div>
              </div>
            </div>
            <div class="container">
              <div class="tp-fact-grid">
                @foreach(optional($about)->milestones ?? [] as $m)
                    @php
                      // Count is free text (e.g. "20M+", "500,000+"). Strip stray spaces,
                      // then split the leading number (keep commas) from the suffix (M+, +, *).
                      $rawCount = preg_replace('/\s+/', '', (string) $m->count);
                      preg_match('/^([\d.,]+)(.*)$/', $rawCount, $mm);
                      $num = $mm[1] ?? $rawCount;
                      $suffix = $mm[2] ?? '';
                    @endphp
                    <div class="tpfact">
                      <div class="tpfact__icon">
                        <img src="{{ asset('home/aboutmilestones/'.$m->icon) }}" alt="" style="max-height:60px;" />
                      </div>
                      <h3 class="tpfact__title">
                        <span class="odometer" data-count="{{ $num }}">0</span>
                        @if($suffix)<span class="tpfact__plus">{{ $suffix }}</span>@endif
                      </h3>
                      <p class="tpfact__label">{{ $m->milestone }}</p>
                    </div>
                @endforeach
              </div>
            </div>
          </section>

          <section class="tp-services-area home-service tp-services-spacing-4 fix">
            <div class="container">
              <div class="tp-services-heading">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <div class="tp-section-title-wrap tp-text-center">
                      <span class="tp-section-sub-title mb-15 tp_fade_anim" data-duration=".9">Our Products</span>
                      <h2 class="tp-section-title tp_fade_anim" data-duration=".9" data-delay=".2">
                        {{ optional($clientele)->product_section_heading ?? 'Our Products and Services' }}
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row tpservices2__up tp-justify-center tp-align-center">
                <div class="col-lg-4 col-md-10 col-sm-10 tp_fade_anim" data-duration=".9" data-delay=".1">
                  <div class="tpservices2 p-relative mb-30">
                    <div class="tpservices2__thumb br-15 mb-40">
                      <img src="assets/images/products/home-product/1.webp" alt="" />
                    </div>
                    <div class="tpservices2__main">
                      <div class="tpservices2__icon mb-25">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M8 52V8H52V52" stroke="currentColor" stroke-width="2" />
                          <path d="M8 20H52M8 32H52M8 44H52" stroke="currentColor" stroke-width="2" />
                          <path d="M20 8V52M32 8V52M44 8V52" stroke="currentColor" stroke-width="2" />
                          <path d="M4 56H56" stroke="currentColor" stroke-width="2" />
                        </svg>
                      </div>
                      <div class="tpservices2__content">
                        <h3 class="tpservices2__title tp-fs-20 mb-10">
                          <a href="facade-and-curtain-wall-systems.html">Façade and Curtain Wall Systems</a>
                        </h3>
                      </div>
                    </div>
                    <div class="tpservices2__link">
                      <a href="facade-and-curtain-wall-systems.html" class="tpservices2__btn">
                        <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M0.000408173 7.39795H16.7596"
                            stroke="currentcolor"
                            stroke-width="1.5"
                            stroke-miterlimit="10"
                          />
                          <path
                            d="M10.1596 0C10.1596 4.08932 13.6667 7.39831 18.0008 7.39831"
                            stroke="currentcolor"
                            stroke-width="1.5"
                            stroke-miterlimit="10"
                          />
                          <path
                            d="M18.0008 7.39807C13.6667 7.39807 10.1596 10.7071 10.1596 14.7964"
                            stroke="currentcolor"
                            stroke-width="1.5"
                            stroke-miterlimit="10"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-10 col-sm-10">
                  <div class="tp_fade_anim" data-duration=".9" data-delay=".2">
                    <div class="tpservices2 p-relative mb-30">
                      <div class="tpservices2__thumb br-15 mb-40">
                        <img src="assets/images/products/home-product/2.webp" alt="" />
                      </div>
                      <div class="tpservices2__main">
                        <div class="tpservices2__icon mb-25">
                          <svg
                            width="60"
                            height="60"
                            viewBox="0 0 60 60"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path d="M8 12H52" stroke="currentColor" stroke-width="2" />
                            <path d="M8 22H52" stroke="currentColor" stroke-width="2" />
                            <path d="M8 32H52" stroke="currentColor" stroke-width="2" />
                            <path d="M8 42H52" stroke="currentColor" stroke-width="2" />
                            <path d="M8 52H52" stroke="currentColor" stroke-width="2" />
                            <path
                              d="M14 12L8 18M26 12L20 18M38 12L32 18M50 12L44 18"
                              stroke="currentColor"
                              stroke-width="2"
                            />
                          </svg>
                        </div>
                        <div class="tpservices2__content">
                          <h3 class="tpservices2__title tp-fs-20 mb-10"><a href="louvers.html">Louvers</a></h3>
                        </div>
                      </div>
                      <div class="tpservices2__link">
                        <a href="louvers.html" class="tpservices2__btn">
                          <svg
                            width="18"
                            height="15"
                            viewBox="0 0 18 15"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M0.000408173 7.39795H16.7596"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                            <path
                              d="M10.1596 0C10.1596 4.08932 13.6667 7.39831 18.0008 7.39831"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                            <path
                              d="M18.0008 7.39807C13.6667 7.39807 10.1596 10.7071 10.1596 14.7964"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-10 col-sm-10">
                  <div class="tp_fade_anim" data-duration=".9" data-delay=".2">
                    <div class="tpservices2 p-relative mb-30">
                      <div class="tpservices2__thumb br-15 mb-40">
                        <img src="assets/images/products/home-product/3.webp" alt="" />
                      </div>
                      <div class="tpservices2__main">
                        <div class="tpservices2__icon mb-25">
                          <svg
                            width="60"
                            height="60"
                            viewBox="0 0 60 60"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path d="M10 52V8H50V52" stroke="currentColor" stroke-width="2" />
                            <path d="M10 18H50M10 30H50M10 42H50" stroke="currentColor" stroke-width="2" />
                            <path d="M20 8V18M40 8V18M20 30V42M40 30V42" stroke="currentColor" stroke-width="2" />
                            <path d="M6 56H54" stroke="currentColor" stroke-width="2" />
                            <path d="M16 2L12 8M30 2L26 8M44 2L40 8" stroke="currentColor" stroke-width="2" />
                          </svg>
                        </div>
                        <div class="tpservices2__content">
                          <h3 class="tpservices2__title tp-fs-20 mb-10">
                            <a href="rain-screen-cladding.html">Rain Screen Cladding</a>
                          </h3>
                        </div>
                      </div>
                      <div class="tpservices2__link">
                        <a href="rain-screen-cladding.html" class="tpservices2__btn">
                          <svg
                            width="18"
                            height="15"
                            viewBox="0 0 18 15"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M0.000408173 7.39795H16.7596"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                            <path
                              d="M10.1596 0C10.1596 4.08932 13.6667 7.39831 18.0008 7.39831"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                            <path
                              d="M18.0008 7.39807C13.6667 7.39807 10.1596 10.7071 10.1596 14.7964"
                              stroke="currentcolor"
                              stroke-width="1.5"
                              stroke-miterlimit="10"
                            />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section class="tp-services-area default-margin tp-services-spacing tp-bg-gray fix">
            <div class="container">
              <div class="tp-services-heading mb-60">
                <div class="row tp-align-end">
                  <div class="col-md-12">
                    <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                      <span class="tp-section-sub-title mb-15">Our Services</span>
                      <h2 class="tp-section-title mb-20">
                        {{ optional($clientele)->work_section_heading ?? 'Explore Our Work' }}
                      </h2>
                    </div>
                  </div>

                </div>
              </div>

              <div class="tp-services" id="accordionExample">

                @foreach($categories as $category)
                <div class="tp-services-item tp_fade_anim" data-delay=".2" data-duration=".9">
                  <div class="tp-services-header" id="heading{{ $loop->iteration }}">
                    <div
                      class="tp-services-button tp-services-button-black @unless($loop->first) collapsed @endunless"
                      role="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapse{{ $loop->iteration }}"
                      aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                      aria-controls="collapse{{ $loop->iteration }}"
                    >
                      <div class="tp-services-header">
                        <div class="row tp-align-center">
                          <div class="col-lg-12 col-md-12 col-12">
                            <div class="tp-services-heading-wrap tp-flex-center tp-justify-between">
                              <h3 class="tp-services-title tp-fs-24">{{ $category->name }}</h3>
                              <svg
                                width="14"
                                height="14"
                                viewBox="0 0 14 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M7.00002 14C6.47458 14 6.04883 13.5742 6.04883 13.0488V0.95119C6.04883 0.425753 6.47458 0 7.00002 0C7.52546 0 7.95121 0.425753 7.95121 0.95119V13.0488C7.95121 13.5742 7.52546 14 7.00002 14Z"
                                  fill="#000"
                                />
                                <path
                                  d="M13.0488 7.95121H0.95119C0.425753 7.95121 0 7.52546 0 7.00002C0 6.47458 0.425753 6.04883 0.95119 6.04883H13.0488C13.5742 6.04883 14 6.47458 14 7.00002C14 7.52546 13.5742 7.95121 13.0488 7.95121Z"
                                  fill="#000"
                                />
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div
                    id="collapse{{ $loop->iteration }}"
                    class="accordion-collapse collapse @if($loop->first) show @endif"
                    role="region"
                    aria-labelledby="heading{{ $loop->iteration }}"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="tp-services-body">
                      <div class="row">

                        <div class="col-xl-4 col-md-5 col-sm-12">
                          <div class="tp-services-img br-20">
                            <img src="{{ $category->thumbnail_url ?? asset('frontend/assets/images/home/eb1.jpg') }}" alt="{{ $category->name }}" />
                          </div>
                        </div>

                        <div class="col-xl-8 col-md-7 col-sm-12 align-content-center">
                          <div class="tp-services-content">
                            <div class="tp-services-title-wrap tp-flex tp-justify-between">
                              <h3 class="tp-services-title tp-services-title-larg tp-services-header mb-20">
                                <a href="{{ route('frontend.projects', $category->slug) }}">{{ $category->name }}</a>
                              </h3>
                              <svg
                                width="14"
                                height="2"
                                viewBox="0 0 14 2"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M13.0488 1.90238H0.95119C0.425753 1.90238 0 1.47663 0 0.95119C0 0.425753 0.425753 0 0.95119 0H13.0488C13.5742 0 14 0.425753 14 0.95119C14 1.47663 13.5742 1.90238 13.0488 1.90238Z"
                                  fill="black"
                                />
                              </svg>
                            </div>

                            <a href="{{ route('frontend.projects', $category->slug) }}" class="tp-btn tp-btn-white">
                                <span class="tp-btn-text tp-btn-white">Know More</span>
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
                  </div>
                </div>
                @endforeach

              </div>
            </div>
          </section>

          <section class="tp-portfolio-area tp-portfolio-spacing tp-portfolio-spacing-2 portfolio-area fix">
            <div class="container p-relative">
              <div class="row">
                  <div class="row tp-align-end">
                  <div class="col-md-12">
                    <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                      <h2 class="tp-section-title mb-50">
                        {{ optional($clientele)->project_section_heading ?? 'Discover some of our impactful projects.' }}
                      </h2>
                    </div>
                  </div>

                @php
                    // Staggered layout slots that match the theme's portfolio design.
                    $portfolioLayouts = [
                        ['col' => 'col-lg-7', 'wrap' => 'tpportfolio tpportfolio__mr'],
                        ['col' => 'col-lg-5', 'wrap' => 'tpportfolio tpportfolio__transform'],
                        ['col' => 'col-lg-5', 'wrap' => 'tpportfolio tpportfolio__transform-short'],
                        ['col' => 'col-lg-7', 'wrap' => 'tpportfolio tpportfolio__ml tpportfolio__transform-down'],
                        ['col' => 'col-lg-7', 'wrap' => 'tpportfolio tpportfolio__mr tpportfolio__transform-space-one'],
                        ['col' => 'col-lg-5', 'wrap' => 'tpportfolio tpportfolio__transform tpportfolio__transform-space-two'],
                    ];
                @endphp

                @foreach($homeProjects as $project)
                    @php $layout = $portfolioLayouts[$loop->index % count($portfolioLayouts)]; @endphp
                    <div class="{{ $layout['col'] }}">
                      <div class="{{ $layout['wrap'] }}">
                        <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                          <img src="{{ $project->thumbnail_url }}" alt="{{ $project->name }}" />
                        </div>
                        <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                          <div class="tpportfolio__content--wrap">
                            <h3 class="tpportfolio__title">
                              <a href="{{ route('frontend.projects', optional($project->category)->slug) }}">{{ $project->name }}</a>
                            </h3>
                            <span class="tpportfolio__date">{{ $project->location }}</span>
                          </div>
                          <a href="{{ route('frontend.projects', optional($project->category)->slug) }}" class="tp-btn">
                          <span class="tp-btn-text">Explore More</span>

                          <span class="tp-btn-icon">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                              <path
                                d="M0.75 10.75L10.75 0.75"
                                stroke="currentcolor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M0.75 0.75H10.75V10.75"
                                stroke="currentcolor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                            </svg>
                          </span>
                        </a>
                        </div>
                      </div>
                    </div>
                @endforeach
              </div>
            </div>
            </div>
          </section>

          <div class="pb-100 partners-wrap">
            <div class="container">
              <div class="tp-brand-text pb-45">

                <div class="col-lg-12 text-center">
                  <h2 class="fw-bold mb-3">{{ optional($clientele)->clientele_section_heading ?? 'We’re privileged to work with leading innovators.' }}</h2>

                  @if(optional($clientele)->clientele_section_desc)
                    {!! $clientele->clientele_section_desc !!}
                  @else
                  <p>We believe that the reason for our existence and success is the bonds we establish through our collaborations.</p>
                  @endif

                </div>
              </div>
              <div class="swiper tp-brand-active tp-brand-black">
                <div class="swiper-wrapper tp-slide-transtion">
                  @foreach(optional($clientele)->images ?? [] as $img)
                    <div class="swiper-slide tp-brand-slide-element">
                      <div class="tp-brand-item">
                        <img src="{{ asset('home/clienteleimages/'.$img->image) }}" alt="Client" />
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <section class="gws-collaboration-section tp-text-center">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                  <h2 class="fw-bold mb-3">{{ optional($clientele)->collaboration_section_heading ?? 'Want to collaborate with GWS for your next project?' }}</h2>

                  <p class="mb-4">{{ optional($clientele)->collaboration_section_title ?? 'Let’s work together to bring your next project to life.' }}</p>

                  <div class="tp-about-btn tp_fade_anim d-flex justify-content-center" data-delay=".3">
                    <a href="/contact-us/" class="tp-btn">
                      <span class="tp-btn-text">Get in Touch</span>

                      <span class="tp-btn-icon">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                          <path
                            d="M0.75 10.75L10.75 0.75"
                            stroke="currentcolor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                          <path
                            d="M0.75 0.75H10.75V10.75"
                            stroke="currentcolor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section class="tp-postbox-area tp-postbox-spacing fix">
            <div class="container">
              <div class="tp-blog-heading mb-70">
                <div class="tp-section-title-wrap tp-text-center">
                  <span class="tp-section-sub-title mb-12 tp_fade_anim">Latest Insights</span>
                  <h2 class="tp-section-title mb-20 tp_fade_anim" data-delay=".2">{{ optional($blog)->section_heading ?? "Let's grow together - Connect with us on social." }}
                  </h2>
                </div>
              </div>

              <div class="row">

                <div class="col-md-12">
                    <script src="{{ optional($blog)->api_link ?? 'https://elfsightcdn.com/platform.js' }}" async></script>
                    <div class="elfsight-app-906929a6-8d58-4c4c-975d-c93289ffce3b" data-elfsight-app-lazy></div>
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
