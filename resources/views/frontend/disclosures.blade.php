<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')
<style>
/* =========================================
   FINANCIAL DISCLOSURE - ITEM 14
   ========================================= */

.financial-disclosure-new {
  width: 100%;
    padding: 25px 30px 30px;
  border-bottom: 1px solid #ddd;
  box-sizing: border-box;
}
.financial-row-row {
    margin-left: 55px;
}
.financial-row{

    display: flex;
    gap: 40px;
}

/* NUMBER */

.financial-disclosure-new-number {
  font-size: 13px;
  font-weight: 600;
  color: #888;
  margin-bottom: 10px;
}


/* HEADING */

.financial-disclosure-new-heading {
  font-size: 16px;
  line-height: 1.5;
  font-weight: 600;
  color: #222;
  margin-bottom: 4px;
}


/* YEAR */

.financial-disclosure-new-year {
  font-size: 15px;
  line-height: 1.5;
  color: #888;
  margin-bottom: 6px;
}


/* THREE COLUMN AREA */

.financial-disclosure-new-items {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 45px;
  width: 100%;
}


/* EACH COLUMN */

.financial-disclosure-new-item {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  min-width: 0;
}


/* a / b / c */

.financial-disclosure-new-letter {
  font-size: 15px;
  line-height: 1.5;
  color: #222;
  margin-bottom: 4px;
}


/* DOCUMENT NAME */

.financial-disclosure-new-name {
  font-size: 15px;
  line-height: 1.55;
  color: #222;
  max-width: 100%;
}


/* VIEW */

.financial-disclosure-new-view {
  margin-top: 5px;
  color: #222;
  font-size: 15px;
  font-weight: 600;
  text-decoration: underline;
  text-underline-offset: 4px;
  transition: color 0.25s ease;
}


/* HOVER */

.financial-disclosure-new-view:hover {
  color: #777;
}


/* =========================================
   MOBILE
   ========================================= */

@media (max-width: 767px) {

  .financial-disclosure-new {
    padding: 24px 20px 30px;
  }

  .financial-disclosure-new-items {
    grid-template-columns: 1fr;
    gap: 25px;
  }

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
              <span class="disclosure-number">{{ $row->number }}</span>
              <span>{!! $row->title !!}</span>
            </div>
            <div class="disclosure-link" @if($row->links->count() > 1) style="flex-direction: column;" @endif>
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
              <div class="financial-disclosure-new-number">{{ $row->number }}</div>
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
          <div class="year-row">
            <div class="year-title">
              <span class="year-number">{{ $row->number }}</span>
              <span>{!! $row->title !!}</span>
            </div>
            <div class="year-box">
              @if($row->year)<h2 class="year-heading">{{ $row->year }}</h2>@endif
              <div class="financial-tabs">
                <div class="financial-tab-buttons">
                  @foreach($row->tabs as $tab)
                    <button type="button" class="financial-tab-btn {{ $loop->first ? 'active' : '' }}" data-tab="tab-{{ $row->id }}-{{ $loop->index }}">{{ $tab->label }}</button>
                  @endforeach
                </div>
                @foreach($row->tabs as $tab)
                  <div class="financial-tab-content {{ $loop->first ? 'active' : '' }}" id="tab-{{ $row->id }}-{{ $loop->index }}">
                    <div class="coming-text">{!! $tab->content !!}</div>
                  </div>
                @endforeach
              </div>
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
