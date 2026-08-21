<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

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
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'Awards & Recognition' }}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ optional($banner)->banner_heading ?: 'Awards & Recognition' }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="gw-awards-wrap">
            <div class="container">
              <div class="gw-tabbar">
                @foreach($categories as $category)
                  <button type="button" class="gw-tab-btn {{ $loop->first ? 'active' : '' }}" data-target="gwPanel{{ $category->id }}">
                    <span class="gw-tab-icon">
                      <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                    </span>
                    {{ $category->name }}
                  </button>
                @endforeach
              </div>
            </div>

            <div class="container mt-5">
              @forelse($categories as $category)
                <div id="gwPanel{{ $category->id }}" class="gw-panel row g-4 justify-content-center {{ $loop->first ? '' : 'd-none' }}">
                  @forelse($awardsByCat[$category->id] ?? [] as $award)
                    <div class="col-md-6 col-lg-4">
                      <div class="gw-card">
                        <div class="gw-card-media">
                          <a href="{{ $award->assetUrl($award->main_image) }}" class="glightbox">
                            <img src="{{ $award->assetUrl($award->thumbnail_image) }}" alt="{{ $award->title }}">
                            <div class="gw-overlay"></div>
                            @if($award->year)
                              <span class="gw-year-badge">{{ $award->year }}</span>
                            @endif
                            <div class="gw-zoom-btn">
                              <i class="fas fa-search-plus"></i>
                            </div>
                          </a>
                        </div>
                        <div class="gw-card-body">
                          <h3 class="gw-card-title">{{ $award->title }}</h3>
                          <h5>{{ $award->subject }}</h5>
                        </div>
                      </div>
                    </div>
                  @empty
                    <div class="col-12 tp-text-center">
                      <p>No awards in this category yet.</p>
                    </div>
                  @endforelse
                </div>
              @empty
                <div class="row"><div class="col-12 tp-text-center"><p>No awards added yet.</p></div></div>
              @endforelse
            </div>
          </section>

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            openEffect: 'zoom',
            closeEffect: 'fade'
        });
    </script>

    <script>
        // Awards category tab switching (works for any number of categories).
        (function () {
            var buttons = document.querySelectorAll('.gw-tab-btn');
            var panels  = document.querySelectorAll('.gw-panel');
            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    buttons.forEach(function (b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    panels.forEach(function (p) { p.classList.add('d-none'); });
                    var target = document.getElementById(btn.getAttribute('data-target'));
                    if (target) { target.classList.remove('d-none'); target.classList.add('gw-fade'); }
                });
            });
        })();
    </script>

  </body>
</html>

