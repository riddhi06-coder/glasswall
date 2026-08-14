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

                  <p>
                    Glass Wall Systems (India) Limited is a premier turnkey façade specialist, delivering integrated
                    design, engineering, manufacturing and installation of façades for commercial, residential and
                    institutional projects. We seamlessly combine in-house design, precision manufacturing and expert
                    on-site execution to build durable, high-performance building façades that create exceptional
                    human-centric spaces.
                  </p>
                  <p>
                    We are headquartered in Mumbai, with a strong business presence in Bangalore, Delhi, NCR, Kolkata,
                    Ahmedabad, Hyderabad and Pune, making us a true Pan India company. We have expanded our operations
                    and expertise to USA, Australia, Israel, Canada, Qatar and Sri Lanka, where we offer a full range of
                    glazing systems and custom-designed architectural metal works, steadfastly pursuing our vision as a
                    leading global exterior façade solutions provider.
                  </p>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="tp-fact-grid">

                <div class="tpfact">
                  <div class="tpfact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"></circle>
                      <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                  </div>
                  <h3 class="tpfact__title">
                    <span class="odometer" data-count="20">0</span>
                    <span class="tpfact__text">M</span>
                    <span class="tpfact__plus">+</span>
                  </h3>
                  <p class="tpfact__label">Square Feet of Façade Work Completed</p>
                </div>

                <div class="tpfact">
                  <div class="tpfact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <line x1="12" y1="1" x2="12" y2="23"></line>
                      <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                  </div>
                  <h3 class="tpfact__title">
                    <span class="odometer" data-count="350">0</span>
                    <span class="tpfact__plus">+</span>
                  </h3>
                  <p class="tpfact__label">Projects Successfully Completed</p>
                </div>

                <div class="tpfact">
                  <div class="tpfact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                      <line x1="3" y1="9" x2="21" y2="9"></line>
                      <line x1="3" y1="15" x2="21" y2="15"></line>
                    </svg>
                  </div>
                  <h3 class="tpfact__title">
                    <span class="odometer" data-count="45">0</span>
                    <span class="tpfact__plus">+</span>
                  </h3>
                  <p class="tpfact__label">Tested Systems</p>
                </div>

                <div class="tpfact">
                  <div class="tpfact__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g><defs><clipPath id="b" clipPathUnits="userSpaceOnUse"><path d="M0 512h512V0H0Z" fill="#1a4685" opacity="1" data-original="#000000"></path></clipPath></defs><mask id="a"><rect width="100%" height="100%" fill="#ffffff" opacity="1" data-original="#ffffff"></rect></mask><g mask="url(#a)"><g clip-path="url(#b)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M0 0a60 60 0 0 0 2.157-16v-100" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(489.843 376)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="round" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path><path d="M0 0c0-33.137-26.863-60-60-60h-352c-33.137 0-60 26.863-60 60v200c0 33.137 26.863 60 60 60h140" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(492 160)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="round" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path><path d="M0 0h180" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(166 20.122)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path><path d="M0 0v80" style="stroke-width:40;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 20.122)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path><path d="M0 0c-13.251 13.304-30.392 20.151-47.673 20.265-17.816.118-35.781-6.903-49.786-20.265-31.643-30.189-18.07-81.325-72.356-102.828 0 0 35.157-26.905 78.543-26.905 34.168 0 64.433 4.938 91.272 31.884C26.913-70.829 26.913-27.02 0 0" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(284.815 310.733)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path><path d="m0 0 114.638 138.51c6.493 8.936 15.992 14.394 26.103 15.995s20.833-.655 29.769-7.148c17.872-12.986 21.833-38.001 8.846-55.873L57-56" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(252 337)" fill="none" stroke="#1a4685" stroke-width="40" stroke-linecap="round" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path></g></g></g>
                        </svg>
                  </div>
                  <h3 class="tpfact__title">
                    <span class="odometer" data-count="500000">0</span>
                    <span class="tpfact__plus">+</span>
                  </h3>
                  <p class="tpfact__label">Square Feet of Design and Manufacturing Floor Space</p>
                </div>

                <div class="tpfact">
                  <div class="tpfact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                      <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                  </div>
                  <h3 class="tpfact__title">
                    <span class="odometer" data-count="1000">0</span>
                    <span class="tpfact__plus">+ <span class="astrick">*</span></span>
                  </h3>
                  <p class="tpfact__label">Experts in various domain <br><span style="font-size: 9px;line-height: 1.6;display: block;    font-weight: 500;letter-spacing: 0;text-transform: capitalize;margin-top: 5px;">( *Including contractual factory and site installation crews)</span></p>
                </div>
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
                        Our Products and Services
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
                        Explore Our Work
                      </h2>
                    </div>
                  </div>

                </div>
              </div>

              <div class="tp-services" id="accordionExample">

                <div class="tp-services-item tp_fade_anim" data-delay=".2" data-duration=".9">
                  <div class="tp-services-header" id="headingOne">
                    <div
                      class="tp-services-button tp-services-button-black"
                      role="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      <div class="tp-services-header">
                        <div class="row tp-align-center">
                          <div class="col-lg-12 col-md-12 col-12">
                            <div class="tp-services-heading-wrap tp-flex-center tp-justify-between">
                              <h3 class="tp-services-title tp-fs-24">Residential Projects</h3>
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
                    id="collapseOne"
                    class="accordion-collapse collapse show"
                    role="region"
                    aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="tp-services-body">
                      <div class="row">

                        <div class="col-xl-4 col-md-5 col-sm-12">
                          <div class="tp-services-img br-20">
                            <img src="assets/images/home/eb1.jpg" alt="Residential Glass Solutions" />
                          </div>
                        </div>

                        <div class="col-xl-8 col-md-7 col-sm-12 align-content-center">
                          <div class="tp-services-content">
                            <div class="tp-services-title-wrap tp-flex tp-justify-between">
                              <h3 class="tp-services-title tp-services-title-larg tp-services-header mb-20">
                                <a href="https://mbihosting.in/glasswall/demo/projects.php?category=residential">Residential Projects</a>
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

                            <a href="https://mbihosting.in/glasswall/demo/projects.php?category=residential" class="tp-btn tp-btn-white">
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

                <div class="tp-services-item tp_fade_anim" data-delay=".2" data-duration=".9">
                  <div class="tp-services-header" id="heading2">
                    <div
                      class="tp-services-button tp-services-button-black collapsed"
                      role="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapse2"
                      aria-expanded="false"
                      aria-controls="collapse2"
                    >
                      <div class="tp-services-header">
                        <div class="row tp-align-center">
                          <div class="col-lg-12 col-12">
                            <div class="tp-services-heading-wrap tp-flex-center tp-justify-between">
                              <h3 class="tp-services-title tp-fs-24">Commercial and Hospitality</h3>
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
                    id="collapse2"
                    class="accordion-collapse collapse"
                    role="region"
                    aria-labelledby="heading2"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="tp-services-body">
                      <div class="row">

                        <div class="col-xl-4 col-md-5 col-sm-12">
                          <div class="tp-services-img br-20">
                            <img src="assets/images/home/Dry-Dock.webp" alt="Commercial and Hospitality Glass" />
                          </div>
                        </div>

                        <div class="col-xl-8 col-md-7 col-sm-12 align-content-center">
                          <div class="tp-services-content">
                            <div class="tp-services-title-wrap tp-flex tp-justify-between">
                              <h3 class="tp-services-title tp-services-title-larg tp-services-header mb-20">
                                <a href="https://mbihosting.in/glasswall/demo/projects.php?category=commercial">Commercial and Hospitality</a>
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

                            <a href="https://mbihosting.in/glasswall/demo/projects.php?category=commercial" class="tp-btn tp-btn-white">
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

                <div class="tp-services-item tp_fade_anim" data-delay=".2" data-duration=".9">
                  <div class="tp-services-header" id="heading3">
                    <div
                      class="tp-services-button tp-services-button-black collapsed"
                      role="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapse3"
                      aria-expanded="false"
                      aria-controls="collapse3"
                    >
                      <div class="tp-services-header">
                        <div class="row tp-align-center">
                          <div class="col-lg-12 col-12">
                            <div class="tp-services-heading-wrap tp-flex-center tp-justify-between">
                              <h3 class="tp-services-title tp-fs-24">International Projects</h3>
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
                    id="collapse3"
                    class="accordion-collapse collapse"
                    role="region"
                    aria-labelledby="heading3"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="tp-services-body">
                      <div class="row">

                        <div class="col-xl-4 col-md-5 col-sm-12">
                          <div class="tp-services-img br-20">
                            <img
                              src="assets/images/home/one-international-center-lower.webp"
                              alt="International Projects"
                            />
                          </div>
                        </div>

                        <div class="col-xl-8 col-md-7 col-sm-12 align-content-center">
                          <div class="tp-services-content">
                            <div class="tp-services-title-wrap tp-flex tp-justify-between">
                              <h3 class="tp-services-title tp-services-title-larg tp-services-header mb-20">
                                <a href="https://mbihosting.in/glasswall/demo/projects.php?category=international">International Projects</a>
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

                            <a href="https://mbihosting.in/glasswall/demo/projects.php?category=international" class="tp-btn tp-btn-white">
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
                        Discover some of our impactful projects.
                      </h2>
                    </div>
                  </div>

                <div class="col-lg-7">
                  <div class="tpportfolio tpportfolio__mr">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/Commercial/rio-google.webp" alt="Indiabulls Blu Project" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=rio-google">Rio – Google</a>
                        </h3>
                        <span class="tpportfolio__date">Bangalore, India</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=rio-google" class="tp-btn">
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

                <div class="col-lg-5">
                  <div class="tpportfolio tpportfolio__transform">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/Commercial/the-capital.jpg" alt="Spark GTIC" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=the-capital">The Capital</a>
                        </h3>
                        <span class="tpportfolio__date">Mumbai, India</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=the-capital" class="tp-btn">
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

                <div class="col-lg-5">
                  <div class="tpportfolio tpportfolio__transform-short">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/Commercial/national-cancer-institute.jpg" alt="One World Center" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=national-cancer-institute">National Cancer Institute</a>
                        </h3>
                        <span class="tpportfolio__date">Nagpur, India</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=national-cancer-institute" class="tp-btn">
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

                <div class="col-lg-7">
                  <div class="tpportfolio tpportfolio__ml tpportfolio__transform-down">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/Commercial/kohinoor-square-tower.jpg" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=kohinoor-square-tower">Kohinoor Squaree</a>
                        </h3>
                        <span class="tpportfolio__date">Mumbai, India</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=kohinoor-square-tower" class="tp-btn">
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

                <div class="col-lg-7">
                  <div class="tpportfolio tpportfolio__mr tpportfolio__transform-space-one">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/International/26-32-jackson-ave.webp" alt="Phoenix Marketcity" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=26-32-jackson-ave">26-32 Jackson Ave</a>
                        </h3>
                        <span class="tpportfolio__date">New York, USA</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=26-32-jackson-ave" class="tp-btn">
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

                <div class="col-lg-5">
                  <div class="tpportfolio tpportfolio__transform tpportfolio__transform-space-two">
                    <div class="tpportfolio__thumb tp-text-center p-relative mb-30">
                      <img src="https://mbihosting.in/glasswall/demo/assets/images/projects/International/albion-music-row.webp" alt="Cyber City" />
                    </div>
                    <div class="tpportfolio__content tp-flex-center tp-justify-between mb-20 ml-30 mr-30">
                      <div class="tpportfolio__content--wrap">
                        <h3 class="tpportfolio__title">
                          <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=albion-music-row">Albion Music Row</a>
                        </h3>
                        <span class="tpportfolio__date">Nashville, TN, USA</span>
                      </div>
                      <a href="https://mbihosting.in/glasswall/demo/project-details.php?slug=albion-music-row" class="tp-btn">
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
              </div>
            </div>
            </div>
          </section>

            <div class="pb-100 partners-wrap">
            <div class="container">
              <div class="tp-brand-text pb-45">

                <div class="col-lg-12 text-center">
                  <h2 class="fw-bold mb-3">We’re privileged to work with leading innovators.</h2>

                  <p>We believe that the reason for our existence and success is the bonds we establish through our collaborations.</p>

                </div>
              </div>
              <div class="swiper tp-brand-active tp-brand-black">
                <div class="swiper-wrapper tp-slide-transtion">
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/1.webp" alt="Brand 1" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/2.webp" alt="Brand 2" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/3.webp" alt="Brand 3" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/4.webp" alt="Brand 4" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/5.webp" alt="Brand 5" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/6.webp" alt="Brand 6" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/7.webp" alt="Brand 7" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/8.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/9.webp" alt="Brand 1" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/10.webp" alt="Brand 2" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/11.webp" alt="Brand 3" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/12.webp" alt="Brand 4" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/13.webp" alt="Brand 5" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/14.webp" alt="Brand 6" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/15.webp" alt="Brand 7" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/16.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/17.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/18.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/19.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/20.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/21.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/22.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/23.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/24.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/25.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/26.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/27.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/28.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/29.webp" alt="Brand 8" />
                    </div>
                  </div>
                  <div class="swiper-slide tp-brand-slide-element">
                    <div class="tp-brand-item">
                      <img src="assets/images/clients/30.webp" alt="Brand 8" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <section class="gws-collaboration-section tp-text-center">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                  <h2 class="fw-bold mb-3">Want to collaborate with GWS for your next project?</h2>

                  <p class="mb-4">Let’s work together to bring your next project to life.</p>

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
                  <h2 class="tp-section-title mb-20 tp_fade_anim" data-delay=".2">Let's grow together - Connect with us on social.
                  </h2>
                </div>
              </div>

              <div class="row">

                <div class="col-md-12">

                    <script src="https://elfsightcdn.com/platform.js" async></script>
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
