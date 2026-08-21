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
                   data-background="{{ optional($banner) && $banner->banner_image ? $banner->assetUrl($banner->banner_image) : asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'Board of Directors' }}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ optional($banner)->banner_heading ?: 'Board of Directors' }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="directors-section">
            <div class="container">
              @if(optional($banner)->banner_description)
                <div class="directors-heading-sec tp-text-center">
                  {!! $banner->banner_description !!}
                </div>
              @endif

              <div class="director-list">
                @forelse($directors as $director)
                  <article class="director">
                    <span class="director-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="row align-items-center">
                      <div class="col-lg-3 col-md-4">
                        <div class="director-figure">
                          <div class="pane">
                            <img src="{{ $director->assetUrl($director->image) }}" alt="{{ $director->name }}" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-9 col-md-8">
                        <div class="director-content tp_fade_anim" data-delay=".2">
                          <h3 class="director-name">{{ $director->name }}</h3>
                          <h4 class="director-design">{{ $director->designation }}</h4>
                          <div class="director-bio">
                            {!! $director->info !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                @empty
                  <p class="tp-text-center">No board members added yet.</p>
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
