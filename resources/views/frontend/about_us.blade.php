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

          <!-- company hero -->
          <section class="company-hero position-relative overflow-hidden">
            <video class="company-hero-video" autoplay muted loop playsinline preload="auto">
              <source src="{{ optional($about) && $about->banner_video ? $about->assetUrl($about->banner_video) : asset('frontend/assets/images/video/GlassWallSystems-video.mp4') }}" type="video/mp4" />
              Your browser does not support the video tag.
            </video>

            <div class="company-hero-overlay"></div>

            <div class="container h-100 position-relative">
              <div class="row h-100 align-items-end">
                <div class="col-lg-8 col-md-10">
                  <div class="company-hero-content">
                    <h1 class="company-name">{{ optional($about)->banner_heading ?: 'Glass Wall Systems (India) Limited' }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- about area -->
          <section class="tp-about-area tp-about-spacing-3 tp_fade_line_wrap p-relative fix">
            <div class="tp-about-shape-home p-absolute d-none d-md-block tp_fade_anim"
                 data-fade-from="right" data-delay=".7" data-duration="3" data-fade-offset="200">
              <img src="{{ asset('frontend/assets/images/about-shape-home.webp') }}" alt="" />
            </div>
            <div class="container">
              <div class="tp-about-heading pb-70 tp-text-center">
                <h2 class="tp-section-title margin-0 reval-line">{{ optional($about)->section_heading ?: 'Building future architectural marvels, today.' }}</h2>
              </div>

              <div class="row align-items-center">
                <div class="col-lg-6 d-flex align-items-center">
                  <div class="tp-about-image p-relative w-100">
                    <img class="w-100 br-20" src="{{ optional($about) && $about->section_image ? $about->assetUrl($about->section_image) : asset('frontend/assets/images/home/Gulita.webp') }}" alt="{{ optional($about)->section_heading }}" />
                  </div>
                </div>

                <div class="col-lg-6 d-flex align-items-center">
                  <div class="tp-about-content tp-about-content-2 w-100">
                    <div class="tp-about-deg tp-about-deg-2 tp-about-deg-border tp_fade_anim" data-delay=".3">
                      {!! optional($about)->description !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- vision / mission -->
          <section class="tp-services-area pt-0 fix">
            <div class="container">
              <div class="tp-about-heading tp-text-center">
                <div class="col-lg-12">
                  <h2 class="tp-section-title margin-0 reval-line mb-60 pb-40">{{ optional($about)->vision_section_heading ?: 'Our Value System Drives Our Behaviours' }}</h2>
                  <div>{!! optional($about)->vision_section_description !!}</div>
                </div>
              </div>

              <div class="vmv-section">
                <div class="container">
                  <ul class="nav vmv-tabs justify-content-center">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#vision">
                        <span class="tab-icon">
                          <img src="{{ optional($about) && $about->vision_logo ? $about->assetUrl($about->vision_logo) : asset('frontend/assets/images/icons/vision.svg') }}" alt="Vision" />
                        </span>
                        <span>{{ optional($about)->vision_title ?: 'Vision' }}</span>
                      </button>
                    </li>

                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="pill" data-bs-target="#mission">
                        <span class="tab-icon">
                          <img src="{{ optional($about) && $about->mission_logo ? $about->assetUrl($about->mission_logo) : asset('frontend/assets/images/icons/mission.svg') }}" alt="Mission" />
                        </span>
                        <span>{{ optional($about)->mission_title ?: 'Mission' }}</span>
                      </button>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="vision">
                      <div class="vmv-card vision-card">
                        <div class="row align-items-center">
                          <div class="col-lg-7">
                            <span class="vmv-bg-text">{{ strtoupper(optional($about)->vision_title ?: 'Vision') }}</span>
                            <h2>{{ optional($about)->vision_heading ?: 'Our Vision' }}</h2>
                            <div>{!! optional($about)->vision_desc !!}</div>
                          </div>

                          <div class="col-lg-5 text-center">
                            <img src="{{ optional($about) && $about->vision_image ? $about->assetUrl($about->vision_image) : asset('frontend/assets/images/about/vision/glasswall-corner.png') }}" class="img-fluid" alt="Vision" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="mission">
                      <div class="vmv-card mission-card">
                        <div class="row align-items-center">
                          <div class="col-lg-7">
                            <span class="vmv-bg-text">{{ strtoupper(optional($about)->mission_title ?: 'Mission') }}</span>
                            <h2>{{ optional($about)->mission_heading ?: 'Our Mission' }}</h2>
                            <div>{!! optional($about)->mission_desc !!}</div>
                          </div>

                          <div class="col-lg-5 text-center">
                            <img src="{{ optional($about) && $about->mission_image ? $about->assetUrl($about->mission_image) : asset('frontend/assets/images/about/vision/glasswall-skyscraper.png') }}" class="img-fluid" alt="Mission" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- core values -->
          <section class="infoimg">
            <div class="container">
              <div class="tp-about-heading tp-text-center">
                <div class="col-lg-12">
                  <h2 class="tp-section-title margin-0 reval-line mb-60">{{ optional($about)->core_title ?: 'Core Values' }}</h2>
                  <div>{!! optional($about)->core_description !!}</div>
                </div>
              </div>
              <div class="tp-text-center">
                <div class="value-img">
                  <img src="{{ optional($about) && $about->core_image ? $about->assetUrl($about->core_image) : asset('frontend/assets/images/home/value2.webp') }}" alt="Core Values" />
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
