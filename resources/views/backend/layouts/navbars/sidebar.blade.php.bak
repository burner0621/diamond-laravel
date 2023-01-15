<!-- Navbar Vertical -->
  <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white  ">
    <div class="navbar-vertical-container">
      <div class="navbar-vertical-footer-offset">
        <!-- Logo -->

        <a class="navbar-brand" href="/backend" aria-label="Front">
          <img class="navbar-brand-logo" src="{{ asset('assets/svg/logos/logo.svg') }}" alt="Logo" data-hs-theme-appearance="default">
          <img class="navbar-brand-logo" src="{{ asset('assets/svg/logos-light/logo.svg') }}" alt="Logo" data-hs-theme-appearance="dark">
        </a>

        <!-- End Logo -->

        <!-- Navbar Vertical Toggle -->
        <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
          <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
          <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
        </button>

        <!-- End Navbar Vertical Toggle -->

        <!-- Content -->
        <div class="navbar-vertical-content">
          <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
            <div class="nav-item">
                <a class="nav-link " href="/backend" data-placement="left">
                  <i class="bi-house-door nav-icon"></i>
                  <span class="nav-link-title">{{ __("Dashboard") }}</span>
                </a>
              </div>

            <span class="dropdown-header mt-4">{{ __("Users Management") }}</span>
            <small class="bi-three-dots nav-subtitle-replacer"></small>

            <!-- Collapse -->
            <div class="navbar-nav nav-compact">

            </div>
            <div id="navbarVerticalMenuPagesMenu">
              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesUsersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuPagesUsersMenu">
                  <i class="bi-people nav-icon"></i>
                  <span class="nav-link-title">{{ __("Users") }} <span class="badge bg-primary rounded-pill ms-1">5</span></span>
                </a>

                <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse @if($activePage == 'users') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link " href="{{ route('backend.users.list') }}">{{ __("All Users") }}</a>
                  <a class="nav-link " href="{{ route('backend.customers.list') }}">{{ __("Customers") }}</a>
                  <a class="nav-link " href="{{ route('backend.sellers.list') }}">{{ __("Sellers") }} <span class="badge bg-primary rounded-pill ms-1">5</span></a>
                  <a class="nav-link " href="#">{{ __("Profile") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <span class="dropdown-header mt-4">{{ __("Content") }}</span>
              <small class="bi-three-dots nav-subtitle-replacer"></small>

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuAllPostMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPostMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPostMenu">
                  <i class="bi bi-pin-angle-fill nav-icon"></i>
                  <span class="nav-link-title">{{ __("Post") }}</span>
                </a>

                <div id="navbarVerticalMenuAllPostMenu" class="nav-collapse collapse @if($activePage == 'posts') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allpost') active @endif" href="{{ route('backend.posts.list') }}">{{ __("All Post") }}</a>
                  <a class="nav-link @if($navName == 'addpost') active @endif" href="{{ route('backend.posts.create') }}">{{ __("Create Post") }}</a>
                  <a class="nav-link @if($navName == 'blogcategories') active @endif" href="{{ route('backend.blog.categories.list') }}">{{ __("Categories") }}</a>
                  <a class="nav-link @if($navName == 'blogtags') active @endif" href="{{ route('backend.blog.tags.list') }}">{{ __("Tags") }}</a>
                  <a class="nav-link @if($navName == 'blogtrash') active @endif" href="{{ route('backend.posts.trash') }}">{{ __("Trash") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuAllPagesMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPagesMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPagesMenu">
                  <i class="bi-stickies nav-icon"></i>
                  <span class="nav-link-title">{{ __("Pages") }}</span>
                </a>

                <div id="navbarVerticalMenuAllPagesMenu" class="nav-collapse collapse @if($activePage == 'pages') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link " href="#">{{ __("All Pages") }}</a>
                  <a class="nav-link " href="#">{{ __("Add New") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <div class="nav-item">
                <a class="nav-link " href="{{ route('backend.filemanager.list')}}" data-placement="left">
                  <i class="bi-folder2-open nav-icon"></i>
                  <span class="nav-link-title">File Manager</span>
                </a>
              </div>

              <span class="dropdown-header mt-4">{{ __("Commerce") }}</span>
              <small class="bi-three-dots nav-subtitle-replacer"></small>

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuAllProductsMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllProductsMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllProductsMenu">
                  <i class="bi-basket nav-icon"></i>
                  <span class="nav-link-title">{{ __("Products") }}</span>
                </a>

                <div id="navbarVerticalMenuAllProductsMenu" class="nav-collapse collapse @if($activePage == 'products') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allproducts') active @endif" href="{{ route('backend.products.list') }}">{{ __("All Products") }}</a>
                  <a class="nav-link @if($navName == 'addproduct') active @endif" href="{{ route('backend.products.create') }}">{{ __("Create Product") }}</a>
                  <a class="nav-link @if($navName == 'attributes') active @endif " href="{{route('backend.products.attributes.list')}}">{{ __("Attributes") }}</a>
                  <a class="nav-link @if($navName == 'productscategories') active @endif" href="{{ route('backend.products.categories.list') }}">{{ __("Categories") }}</a>
                  <a class="nav-link @if($navName == 'productstags') active @endif" href="{{ route('backend.products.tags.list') }}">{{ __("Tags") }}</a>
                  <a class="nav-link @if($navName == 'productstrash') active @endif" href="{{ route('backend.products.trash') }}">{{ __("Trash") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuAllOrdersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllOrdersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllOrdersMenu">
                  <i class="bi bi-receipt nav-icon"></i>
                  <span class="nav-link-title">{{ __("Orders") }}</span>
                </a>

                <div id="navbarVerticalMenuAllOrdersMenu" class="nav-collapse collapse @if($activePage == 'orders') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'orderslist') active @endif" href="{{ route('backend.orders.list') }}">{{ __("All Orders") }}</a>
                  <a class="nav-link " href="{{ route('backend.orders.pending') }}">{{ __("Pending") }} <span class="badge bg-primary rounded-pill ms-1">5</span></a>
                </div>
              </div>
              <!-- End Collapse -->

              <div class="nav-item">
                <a class="nav-link " href="#" data-placement="left">
                  <i class="bi-folder2-open nav-icon"></i>
                  <span class="nav-link-title">Coupons</span>
                </a>
              </div>

              <div class="nav-item">
                <a class="nav-link " href="#" data-placement="left">
                  <i class="bi-folder2-open nav-icon"></i>
                  <span class="nav-link-title">Reports</span>
                </a>
              </div>

              <span class="dropdown-header mt-4">{{ __("Configuration") }}</span>
              <small class="bi-three-dots nav-subtitle-replacer"></small>

              <div class="nav-item">
                <a class="nav-link " href="#" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title">General</span>
                </a>
              </div>

              <div class="nav-item">
                <a class="nav-link " href="#" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title">API Keys</span>
                </a>
              </div>

        </div>
        <!-- End Content -->

        <!-- Footer -->
        <div class="navbar-vertical-footer">
          <ul class="navbar-vertical-footer-list">
            <li class="navbar-vertical-footer-list-item">
              <!-- Style Switcher -->
              <div class="dropdown dropup">
                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                <i class="bi-brightness-high"></i>
                </button>

                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="selectThemeDropdown">
                  <a class="dropdown-item" href="#" data-icon="bi-moon-stars" data-value="auto">
                    <i class="bi-moon-stars me-2"></i>
                    <span class="text-truncate" title="Auto (system default)">Auto (system default)</span>
                  </a>
                  <a class="dropdown-item active" href="#" data-icon="bi-brightness-high" data-value="default">
                    <i class="bi-brightness-high me-2"></i>
                    <span class="text-truncate" title="Default (light mode)">Default (light mode)</span>
                  </a>
                  <a class="dropdown-item" href="#" data-icon="bi-moon" data-value="dark">
                    <i class="bi-moon me-2"></i>
                    <span class="text-truncate" title="Dark">Dark</span>
                  </a>
                </div>
              </div>

              <!-- End Style Switcher -->
            </li>


            <li class="navbar-vertical-footer-list-item">
              <!-- Language -->
              <div class="dropdown dropup">
                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="selectLanguageDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                  <img class="avatar avatar-xss avatar-circle" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/us.svg') }}" alt="United States Flag">
                </button>

                <div class="dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="selectLanguageDropdown">
                  <span class="dropdown-header">Select language</span>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/us.svg') }}" alt="Flag">
                    <span class="text-truncate" title="English">English (US)</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/gb.svg') }}" alt="Flag">
                    <span class="text-truncate" title="English">English (UK)</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/de.svg') }}" alt="Flag">
                    <span class="text-truncate" title="Deutsch">Deutsch</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/dk.svg') }}" alt="Flag">
                    <span class="text-truncate" title="Dansk">Dansk</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/it.svg') }}" alt="Flag">
                    <span class="text-truncate" title="Italiano">Italiano</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('assets/vendor/flag-icon-css/flags/1x1/cn.svg') }}" alt="Flag">
                    <span class="text-truncate" title="中文 (繁體)">中文 (繁體)</span>
                  </a>
                </div>
              </div>

              <!-- End Language -->
            </li>
          </ul>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </aside>

  <!-- End Navbar Vertical -->
