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
                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($disclosure)->banner_heading ?? 'Disclosures' }}</h1>
              </div>
              <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                <span class="tp-breadcrumb-dvdr">-</span>
                <span>{{ optional($disclosure)->banner_heading ?? 'Disclosures' }}</span>
              </div>
            </div>
          </div>
        </section>
        <!-- hero area end -->

        <section class="disclosures-wrap py-5">
          <div class="container">

            @if(optional($disclosure)->page_heading)
            <h2 class="disclosures-heading">{!! $disclosure->page_heading !!}</h2>
            @endif

            <div class="disclosures-table">

              @foreach($rows as $row)

              @if($row->type === 'links')
              <div class="disclosure-row">
                <div class="disclosure-title">
                  <span class="disclosure-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                  <span>{!! $row->title !!}</span>
                </div>
                <div class="disclosure-link {{ $row->links->count() > 1 ? 'disclosure-link--stacked' : '' }}">
                  @forelse($row->links as $link)
                  <a href="{{ $link->href ?: '#' }}" @if($link->href) target="_blank" rel="noopener" @endif>{{ $link->label ?: 'View' }}</a>
                  @empty
                  <a href="#">View</a>
                  @endforelse
                </div>
              </div>

              @elseif($row->type === 'financial')
              <div class="financial-disclosure-new">
                <div class="financial-row">
                  <div class="financial-disclosure-new-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                  <div class="financial-disclosure-new-heading">{!! $row->title !!}</div>
                </div>
                <div class="financial-row-row">
                  @if($row->year)<div class="financial-disclosure-new-year">{{ $row->year }}</div>@endif
                  <div class="financial-disclosure-new-items">
                    @foreach($row->links as $link)
                    <div class="financial-disclosure-new-item">
                      <div class="financial-disclosure-new-name">{{ $link->name }}</div>
                      <a href="{{ $link->href ?: '#' }}" class="financial-disclosure-new-view" @if($link->href) target="_blank" rel="noopener" @endif>{{ $link->label ?: 'View' }}</a>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>

              @elseif($row->type === 'tabs')
              <div class="disclosure-row">
                <div class="disclosure-title">
                  <span class="disclosure-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                  <span>{!! $row->title !!}</span>
                </div>
                <div class="disclosure-link">
                  <a href="{{ route('frontend.disclosure_tabs', $row->slug ?: $row->id) }}">View</a>
                </div>
              </div>
              @endif

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

      /* Find the tab group where the button was clicked */
      const tabGroup = button.closest('.financial-tabs');

      if (!tabGroup) return;

      /* Get the target tab */
      const tabId = button.dataset.tab;
      const targetContent = tabGroup.querySelector(
        '.financial-tab-content[id="' + tabId + '"]'
      );

      if (!targetContent) return;

      /* Remove active state only from this tab group */
      tabGroup.querySelectorAll('.financial-tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
      });

      tabGroup.querySelectorAll('.financial-tab-content').forEach(function(content) {
        content.classList.remove('active');
      });

      /* Activate selected tab */
      button.classList.add('active');
      targetContent.classList.add('active');

    });
  </script>
</body>

</html>