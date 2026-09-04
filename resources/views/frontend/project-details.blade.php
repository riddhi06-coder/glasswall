<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')

    <style>
      /* Uniform project image frame on the detail page */
      /* Landscape images: fill the banner, trim the sky */
      .tp-project-details-info img {
        width: 100%;
        height: clamp(260px, 34vw, 460px);
        object-fit: cover;
        object-position: center 62%;
        border-radius: 20px;
        display: block;
      }
      /* Portrait images (tall buildings): show the WHOLE building, tall and centered */
      .tp-project-details-info.is-portrait { text-align: center; }
      .tp-project-details-info.is-portrait img {
        width: auto;
        max-width: 100%;
        height: clamp(420px, 64vw, 720px);
        object-fit: contain;
        margin: 0 auto;
        border-radius: 20px;
        display: inline-block;
      }
      @media (max-width: 767px) {
        .tp-project-details-info img { height: 240px; }
        .tp-project-details-info.is-portrait img { height: 60vh; }
      }
    </style>

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
              @php
                  // Resolve the displayed image and its on-disk path so tall (portrait)
                  // images can be shown in full instead of being cropped.
                  if ($detail && $detail->image) {
                      $detailImgUrl  = $detail->image_url;
                      $detailImgPath = public_path('project/details/'.$detail->image);
                  } else {
                      $detailImgUrl  = $project->thumbnail_url;
                      $detailImgPath = $project->thumbnail ? public_path('project/listings/'.$project->thumbnail) : null;
                  }
                  $isPortrait = false;
                  if ($detailImgPath && is_file($detailImgPath)) {
                      $dim = @getimagesize($detailImgPath);
                      if ($dim && !empty($dim[0]) && $dim[1] > $dim[0]) {
                          $isPortrait = true;
                      }
                  }
              @endphp

              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="tp-project-details-info br-20 mb-40 text-center {{ $isPortrait ? 'is-portrait' : '' }}">
                    <img src="{{ $detailImgUrl }}" alt="{{ $project->name }}" class="w-100 br-20" />
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

              <div class="row justify-content-center">
                <div class="col-lg-10 text-center pt-40">
                  <div class="tp-about-btn tp_fade_anim d-flex justify-content-center" data-delay=".3">
                    <a href="{{ route('frontend.projects', $category->slug) }}" class="tp-btn">
                      <span class="tp-btn-text">Back to {{ $category->name }}</span>
                      <span class="tp-btn-icon">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                          <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
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
