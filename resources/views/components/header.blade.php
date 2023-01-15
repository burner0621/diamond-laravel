<header>
    <nav class="navbar bg-white navbar-expand-lg container p-0" aria-label="Light offcanvas navbar">
        <div class="container navbar-container">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight">
                    <i class="bi bi-list"></i>
                </button>
                <a class="navbar-brand fw-800" href="{{ route('index') }}">
                    {{--                    <img src="{{ asset('img/logo.png') }}" width="50" height="50" alt="logo">--}}
                    {{--                    <img class="logo"--}}
                    {{--                         src="https://districtgurus.com/public/uploads/all/SC008HOLHmfOeB8E3SxNDONHI7nad1YJcmSl0ds9.png"--}}
                    {{--                         data-src="https://districtgurus.com/public/uploads/all/SC008HOLHmfOeB8E3SxNDONHI7nad1YJcmSl0ds9.png"--}}
                    {{--                         alt="District Gurus">--}}
                    #JEWELRYCG
                </a>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight"
                     aria-labelledby="offcanvasNavbarLightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">
                            <!--<img src="{{ asset('img/logo.png') }}" width="50" height="50" alt="logo">-->
                            #JEWELRYCG
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav">
                            <li class="nav-item menu-area d-none">
                                <a class="nav-link" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item menu-area">
                                <a class="nav-link active" href="{{ route('shop_index') }}">3D Models</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" aria-current="page" id="navbarDropdown"
                                   role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false" href="#">Learn</a>
                                <ul class="dropdown-menu half-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('blog') }}">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="dropdown-icon-wrap"><i class="bi bi-book"></i></div>
                                                </div>
                                                <div class="col-auto w-80">
                                                    <div class="mb-2 w-100 fw-800">Blog</div>
                                                    <div class="w-100">Learn product design in just 16 weeks...</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('courses.index') }}">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="dropdown-icon-wrap"><i class="bi bi-book"></i></div>
                                                </div>
                                                <div class="col-auto w-80">
                                                    <div class="mb-2 w-100 fw-800">Browse our courses</div>
                                                    <div class="w-100">Learn how to create jewelry & start a business.
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!--
                        <li><a class="dropdown-item" href="{{ route('categoryAll') }}">Categories</a></li>
                        <li><a class="dropdown-item" href="{{ route('tagAll') }}">Tags</a></li>
                        -->
                                </ul>
                            </li>
                            <li class="nav-item menu-area">
                                <a class="nav-link" href="{{ route('services.all') }}">Hire a Pro</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <nav>
                <ul class="ml-auto navbar-nav header-menu-action align-items-end">
                    <li class="nav-item dropdown menu-area">
                        <a href="{{route('cart.index')}}" class="nav-link">
                            <?php
                            if (Cart::instance('default')->content()->count() == 0
                                && auth()->check()
                            ) {
                                Cart::merge(auth()->id());
                            }
                            ?>
                            @if ($cart_items = Cart::content()->count())

                                <i class="bi bi-cart"></i> (<span class="cart-count"><span class="cart-count-number">{{$cart_items}}</span></span>)
                            @endif
                        </a>
                    </li>

                    @auth
                        @php
                            $new_count =Auth::user()->notifications()->where('status', 0)->count();
                            $notifications = Auth::user()->notifications()->whereBetween('status', [0,1])
                                ->orderBy('notifications.updated_at', 'desc')->get();
                            $message_notifications = app(\App\Models\Message::class)->getChatMessageOfUserLogin();
                            $user_id = Auth::id();
                            function user_name ($id) {
                                return App\Models\User::where('id',$id)->get();
                            }
                            $seller_id = App\Models\Product::groupBy('vendor')->get('vendor');
                            $role = false;
                            foreach($seller_id as $t){
                                if($user_id == $t->vendor){
                                    $role = true;
                                }
                            }

                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link notification-badge-container" aria-current="page" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                                <i class="bi bi-bell header-icon-response fs-18">
                                    @if ($new_count)
                                        <div class="notification-badge">{{ $new_count }}</div>
                                    @endif
                                </i>
                            </a>
                            <ul class="dropdown-menu half-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="dropdown-header pb-2 mb-3 border-bottom">
                                    <span class="dropdown-title">Notifications (0)</span>
                                </div>
                                <div class="content-max-scroll">
                                @foreach ($notifications as $notification)
                                    <a href="/notifications/check/{{$notification->id}}">
                                        <div class="notification-container mb-3">
                                            <img class="notification-thumb"
                                                 src="{{$notification->thumb ? $notification->thumb : "/assets/img/jewelrycg_default_logo.png"}}">
                                            <div class="notification-body">
                                                <p class="notification-message text-black">{{ $notification->message }}</p>
                                                <p class="notification-time">{{ get_period($notification->created_at) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                </div>
                            </ul>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link notification-badge-container" aria-current="page" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                                <i class="bi bi-envelope header-icon-response fs-18">
                                    <div class="notification-badge"></div>
                                </i>
                            </a>

                            <ul class="dropdown-menu half-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                style="width:250px;">
                                <div class="dropdown-header pb-2 mb-2 border-bottom">
                                    <span class="dropdown-title">Messages (0)</span>
                                </div>
                                <div class="content-max-scroll">
                                @foreach ($message_notifications as $message_notification)
                                    @if(user_name($message_notification->user_id)->first())
                                        <a href="/chat/{{$message_notification->user_id }}"
                                           class="filterDiscussions all unread single active d-block py-2 border-bottom text-black"
                                           data-toggle="list" role="tab">
                                            <div class="row">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-10px w-50px">
                                                        <img class="w-100 rounded-circle"
                                                             src="{{optional(optional(user_name($message_notification->user_id)->first())->uploads)->getImageOptimizedFullName(100,100)}}"
                                                             data-toggle="tooltip" data-placement="top" title="Janette"
                                                             alt="{{optional(user_name($message_notification->user_id)->first())->first_name}} avatar">
                                                    </div>
                                                    <div class="col- fs-14 fw-700 d-flex align-items-center">
                                                            <p class="fw-700 mb-0 mr-5px">{{optional(user_name($message_notification->user_id)->first())->full_name}}</p>
                                                            <div class="badge bg-success float-right">
                                                                <span>{{$message_notification->cnt > 0 ? $message_notification->cnt :  0}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                                </div>
                            </ul>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" aria-current="page" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                            <!--{{ Auth::user()->first_name }}-->
                            <img src="{{user_name(Auth::user()->id)[0]->uploads->getImageOptimizedFullName(100,100)}}" alt="avatar" class="w-30px rounded-circle img-fluid">
                            </a>
                            <ul class="dropdown-menu small-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="d-flex align-items-center py-2">
                                    <div class="mr-10px w-40px">
                                        <img
                                            src="{{user_name(Auth::user()->id)[0]->uploads->getImageOptimizedFullName(100,100)}}"
                                            alt="avatar" class="rounded-circle img-fluid">
                                    </div>
                                    <div class="fs-14 mr-10px">
                                        <div
                                            class="data fw-700 pb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                        <div
                                            class="data pb-1">{{ Auth::user()->username ? "@".Auth::user()->username :"@username" }}</div>
                                        <div class="data"><a class="text-primary" href="{{ route('logout') }}">Sign
                                                out</a>
                                        </div>
                                    </div>
                                </div>

                                @if (auth()->user()->role == 2)
                                    <div class="seperated-menu d-flex py-2 border-top">
                                        <ul>
                                            <div class="seller-menu-title text-uppercase fs-14 pb-2 fw-700 w-100">Seller
                                            </div>
                                            <li><a class="dropdown-item" href="{{route('seller.dashboard')}}">Seller
                                                    Dashboard</a></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.profile') }}">Seller
                                                    Profile
                                                    Settings</a></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.service.orders') }}">My
                                                    Orders</a></li>
                                            <li><a class="dropdown-item" href="{{route('seller.services.list')}}">My
                                                    Services</a></li>
                                            <li><a class="dropdown-item"
                                                   href="{{ route('seller.transaction.history') }}">Wallet
                                                    History</a></li>
                                        </ul>
                                    </div>
                                @endif

                                <div class="seperated-menu d-flex py-2 border-top">
                                    <ul>
                                        <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{route('orders.index')}}">{{ auth()->user()->role ? 'All Orders' : 'My Orders' }}</a>
                                        </li>
                                        <!--<li><a class="dropdown-item" href="{{route('wishlist')}}">My Wishlist</a></li>-->
                                    </ul>
                                </div>

                                <div class="seperated-menu d-flex py-2 border-top">
                                    <ul>
                                        <li><a class="dropdown-item" href="{{route('user.index', auth()->user()->id)}}">Settings</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="seperated-menu d-flex py-2 border-top">
                                    <ul>
                                        <li><a class="dropdown-item" href="{{ route('contactus.index') }}">Help</a></li>
                                        <li><a class="dropdown-item" href="{{ route('contactus.index') }}">Send Feedback</a></li>
                                    </ul>
                                </div>
                            </ul>
                        </li>
                    @else
                        <li class="ml-1 nav-item">
                            <a class="auth-btn" href="{{ route('login') }}">Log In</a>
                        </li>
                        <li class="ml-1 nav-item">
                            <a class="auth-btn auth-primary" href="{{ route('signup') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
                <!--end right nav-->
            </nav>
        </div>
    </nav>
</header>

<script>
    $(document).ready(function () {
        console.log("loaded");
        $('.notification-badge-container').click(function () {
            console.log("clicked");
            $.ajax({
                url: '{{ route("notifications.overview") }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('.notification-badge').hide();
                    console.log(response);
                }
            })
        })
    })
</script>
