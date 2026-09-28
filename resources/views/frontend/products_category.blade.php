<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')

    <style>
      /* ---- Intro ---- */
      .pc-intro { padding: 100px 0 50px; }
      .pc-intro .tp-section-title { margin-bottom: 18px; }
      .pc-lead {
        max-width: 720px;
        margin: 0 auto;
        color: #5b6270;
        font-size: 18px;
        line-height: 1.7;
      }
      .pc-divider {
        width: 64px; height: 3px;
        margin: 28px auto 0;
        border-radius: 3px;
        background: #1a4685;
      }

      /* ---- Product grid ---- */
      .pc-grid { padding-bottom: 110px; }

      /* ---- About / SEO content ---- */
      .pc-about {
        background: #f4f6fa;
        padding: 100px 0;
      }
      .pc-about-aside { position: sticky; top: 130px; }
      .pc-about-label {
        display: inline-block;
        color: #1a4685;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 14px;
      }
      .pc-about-title {
        font-size: 34px;
        line-height: 1.25;
        margin-bottom: 20px;
      }
      .pc-about-aside p {
        color: #5b6270;
        font-size: 16px;
        line-height: 1.7;
        margin: 0 0 28px;
      }
      .pc-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        border-radius: 50px;
        background: #1a4685;
        color: #fff;
        font-weight: 500;
        transition: background .3s ease, transform .3s ease;
      }
      .pc-cta:hover { background: #12325f; color: #fff; transform: translateY(-2px); }

      .pc-about-body {
        position: relative;
        background: #fff;
        border-radius: 20px;
        padding: 44px 48px;
        box-shadow: 0 20px 50px rgba(20, 40, 80, .06);
      }
      /* Collapsed height (= the first paragraph) is set by the script below. */
      .pc-about-text {
        overflow: hidden;
        transition: max-height .6s ease;
      }
      .pc-about-text p {
        margin: 0 0 20px;
        color: #4a5160;
        font-size: 16px;
        line-height: 1.85;
        text-align: left;
      }
      .pc-about-text p:last-child { margin-bottom: 0; }
      .pc-about-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 18px 32px;
        margin-top: 28px;
      }
      .pc-readmore {
        padding: 0;
        border: 0;
        background: none;
        color: #1a4685;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .pc-readmore i { transition: transform .3s ease; }
      .pc-about-body.is-open .pc-readmore i { transform: rotate(180deg); }
      .pc-about-body.no-toggle .pc-readmore { display: none; }

      @media (max-width: 991px) {
        .pc-intro { padding: 70px 0 40px; }
        .pc-grid { padding-bottom: 80px; }
        .pc-about { padding: 70px 0; }
        .pc-about-aside { position: static; margin-bottom: 30px; }
        .pc-about-title { font-size: 28px; }
      }
      @media (max-width: 575px) {
        .pc-lead { font-size: 16px; }
        .pc-about-body { padding: 28px 22px; }
      }
    </style>

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

          <!-- About this category (SEO content) -->
          @if($category->seo_content)
          <section class="pc-about">
            <div class="container">
              <div class="row g-5">
                <div class="col-lg-4">
                  <div class="pc-about-aside">
                    <span class="pc-about-label">About</span>
                    <h3 class="pc-about-title">{{ $category->name }}</h3>
                    <p>Have a project in mind? Our facade specialists can help you choose the right system.</p>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="pc-about-body" id="pc-about-body">
                    <div class="pc-about-text">
                      {!! $category->seo_content !!}
                    </div>
                    <div class="pc-about-actions">
                      <button type="button" class="pc-readmore" id="pc-readmore" aria-expanded="false">
                        <span>Read more</span> <i class="fa-solid fa-chevron-down"></i>
                      </button>
                      <a href="{{ route('frontend.contact_us') }}" class="pc-cta">
                        Talk to our team <i class="fa-solid fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          @endif

          <!-- Intro -->
          <section class="pc-intro">
            <div class="container">
              <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                <span class="tp-section-sub-title mb-15">Our Products</span>
                <h2 class="tp-section-title">{{ $category->name }}</h2>
                @if($category->short_description)
                  <p class="pc-lead">{{ $category->short_description }}</p>
                @endif
                <div class="pc-divider"></div>
              </div>
            </div>
          </section>

          <!-- Product grid -->
          <section class="product-section pc-grid pt-0">
            <div class="container">
              <div class="row g-4">
                @forelse($products as $product)
                  <div class="col-lg-4 col-md-6">
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

    <script>
      // "Read more" for the About text: collapsed, only the first paragraph shows.
      // The toggle is hidden when there is nothing beyond the first paragraph.
      (function () {
        var body = document.getElementById('pc-about-body');
        if (!body) return;
        var text  = body.querySelector('.pc-about-text');
        var first = text.firstElementChild;
        var btn   = document.getElementById('pc-readmore');

        if (!first || text.scrollHeight <= first.offsetHeight + 10) {
          body.classList.add('no-toggle');
          return;
        }

        function collapsedHeight() { return first.offsetHeight + 'px'; }

        function apply() {
          text.style.maxHeight = body.classList.contains('is-open') ? text.scrollHeight + 'px' : collapsedHeight();
        }

        apply();
        window.addEventListener('resize', apply);

        btn.addEventListener('click', function () {
          var open = body.classList.toggle('is-open');
          btn.setAttribute('aria-expanded', open);
          btn.querySelector('span').textContent = open ? 'Read less' : 'Read more';
          apply();
          // The page uses GSAP smooth scrolling; re-measure once the height has animated.
          setTimeout(function () {
            if (window.ScrollTrigger) window.ScrollTrigger.refresh();
          }, 650);
        });
      })();
    </script>

  </body>
</html>
