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
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($banner)->banner_heading ?: 'Media' }}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ optional($banner)->banner_heading ?: 'Media' }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="media-wrap position-relative overflow-hidden">
            <div class="container">

              @if($banner && ($banner->section_subtitle || $banner->section_heading || $banner->section_intro))
                <div class="tp-section-title-wrap mb-30 tp-text-center">
                  @if($banner->section_subtitle)<span class="tp-section-sub-title">{{ $banner->section_subtitle }}</span>@endif
                  @if($banner->section_heading)<h2 class="tp-section-title">{{ $banner->section_heading }}</h2>@endif
                  @if($banner->section_intro)<p>{{ $banner->section_intro }}</p>@endif
                </div>
              @endif

              <div class="row align-items-center g-5">
                @forelse($media as $item)
                  @if($item->video)
                  <div class="col-lg-8 col-md-10 mx-auto">
                    <video class="media-video" autoplay muted loop playsinline controls preload="auto">
                      <source src="{{ $item->assetUrl($item->video) }}" type="video/mp4" />
                      Your browser does not support the video tag.
                    </video>
                  </div>
                  @endif
                @empty
                  <div class="col-12 tp-text-center">
                    <p>No media available yet.</p>
                  </div>
                @endforelse

                @if($banner && $banner->documents->count())
                  <div class="col-lg-12 col-md-12">
                    <div class="document-subgrid">
                      @foreach($banner->documents as $doc)
                        <a href="{{ $doc->pdf_url ?: '#' }}" target="_blank" rel="noopener" class="document-subbox">
                          <span>{!! $doc->title !!}</span>
                          <img src="{{ asset('frontend/assets/images/icons/pdf.svg') }}" alt="PDF">
                        </a>
                      @endforeach
                    </div>
                  </div>
                @endif
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
