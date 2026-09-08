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
            data-background="{{ asset('frontend/assets/images/products.webp') }}"
          >
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                  <div class="page-heading">
                <h1 class="tp-breadcrumb-title tp-text-white margin-0">Our Projects</h1>
                </div>

                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>Our Projects</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="product-section">
            <div class="container">
              <!-- Heading -->

              <div class="row align-items-center mb-5">
                <div class="col-lg-12">
                  <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                    <span class="tp-section-sub-title mb-15">Our Projects</span>
                    <h2 class="tp-section-title mb-25">Explore Our Projects</h2>
                    <div class="mt- section-heading">
                      <p class="sub-title">
                        Explore our portfolio of landmark façade projects across residential, commercial, hospitality and international developments.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Grid -->

              <div class="row g-4">
                @forelse($categories as $category)
                  <div class="col-lg-4">
                    <article class="product-card large">
                      <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}" />

                      <div class="overlay"></div>

                      <div class="shine"></div>

                      <div class="card-content">
                        <h3>{{ $category->name }}</h3>

                        <a href="{{ route('frontend.projects', $category->slug) }}">
                          Learn More

                          <i class="fa-solid fa-arrow-right"></i>
                        </a>
                      </div>

                      <div class="arrow">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                      </div>
                    </article>
                  </div>
                @empty
                  <div class="col-12 text-center">
                    <p>No project categories available yet.</p>
                  </div>
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
