<!-- Navbar Vertical -->
  <aside id="navbarSupportedContent" class="sidebar collapse col-lg-2 col-sm-12">
    <div class="navbar-vertical-container">
      <div class="navbar-vertical-footer-offset">

        <!-- Content -->
        <div class="navbar-vertical-content">
          <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
            <div class="nav-item">
                <a class="nav-link nav-link-main " href="/backend" data-placement="left">
                  <i class="bi-house-door nav-icon"></i>
                  <span class="nav-link-title">{{ __("Dashboard") }}</span>
                </a>
              </div>

            <span class="dropdown-header">{{ __("Users Management") }}</span>

            <!-- Collapse -->
            <div class="navbar-nav nav-compact">

            </div>
            <div id="navbarVerticalMenuPagesMenu">
              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuPagesUsersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuPagesUsersMenu">
                  <i class="bi-people nav-icon"></i>
                  <span class="nav-link-title">{{ __("Users") }} <span class="badge bg-primary rounded-pill ms-1">5</span></span>
                </a>

                <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse @if($activePage == 'users') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link {{ \Route::currentRouteName() == 'backend.users.list' ? 'active' : ''}}" href="{{ route('backend.users.list') }}">{{ __("All Users") }}</a>
                  <a class="nav-link {{ \Route::currentRouteName() == 'backend.customers.list' ? 'active' : ''}}" href="{{ route('backend.customers.list') }}">{{ __("Customers") }}</a>
                  <a class="nav-link {{ \Route::currentRouteName() == 'backend.sellers.list' ? 'active' : ''}}" href="{{ route('backend.sellers.list') }}">{{ __("Sellers") }} <span class="badge bg-primary rounded-pill ms-1">5</span></a>
                  <a class="nav-link " href="#">{{ __("Profile") }}</a>
                  <a class="nav-link {{ strpos('backend.memberships', \Route::currentRouteName()) == 0 ? 'active' : ''}}" href="{{ route('backend.memberships.list') }}">{{ __("Membershpis") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <span class="dropdown-header mt-4">{{ __("Content") }}</span>

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllPostMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPostMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPostMenu">
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
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllserviceMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllserviceMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllserviceMenu">
                  <i class="bi bi-pin-angle-fill nav-icon"></i>
                  <span class="nav-link-title">{{ __("Service") }}</span>
                </a>

                <div id="navbarVerticalMenuAllserviceMenu" class="nav-collapse collapse @if($activePage == 'services') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allservice') active @endif" href="{{ route('backend.services.list') }}">{{ __("All service") }}</a>
                  <a class="nav-link @if($navName == 'servicecategories') active @endif" href="{{ route('backend.service.categories.list') }}">{{ __("Categories") }}</a>
                  <a class="nav-link @if($navName == 'servicetags') active @endif" href="{{ route('backend.service.tags.list') }}">{{ __("Tags") }}</a>
                  <a class="nav-link @if($navName == 'servicearchive') active @endif" href="{{ route('backend.services.archive') }}">{{ __("Archived Services") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllCourseMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllCourseMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllCourseMenu">
                  <i class="bi bi-pin-angle-fill nav-icon"></i>
                  <span class="nav-link-title">{{ __("Course") }}</span>
                </a>

                <div id="navbarVerticalMenuAllCourseMenu" class="nav-collapse collapse @if($activePage == 'courses') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allcourse') active @endif" href="{{ route('backend.courses.list') }}">{{ __("All Course") }}</a>
                  <a class="nav-link @if($navName == 'addcourse') active @endif" href="{{ route('backend.courses.create') }}">{{ __("Create Course") }}</a>
                  <a class="nav-link @if($navName == 'coursecategories') active @endif" href="{{ route('backend.courses.categories.list') }}">{{ __("Categories") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllPagesMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPagesMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPagesMenu">
                  <i class="bi-stickies nav-icon"></i>
                  <span class="nav-link-title">{{ __("Pages") }}</span>
                </a>

                <div id="navbarVerticalMenuAllPagesMenu" class="nav-collapse collapse @if($activePage == 'page') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link " href="{{ route('backend.page.index') }}">{{ __("All Pages") }}</a>
                  <a class="nav-link " href="{{ route('backend.page.create') }}">{{ __("Add New") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllStepMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllStepMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllStepMenu">
                  <i class="bi-folder2-open nav-icon"></i>
                  {{ __("Steps") }}
                </a>

                <div id="navbarVerticalMenuAllStepMenu" class="nav-collapse collapse @if($activePage == 'steps') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allstep') active @endif" href="{{ route('backend.steps.list') }}">{{ __("All step") }}</a>
                  <a class="nav-link @if($navName == 'addstep') active @endif" href="{{ route('backend.steps.create') }}">{{ __("Create step") }}</a>

                  <a class="nav-link @if($navName == 'allstep_group') active @endif" href="{{ route('backend.step_groups.list') }}">{{ __("All step group") }}</a>
                  <a class="nav-link @if($navName == 'addstep_group') active @endif" href="{{ route('backend.step_groups.create') }}">{{ __("Create step group") }}</a>
                </div>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllMaterialMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllMaterialMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllMaterialMenu">
                  <i class="bi-folder2-open nav-icon"></i>
                  {{ __("Materials") }}
                </a>

                <div id="navbarVerticalMenuAllMaterialMenu" class="nav-collapse collapse @if($activePage == 'materials') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allmaterial') active @endif" href="{{ route('backend.materials.list') }}">{{ __("All material") }}</a>
                  <a class="nav-link @if($navName == 'addmaterial') active @endif" href="{{ route('backend.materials.create') }}">{{ __("Create material") }}</a>

                  <a class="nav-link @if($navName == 'allmaterial_type') active @endif" href="{{ route('backend.material_types.list') }}">{{ __("All material type") }}</a>
                  <a class="nav-link @if($navName == 'addmaterial_type') active @endif" href="{{ route('backend.material_types.create') }}">{{ __("Create material type") }}</a>
                </div>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllProductMeasurementsMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllProductMeasurementsMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllProductMeasurementsMenu">
                  <i class="bi-folder2-open nav-icon"></i>
                  {{ __("Product Measurements") }}
                </a>

                <div id="navbarVerticalMenuAllProductMeasurementsMenu" class="nav-collapse collapse @if($activePage == 'measurements') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'all_measurements') active @endif" href="{{ route('backend.measurements.list') }}">{{ __("All measurements") }}</a>
                  <a class="nav-link @if($navName == 'add_measurement') active @endif" href="{{ route('backend.measurements.create') }}">{{ __("Create measurement") }}</a>
                </div>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllDiamondMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllDiamondMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllDiamondMenu">
                  <i class="bi-folder2-open nav-icon"></i>
                  {{ __("Diamonds") }}
                </a>

                <div id="navbarVerticalMenuAllDiamondMenu" class="nav-collapse collapse @if($activePage == 'diamonds') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'alldiamond') active @endif" href="{{ route('backend.diamonds.list') }}">{{ __("All diamond") }}</a>
                  <a class="nav-link @if($navName == 'adddiamond') active @endif" href="{{ route('backend.diamonds.create') }}">{{ __("Create diamond") }}</a>
                </div>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main @if($activePage == 'filemanager') collapse @endif" href="{{ route('backend.file.index')}}" data-placement="left">
                  <i class="bi-folder2-open nav-icon"></i>
                  <span class="nav-link-title">File Manager</span>
                </a>
              </div>

              <span class="dropdown-header mt-4">{{ __("Commerce") }}</span>

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllProductsMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllProductsMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllProductsMenu">
                  <i class="bi-basket nav-icon"></i>
                  <span class="nav-link-title">{{ __("Products") }}</span>
                </a>

                <div id="navbarVerticalMenuAllProductsMenu" class="nav-collapse collapse @if($activePage == 'products') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allproducts') active @endif" href="{{ route('backend.products.list') }}">{{ __("All Products") }}</a>
                  <a class="nav-link @if($navName == 'activeproducts') active @endif" href="{{ route('backend.products.active.list') }}">{{ __("Active Products") }}</a>
                  <a class="nav-link @if($navName == 'pendingproducts') active @endif" href="{{ route('backend.products.pending.list') }}">
                    <span class="nav-link-title">{{ __("Pending Products") }}
                      @if (pending_count())
                        <span class="badge bg-primary rounded-pill ms-1">{{ pending_count() }}</span>
                      @endif
                    </span>
                  </a>
                  <a class="nav-link @if($navName == 'sellereditproducts') active @endif" href="{{ route('backend.products.edit_pending.list') }}">
                    <span class="nav-link-title">{{ __("Seller Edit Products") }}
                    </span>
                  </a>
                  <a class="nav-link @if($navName == 'addproduct') active @endif" href="{{ route('backend.products.create') }}">{{ __("Create Product") }}</a>
                  <a class="nav-link @if($navName == 'attributes') active @endif " href="{{route('backend.products.attributes.list')}}">{{ __("Attributes") }}</a>
                  <a class="nav-link @if($navName == 'productscategories') active @endif" href="{{ route('backend.products.categories.list') }}">{{ __("Categories") }}</a>
                  <a class="nav-link @if($navName == 'productstags') active @endif" href="{{ route('backend.products.tags.list') }}">{{ __("Tags") }}</a>
                  <a class="nav-link @if($navName == 'productsarchive') active @endif" href="{{ route('backend.products.archive') }}">{{ __("Archived Products") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllOrdersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllOrdersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllOrdersMenu">
                  <i class="bi bi-receipt nav-icon"></i>
                  <span class="nav-link-title">{{ __("Orders") }}</span>
                </a>

                <div id="navbarVerticalMenuAllOrdersMenu" class="nav-collapse collapse @if($activePage == 'orders') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'orderslist') active @endif" href="{{ route('backend.orders.list') }}">{{ __("All Orders") }}</a>
                  <a class="nav-link {{$navName}} @if($navName == 'ordersPending') active @endif" href="{{ route('backend.orders.pending') }}">{{ __("Pending") }} <span id="pendingBadge" class="badge bg-primary rounded-pill ms-1">{{ "" }}</span></a>
                </div>
              </div>
              <!-- End Collapse -->

              <div class="nav-item">
                <a class="nav-link nav-link-main" href="{{ route('backend.coupons.list') }}">
                  <i class="bi-folder2-open nav-icon"></i>
                  {{ __("Coupons") }}
                </a>

                <div id="navbarVerticalMenuAllCouponMenu" class="nav-collapse collapse @if($activePage == 'coupons') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'allcoupon') active @endif" href="{{ route('backend.coupons.list') }}">{{ __("All coupon") }}</a>
                  <a class="nav-link @if($navName == 'addcoupon') active @endif" href="{{ route('backend.coupons.create') }}">{{ __("Create coupon") }}</a>
                </div>
              </div>

              <!-- Collapse -->
              <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllWithdrawMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllWithdrawMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllWithdrawMenu">
                  <i class="bi-wallet nav-icon"></i>
                  <span class="nav-link-title">{{ __("Withdraw") }}</span>
                </a>

                <div id="navbarVerticalMenuAllWithdrawMenu" class="nav-collapse collapse @if($activePage == 'withdraws') show @endif" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link @if($navName == 'withdrawmethods') active @endif" href="{{ route('backend.withdraws.method') }}">{{ __("Withdraw Methods") }}</a>
                  <a class="nav-link @if($navName == 'withdraws') active @endif" href="{{ route('backend.withdraws.list') }}">
                    <span class="nav-link-title">{{ __("Withdraws") }}
                      @if (new_withdraw_count())
                        <span class="badge bg-primary rounded-pill ms-1">{{ new_withdraw_count() }}</span>
                      @endif
                    </span>
                  </a>
                </div>
              </div>
              <!-- End Collapse -->

              <div class="nav-item">
                <a class="nav-link nav-link-main " href="#" data-placement="left">
                  <i class="bi-folder2-open nav-icon"></i>
                  <span class="nav-link-title">Reports</span>
                </a>
              </div>

              <span class="dropdown-header mt-4">{{ __("Configuration") }}</span>

              <div class="nav-item">
                <a class="nav-link nav-link-main " href="{{ route('backend.tax.index') }}" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title @if($navName == 'tax') active @endif">Tax</span>
                </a>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main " href="{{ route('backend.shipping.index') }}" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title @if($navName == 'Shipping') active @endif">Shipping</span>
                </a>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main " href="{{ route('backend.general.index') }}" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title @if($navName == 'ordersPending') active @endif">General</span>
                </a>
              </div>

              <div class="nav-item">
                <a class="nav-link nav-link-main " href="#" data-placement="left">
                  <i class="bi-key nav-icon"></i>
                  <span class="nav-link-title @if($navName == 'ordersPending') active @endif">API Keys</span>
                </a>
              </div>

        </div>
        <!-- End Content -->

        <!-- Footer -->
        <div class="navbar-vertical-footer">
          <ul class="navbar-vertical-footer-list">
          </ul>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </aside>

  <!-- End Navbar Vertical -->

  <script>
    $(function() {
      $.ajax({
        url: "{{ url('backend/orders') }}",
        type: 'post',
        data: {
          "_token": "{{ csrf_token() }}",
          status: $(this).val()
        },
        success: function (data) {
          $("#pendingBadge").html(data);
        }
      })
      // $(document).on('click', '.sidebar .nav-item .nav-link', function(){
      //   $('.sidebar .nav-item .nav-link').removeClass('active');
      //   $(this).addClass('active');
      // })
    });
  </script>
