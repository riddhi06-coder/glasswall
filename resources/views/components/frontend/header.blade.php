<header>
  <div class="tp-header-area tp-header-transparent sticky-black" id="header-sticky">
    <div class="container">
      <div class="tp-header-border-white tp-header-spacing">
        <div class="tp-header-wrap">
          <div class="row gx-0 tp-align-center">
            <div class="col-xl-3 col-lg-3 col-md-8 col-5">
              <div class="tp-header-logo">
                <a href="index.html">
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
                          <a href="vision-mission-values.html"><span>About Us</span></a>
                        </li>
                        <li>
                          <a href="board-of-directors.html"><span>Board of Directors</span></a>
                        </li>
                        <li>
                          <a href="innovation.html"><span>Innovation</span></a>
                        </li>
                        <li>
                          <a href="esg.html"><span>ESG</span></a>
                        </li>
                        <li><a href="media.html"><span>Media</span></a></li>
                        <li>
                          <a href="awards-recognition.html"><span>Awards and Certificates</span></a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="#">Products</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="facade-and-curtain-wall-systems.html"
                            ><span>Facade and Curtain Wall Systems</span></a
                          >
                        </li>
                        <li>
                          <a href="louvers.html"><span>Louvers</span></a>
                        </li>
                        <li>
                          <a href="rain-screen-cladding.html"><span>Rain Screen Cladding</span></a>
                        </li>
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
                          <a href="#"><span>Design & Engineering</span></a>
                        </li>
                        <li>
                          <a href="#"><span>Facility</span></a>
                        </li>
                        <li>
                          <a href="project-management.html"><span>Project Management</span></a>
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
                          <a href="corporate-governance.html"><span>Corporate Governance</span></a>
                        </li>
                        <li>
                          <a href="annual-report.html"><span>Annual Reports</span></a>
                        </li>
                        <li>
                          <a href="#"><span>Investor Resources</span></a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1 col-5">
              <div class="tp-header-cta tp-flex-center tp-justify-end">
                
                <div class="tp-cta-phone tp-header-cta-phone mr-30 d-none d-xl-inline-block">
                    <a class="tp-flex-center" href="#">
                        <span class="tp-cta-phone-icon mr-10">
                            <img src="{{ asset('frontend/assets/images/icons/search.svg') }}"/>
                        </span>
                    </a>
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
            <a href="index.html">
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
