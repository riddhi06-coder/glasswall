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
          <section class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
                   data-background="{{ optional($detail)->banner_image_url ?? asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container h-100">
              <div class="tp-breadcrumb pb-50" style="min-height:520px; position:relative;">

                <!-- Center Title -->
                <h1 class="tp-breadcrumb-title tp-text-white margin-0"
                    style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:100%; text-align:center;">
                  {{ $project->name }}
                </h1>

                <!-- Breadcrumb Bottom Left -->
                <div class="tp-breadcrumb-menu tp-flex-center"
                     style="position:absolute; bottom:35px; left:0; margin:0;">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>Our Projects</span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span><a href="{{ route('frontend.projects', $category->slug) }}">{{ $category->name }}</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ $project->name }}</span>
                </div>

              </div>
            </div>
          </section>
          <!-- hero area end -->

          <!-- project-details-area,start  -->
          <section class="tp-project-details-area pt-150 pb-100 tp-project-spacing fix">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="tp-project-details-info br-20 mb-40 text-center">
                    <img src="{{ optional($detail)->image_url ?? $project->thumbnail_url }}" alt="{{ $project->name }}" class="w-100 br-20"
                         style="aspect-ratio: 3 / 2; object-fit: cover;" />
                  </div>
                </div>
              </div>

              <div class="tp-project-des">
                <div class="tp-project-about-main">
                  <div class="row">
                    <div class="col-xl-12">
                      <div class="tp-project-about-wrap tp-flex-center flex-wrap">

                        @php
                          $info = [
                              'Location'     => $project->location,
                              'Client'       => optional($detail)->client,
                              'Architect'    => optional($detail)->architect,
                              'Consultant'   => optional($detail)->consultant,
                              'Project Type' => $category->name,
                              'Façade Area'  => optional($detail)->project_area,
                              'Year'         => optional($detail)->year,
                          ];
                        @endphp

                        @foreach($info as $label => $value)
                          <div class="tp-project-about">
                            <div class="tp-project-details-info-content">
                              <span class="d-inline-block fw-500 lh-1">{{ $label }}</span>
                              <h4 class="tp-project-details-info-title margin-0 lh-1">
                                {{ (blank($value) || $value === 'N/A') ? '-' : $value }}
                              </h4>
                            </div>
                          </div>
                        @endforeach

                      </div>
                    </div>
                  </div>
                </div>

                @if($detail && !empty($detail->scope_of_work) && $detail->scope_of_work !== ['N/A'])
                  <div class="tp-project-feature pt-40 border-top">
                    <h3 class="tp-project-details-title mb-35 tp-text-center">Scope of Work</h3>
                    <div class="tp-project-feature-main tp-bg-gray br-20">
                      <div class="tp-project-feature-wrap tp-flex-center justify-content-center tp_fade_anim" data-dure=".9">
                        @foreach($detail->scope_of_work as $scope)
                          <div class="tp-project-feature-item">
                            <span class="d-inline-block tp-text-black"> {{ $scope }}</span>
                            <span class="tp-project-feature-dot"></span>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endif

              </div>
            </div>
          </section>
          <!-- project-details-area,end  -->

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

  </body>
</html>
