<style>
  /* Header search widget */
  .gws-search { position: relative; }
  .gws-search-dropdown {
    position: absolute; top: 100%; right: 0; margin-top: 14px;
    width: 340px; max-width: 90vw; background: #fff; border-radius: 12px;
    box-shadow: 0 12px 34px rgba(0,0,0,.18); padding: 14px; z-index: 9999;
  }
  .gws-search-dropdown[hidden] { display: none; }
  #gwsSearchInput {
    width: 100%; padding: 11px 14px; border: 1px solid #dcdcdc; border-radius: 8px;
    font-size: 14px; outline: none; color: #111; background: #fff;
  }
  #gwsSearchInput:focus { border-color: #0a4bb3; }
  #gwsSearchInput::placeholder { color: #9aa0a6; opacity: 1; }
  #gwsSearchResults { list-style: none; margin: 10px 0 0; padding: 0; max-height: 340px; overflow-y: auto; }
  #gwsSearchResults li { margin: 0; }
  #gwsSearchResults li a {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    padding: 10px 11px; border-radius: 7px; text-decoration: none; color: #111; line-height: 1.3;
  }
  #gwsSearchResults li a:hover { background: #f3f4f6; }
  #gwsSearchResults small { color: #888; font-size: 12px; }
  #gwsSearchResults .gws-tag {
    flex: none; font-size: 11px; color: #fff; background: #0a4bb3;
    border-radius: 20px; padding: 3px 9px; white-space: nowrap;
  }
  #gwsSearchResults .gws-tag.product { background: #0a8a5f; }
  .gws-search-empty { padding: 10px 4px; color: #777; font-size: 13px; }
</style>
<header>
  <div class="tp-header-area tp-header-transparent sticky-black" id="header-sticky">
    <div class="container">
      <div class="tp-header-border-white tp-header-spacing">
        <div class="tp-header-wrap">
          <div class="row gx-0 tp-align-center">
            <div class="col-xl-3 col-lg-3 col-md-8 col-5">
              <div class="tp-header-logo">
                <a href="{{ route('frontend.index') }}">
                  <img data-width="275" src="{{ asset('frontend/assets/images/gws.png') }}" alt="Glass Wall Systems Logo" />
                </a>
              </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-2 tp-text-center">
              <div class="tp-header-menu tp-header-menu-white tp-bluer-bg tp-text-center d-none d-xl-inline-block">
                <nav class="tp-mobile-menu-active">
                  <ul>
                    <!--<li><a href="#">Overview </a></li>-->
                    <li>
                      <a href="#">Overview</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="{{ route('frontend.about_us') }}"><span>About Us</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.board_of_directors') }}"><span>Board of Directors</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.innovation') }}"><span>Innovation</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.esg') }}"><span>ESG</span></a>
                        </li>
                        <li><a href="{{ route('frontend.media') }}"><span>Media</span></a></li>
                        <li>
                          <a href="{{ route('frontend.awards_recognition') }}"><span>Awards and Certificates</span></a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="{{ route('frontend.products_category_listing') }}">Products</a>
                      <ul class="sub-menu">
                        @foreach(($navProductCategories ?? []) as $navProductCategory)
                          <li>
                            <a href="{{ route('frontend.products_category', $navProductCategory->slug) }}"><span>{{ $navProductCategory->name }}</span></a>
                          </li>
                        @endforeach
                      </ul>
                    </li>
                    <li>
                      <a href="#">Projects</a>
                      <ul class="sub-menu">
                        @foreach(($navCategories ?? []) as $navCategory)
                          <li>
                            <a href="{{ route('frontend.projects', $navCategory->slug) }}"><span>{{ $navCategory->name }}</span></a>
                          </li>
                        @endforeach
                      </ul>
                    </li>
                     <li>
                      <a href="#">Infrastructure</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="{{ route('frontend.design_and_engineering') }}"><span>Design & Engineering</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.facility') }}"><span>Facility</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.project_management') }}"><span>Project Management</span></a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="#">Investors Relations</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="ipo.html"><span>IPO</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.corporate_governance') }}"><span>Corporate Governance</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.annual_report') }}"><span>Annual Reports</span></a>
                        </li>
                        <li>
                          <a href="{{ route('frontend.investor_resources') }}"><span>Investor Resources</span></a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="{{ route('frontend.careers') }}">Careers</a></li>
                    <li><a href="{{ route('frontend.contact_us') }}">Contact Us</a></li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1 col-5">
              <div class="tp-header-cta tp-flex-center tp-justify-end">
                
                <div class="tp-cta-phone tp-header-cta-phone mr-30 d-none d-xl-inline-block gws-search" id="gwsSearch">
                    <a class="tp-flex-center gws-search-toggle" href="#" aria-label="Search">
                        <span class="tp-cta-phone-icon mr-10">
                            <img src="{{ asset('frontend/assets/images/icons/search.svg') }}"/>
                        </span>
                    </a>
                    <div class="gws-search-dropdown" hidden>
                        <input type="text" id="gwsSearchInput" placeholder="Search here.." autocomplete="off">
                        <ul id="gwsSearchResults"></ul>
                    </div>
                </div>
                <div class="tp-header-bar d-xl-none">
                  <button class="header-sidebar-btn tp-offcanvas-toogle ml-10" aria-label="Open menu">
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>


<!-- header end -->
    <div id="loading">
      <div id="loading-center">
        <div id="loading-center-absolute">
          <div class="object" id="object_four"></div>
          <div class="object" id="object_three"></div>
          <div class="object" id="object_two"></div>
          <div class="object" id="object_one"></div>
        </div>
      </div>
    </div>
    <!-- magic cursor start -->
    <div id="magic-cursor" class="cursor-secoundery-bg">
      <div id="ball"></div>
    </div>
    <!-- magic cursor end -->

    <!-- back to top start -->
    <div class="back-to-top-wrapper">
      <button id="back_to_top" type="button" class="back-to-top-btn" aria-label="Back to top">
        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M11 6L6 1L1 6"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>
    </div>
    <!-- back to top end -->

    <!-- offcanvas start -->
    <aside class="tp-offcanvas">
      <div class="tp-offcanvas-wrapper">
        <div class="tp-offcanvas-header d-flex align-items-center justify-content-between mb-40">
          <div class="tp-offcanvas-logo">
            <a href="{{ route('frontend.index') }}">
              <img data-width="183" src="{{ asset('frontend/assets/images/logo.webp') }}" alt="Glass Wall Systems" />
            </a>
          </div>
          <div class="tp-offcanvas-button">
            <button class="tp-offcanvas-button-close tp-offcanvas-close-toggle" aria-label="Close menu">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="tp-offcanvas-menu mb-30">
          <nav></nav>
        </div>
      </div>
    </aside>
    <div class="tp-offcanvas-overlay"></div>
    <!-- offcanvas end -->

    <script>
      (function () {
        var wrap = document.getElementById('gwsSearch');
        if (!wrap) return;
        var toggle   = wrap.querySelector('.gws-search-toggle');
        var dropdown = wrap.querySelector('.gws-search-dropdown');
        var input    = document.getElementById('gwsSearchInput');
        var results  = document.getElementById('gwsSearchResults');
        var url      = "{{ route('frontend.search') }}";
        var timer;

        toggle.addEventListener('click', function (e) {
          e.preventDefault();
          if (dropdown.hasAttribute('hidden')) {
            dropdown.removeAttribute('hidden');
            setTimeout(function () { input.focus(); }, 30);
          } else {
            dropdown.setAttribute('hidden', '');
          }
        });

        // Close when clicking outside the widget.
        document.addEventListener('click', function (e) {
          if (!wrap.contains(e.target)) dropdown.setAttribute('hidden', '');
        });

        function render(items) {
          results.innerHTML = '';
          if (!items.length) {
            var empty = document.createElement('li');
            empty.className = 'gws-search-empty';
            empty.textContent = 'No results found.';
            results.appendChild(empty);
            return;
          }
          items.forEach(function (it) {
            var li = document.createElement('li');
            var a  = document.createElement('a');
            a.href = it.url;

            var left  = document.createElement('span');
            var name  = document.createElement('span');
            name.textContent = it.label;
            var small = document.createElement('small');
            small.textContent = it.type;
            left.appendChild(name);
            left.appendChild(document.createElement('br'));
            left.appendChild(small);

            var tag = document.createElement('span');
            tag.className = 'gws-tag' + (it.group === 'product' ? ' product' : '');
            tag.textContent = (it.group === 'product' ? 'Product' : 'Project');

            a.appendChild(left);
            a.appendChild(tag);
            li.appendChild(a);
            results.appendChild(li);
          });
        }

        function showLoading() {
          results.innerHTML = '';
          var li = document.createElement('li');
          li.className = 'gws-search-empty';
          li.textContent = 'Loading....';
          results.appendChild(li);
        }

        input.addEventListener('input', function () {
          var q = input.value.trim();
          clearTimeout(timer);
          if (q.length < 2) { results.innerHTML = ''; return; }
          showLoading();
          var current = q;
          timer = setTimeout(function () {
            fetch(url + '?q=' + encodeURIComponent(current), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
              .then(function (r) { return r.json(); })
              .then(function (items) {
                // Ignore stale responses if the query changed meanwhile.
                if (input.value.trim() !== current) return;
                render(items);
              })
              .catch(function () {
                results.innerHTML = '';
                var err = document.createElement('li');
                err.className = 'gws-search-empty';
                err.textContent = 'Search unavailable. Please try again.';
                results.appendChild(err);
              });
          }, 250);
        });
      })();
    </script>
