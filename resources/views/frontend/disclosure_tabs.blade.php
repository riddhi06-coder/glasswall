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
                   data-background="{{ optional($disclosure)->banner_image_url ?? asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{!! $row->title !!}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span><a href="{{ route('frontend.disclosures') }}">Disclosures</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ trim(strip_tags($row->title)) }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="stock-wrap">
            <div class="container">

                @if($row->year)
                <h2 class="stock-heading">{{ $row->year }}</h2>
                @endif

                <div class="financial-tabs">

                    <div class="financial-tab-buttons">
                        @foreach($row->tabs as $tab)
                        <button type="button" class="financial-tab-btn {{ $loop->first ? 'active' : '' }}" data-tab="disc-tab-{{ $tab->id }}">
                            {{ $tab->label }}
                        </button>
                        @endforeach
                    </div>

                    @foreach($row->tabs as $tab)
                    <div class="financial-tab-content {{ $loop->first ? 'active' : '' }}" id="disc-tab-{{ $tab->id }}">
                        @if($tab->tabItems->count())
                        <div class="disclosures-table">
                            @foreach($tab->tabItems as $doc)
                            <div class="disclosure-row">
                                <div class="disclosure-title">
                                    <span class="disclosure-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span>{!! $doc->title !!}</span>
                                </div>
                                <div class="disclosure-link">
                                    <a href="{{ $doc->href ?: '#' }}" @if($doc->href) target="_blank" rel="noopener" @endif>View</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="coming-text"><h3>Coming Soon</h3></div>
                        @endif
                    </div>
                    @endforeach

                </div>

            </div>
          </section>



        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')
<script>
document.addEventListener('click', function(e) {

    const button = e.target.closest('.financial-tab-btn');

    if (!button) return;

    const tabId = button.getAttribute('data-tab');

    document.querySelectorAll('.financial-tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });

    document.querySelectorAll('.financial-tab-content').forEach(function(tab) {
        tab.classList.remove('active');
    });

    button.classList.add('active');

    const content = document.getElementById(tabId);

    if (content) {
        content.classList.add('active');
    }

});
</script>
  </body>
</html>
