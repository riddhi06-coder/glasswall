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
                <h1 class="tp-breadcrumb-title tp-text-white margin-0">Our Products</h1>
                </div>

                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span><a href="{{ route('frontend.products_category_listing') }}">Our Products</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ $category->name }}</span>
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
                    <span class="tp-section-sub-title mb-15">Our Services</span>
                    <h2 class="tp-section-title mb-25">{{ $category->name }}</h2>
                    @if($category->short_description)
                      <div class="mt- section-heading">
                        <p class="sub-title">{{ $category->short_description }}</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Grid -->

              <div class="row g-4">
                @forelse($products as $product)
                  <div class="col-lg-4">
                    <article class="product-card large">
                      <img src="{{ $product->image_url }}" alt="{{ $product->name }}" />

                      <div class="overlay"></div>

                      <div class="shine"></div>

                      <div class="card-content">
                        <h3>{{ $product->name }}</h3>

                        <a href="{{ route('frontend.contact_us') }}">
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
                    <p>No products available in this category yet.</p>
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
