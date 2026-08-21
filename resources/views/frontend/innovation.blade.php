<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')

    <style>
        /* Feature list items use the checklist icon as their bullet. */
        .tpportpost__meta ul,
        .tpportpost__meta ol { list-style: none; padding-left: 0; margin: 0; }
        .tpportpost__meta li {
            position: relative;
            padding-left: 32px;
            margin-bottom: 12px;
            line-height: 1.55;
        }
        .tpportpost__meta li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 3px;
            width: 20px;
            height: 20px;
            background: url('{{ asset('frontend/assets/images/icons/checklist.svg') }}') no-repeat center;
            background-size: contain;
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
                   data-background="{{ optional($banner) && $banner->banner_image ? $banner->assetUrl($banner->banner_image) : asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'Innovation' }}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ optional($banner)->banner_heading ?: 'Innovation' }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="tp-project-area default-margin tp-project-spacing fix">
            <div class="container">
              <div class="tp-portfolio-posts">
                @forelse($innovations as $innovation)
                  <div class="tpportpost mb-25 tp_fade_anim" data-delay=".2">
                    <div class="tpportpost__info">
                      <div class="tpportpost__content">
                        <h2 class="tpportpost__title">{{ $innovation->heading }}</h2>
                      </div>
                      <div class="tpportpost__meta">
                        {!! $innovation->feature !!}
                      </div>
                    </div>
                    <div class="tpportpost__thumb p-relative">
                      <img src="{{ $innovation->assetUrl($innovation->image) }}" alt="{{ $innovation->heading }}" />
                    </div>
                  </div>
                @empty
                  <p class="tp-text-center">No innovations added yet.</p>
                @endforelse
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
