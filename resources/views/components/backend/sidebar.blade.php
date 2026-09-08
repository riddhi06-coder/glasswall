<!-- Page Body Start-->
<style>
    /* Nested (level-2) sidebar branch — indented children with bullet dots. */
    .sidebar-submenu .submenu-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sidebar-submenu .submenu-content {
        list-style: none;
        padding-left: 16px;
        margin: 4px 0 4px 6px;
        border-left: 1px dashed rgba(255, 255, 255, 0.25);
    }
    .sidebar-submenu .submenu-content > li > a {
        position: relative;
        display: block;
        padding: 7px 8px 7px 20px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.72);
    }
    .sidebar-submenu .submenu-content > li > a::before {
        content: "";
        position: absolute;
        left: 4px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.55);
    }
    .sidebar-submenu .submenu-content > li > a:hover,
    .sidebar-submenu .submenu-content > li > a.active {
        color: #fff;
    }
    .sidebar-submenu .submenu-content > li > a.active::before {
        background: #fff;
    }
</style>
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div class="logo-wrapper">
            <a href="{{ route('admin.dashboard') }}">
              <img class="img-fluid" src="{{ asset('admin/assets/images/logo/gws.webp') }}" alt="Glass Wall Systems" style="max-width: 160px; width: 100%; height: auto; background-color:#6c757d;">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper">
            <a href="{{ route('admin.dashboard') }}">
              <img class="img-fluid" src="{{ asset('admin/assets/images/logo/favicon.png') }}" alt="Glass Wall Systems" style="max-width: 40px; height: auto;">
            </a>
          </div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn">
                  <a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/favicon.png') }}" alt="" style="max-width: 40px; height: auto;"></a>
                  <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>

                <li class="sidebar-list {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg>
                    <span class="lan-3">Dashboard</span>
                  </a>
                </li>

                @php
                    $authUser = auth()->user();
                    $can = fn (string $permission) => (bool) $authUser?->hasPermission($permission);
                @endphp

                {{-- User management: Roles / Users / Permissions --}}
                @if($can('roles.view') || $can('users.view') || $can('permissions.view'))
                <li class="sidebar-list {{ request()->routeIs('admin.roles.*', 'admin.users.*', 'admin.permissions.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                    </svg>
                    <span>User</span>
                  </a>
                  <ul class="sidebar-submenu">
                      @if($can('roles.view'))
                          <li><a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Roles</a></li>
                      @endif
                      @if($can('users.view'))
                          <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a></li>
                      @endif
                      @if($can('permissions.view'))
                          <li><a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">Permissions</a></li>
                      @endif
                  </ul>
                </li>
                @endif

              

                <li class="sidebar-list {{ request()->routeIs('banner-details.*','home-about-details.*','home-clientele.*','home-blog-details.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Home</span>
                  </a>
                  
                  <ul class="sidebar-submenu">
                      @if($can('roles.view'))
                          <li><a href="{{ route('banner-details.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Banner Details</a></li>
                      @endif
                          <li><a href="{{ route('home-about-details.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">About Details</a></li>
                          <li><a href="{{ route('home-clientele.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Clientele</a></li>
                          <li><a href="{{ route('home-blog-details.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Blog Section Details</a></li>

                  </ul>
                </li>




                <li class="sidebar-list {{ request()->routeIs('manage-about-us.*','manage-board-of-directors.*','manage-innovation.*','manage-esg.*','manage-media.*','manage-awards-category.*','manage-awards-recognition.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                    </svg>
                    <span>Overview</span>
                  </a>
                  
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-about-us.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">About Us</a></li>
                      <li><a href="{{ route('manage-board-of-directors.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Board of Directors</a></li>
                      <li><a href="{{ route('manage-innovation.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Innovation</a></li>
                      <li><a href="{{ route('manage-esg.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">ESG</a></li>
                      <li><a href="{{ route('manage-media.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Media</a></li>
                      <li>
                        <a href="#" class="submenu-title">Awards &amp; Recognition</a>
                        <ul class="submenu-content">
                          <li><a href="{{ route('manage-awards-category.index') }}" class="{{ request()->routeIs('manage-awards-category.*') ? 'active' : '' }}">Category</a></li>
                          <li><a href="{{ route('manage-awards-recognition.index') }}" class="{{ request()->routeIs('manage-awards-recognition.*') ? 'active' : '' }}">Listing</a></li>
                        </ul>
                      </li>

                    </ul>
                </li>



                <li class="sidebar-list {{ request()->routeIs('manage-product-category.*','manage-product-list.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                    </svg>
                    <span>Products</span>
                  </a>
                  
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-product-category.index') }}" class="{{ request()->routeIs('manage-product-category.*') ? 'active' : '' }}">Category</a></li>
                      <li><a href="{{ route('manage-product-list.index') }}" class="{{ request()->routeIs('manage-product-list.*') ? 'active' : '' }}">Listing</a></li>
                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-project-category.*','manage-project-listing.*','manage-project-details.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                    </svg>
                    <span>Projects</span>
                  </a>
                  
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-project-category.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Category</a></li>
                      <li><a href="{{ route('manage-project-listing.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Listing</a></li>
                      <li><a href="{{ route('manage-project-details.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Details</a></li>
                  </ul>
                </li>



                <li class="sidebar-list {{ request()->routeIs('manage-design-engg.*','manage-project-management.*','manage-facility.*','manage-jobs.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg>
                    <span>Infrastructure</span>
                  </a>

                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-design-engg.index') }}" class="{{ request()->routeIs('manage-design-engg.*') ? 'active' : '' }}">Design and Engineering</a></li>
                      <li><a href="{{ route('manage-facility.index') }}" class="{{ request()->routeIs('manage-facility.*') ? 'active' : '' }}">Facility</a></li>
                      <li><a href="{{ route('manage-project-management.index') }}" class="{{ request()->routeIs('manage-project-management.*') ? 'active' : '' }}">Project Management</a></li>

                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-ipo.*','manage-ipo-drhp.*','manage-annual-report.*','manage-investor-resource.*','manage-corporate-governance.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-charts') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-charts') }}"></use>
                    </svg>
                    <span>Investors Relations</span>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                        <a href="#" class="submenu-title">IPO <i class="fa fa-angle-down"></i></a>
                        <ul class="submenu-content">
                          <li><a href="{{ route('manage-ipo.index') }}" class="{{ request()->routeIs('manage-ipo.*') ? 'active' : '' }}">IPO Documents</a></li>
                          <li><a href="{{ route('manage-ipo-drhp.index') }}" class="{{ request()->routeIs('manage-ipo-drhp.*') ? 'active' : '' }}">DRHP Disclaimer</a></li>
                        </ul>
                      </li>
                      <li><a href="{{ route('manage-corporate-governance.index') }}" class="{{ request()->routeIs('manage-corporate-governance.*') ? 'active' : '' }}">Corporate Governance</a></li>
                      <li><a href="{{ route('manage-annual-report.index') }}" class="{{ request()->routeIs('manage-annual-report.*') ? 'active' : '' }}">Annual Reports</a></li>
                      <li><a href="{{ route('manage-investor-resource.index') }}" class="{{ request()->routeIs('manage-investor-resource.*') ? 'active' : '' }}">Investor Resources</a></li>
                  </ul>
                </li>



                <li class="sidebar-list {{ request()->routeIs('manage-careers-details.*','manage-jobs.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>

                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bonus-kit') }}"></use>
                    </svg>
                    <span>Careers</span>
                  </a>
                  
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-careers-details.index') }}" class="{{ request()->routeIs('manage-careers-details.*') ? 'active' : '' }}">Page Details</a></li>
                      <li><a href="{{ route('manage-jobs.index') }}" class="{{ request()->routeIs('manage-jobs.*') ? 'active' : '' }}">Job posting</a></li>
                  </ul>
                </li>


                {{-- Contact Details --}}
                @if($authUser?->isSuperAdmin())
                <li class="sidebar-list {{ request()->routeIs('manage-contact-details.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('manage-contact-details.index') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <span>Contact Details</span>
                  </a>
                </li>
                @endif


                {{-- Enquiries (form submissions stored in DB) --}}
                <li class="sidebar-list {{ request()->routeIs('manage-contact-enquiries.*','manage-career-applications.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <span>Enquiries</span>
                  </a>
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('manage-contact-enquiries.index') }}" class="{{ request()->routeIs('manage-contact-enquiries.*') ? 'active' : '' }}">Contact Enquiries</a></li>
                      <li><a href="{{ route('manage-career-applications.index') }}" class="{{ request()->routeIs('manage-career-applications.*') ? 'active' : '' }}">Career Applications</a></li>
                  </ul>
                </li>






                {{-- Activity Log: Super Admin only --}}
                @if($authUser?->isSuperAdmin())
                <li class="sidebar-list {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('admin.activity-logs.index') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                    </svg>
                    <span>Activity Log</span>
                  </a>
                </li>
                @endif


              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>

