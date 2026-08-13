<!-- Page Body Start-->
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


                <li class="sidebar-list {{ request()->routeIs('banner-details.*','home-about-details.*','home-clientele.*') ? 'active' : '' }}">
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

                  </ul>
                </li>

              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>

