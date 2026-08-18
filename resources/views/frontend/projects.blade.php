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
          <section class="tp-breadcrumb-area tp-bg tp-overlay p-relative" data-background="{{ asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">Our Projects</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ $category->name }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <!-- projects-area (masonry) start -->
          <section class="tp-services-area tp-services-spacing-4 fix">
            <div class="container">
              <div class="tp-services-heading">
                <div class="row">
                  <div class="col-md-12 col-sm-12 text-center">
                    <div class="tp-section-title-wrap">
                      <span class="tp-section-sub-title mb-15 tp_fade_anim" data-duration=".9">Our Projects</span>
                      <h2 class="tp-section-title tp_fade_anim" data-duration=".9" data-delay=".2">Explore {{ $category->name }}</h2>
                    </div>
                  </div>
                </div>
              </div>

              @php
                // Varied thumbnail heights to preserve the masonry look.
                $thumbHeights = [420, 280, 340, 260, 400, 320, 270, 410, 330, 300, 360, 290];
              @endphp

              <!-- Isotope grid wrapper -->
              <div class="row tp-project-masonry-grid">
                <div class="grid-sizer col-lg-4 col-md-6 col-sm-6"></div>

                @forelse($projects as $project)
                  @php $h = $thumbHeights[$loop->index % count($thumbHeights)]; @endphp
                  <div class="grid-item col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="tpservices2 p-relative">
                      <div class="tpservices2__thumb br-15 mb-40">
                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->name }}" class="project-thumb-img" style="height: {{ $h }}px;">
                      </div>
                      <div class="tpservices2__main">
                        <div class="tpservices2__content">
                          <h3 class="tpservices2__title tp-fs-24 mb-10">
                            <a href="{{ route('frontend.projects_details', ['category' => $category->slug, 'project' => $project->slug]) }}">{{ $project->name }}</a>
                          </h3>
                          @if($project->location)
                            <span class="tpportfolio__date">{{ $project->location }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="tpservices2__link">
                        <a href="{{ route('frontend.projects_details', ['category' => $category->slug, 'project' => $project->slug]) }}" class="tpservices2__btn" aria-label="View {{ $project->name }}">
                          <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.000408173 7.39795H16.7596" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"/>
                            <path d="M10.1596 0C10.1596 4.08932 13.6667 7.39831 18.0008 7.39831" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"/>
                            <path d="M18.0008 7.39807C13.6667 7.39807 10.1596 10.7071 10.1596 14.7964" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"/>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="col-12 text-center">
                    <p>No projects available in this category yet.</p>
                  </div>
                @endforelse

              </div>
            </div>
          </section>
          <!-- projects-area (masonry) end -->

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

  </body>
</html>
