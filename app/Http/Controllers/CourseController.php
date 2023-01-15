<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\StorePaymentIntentRequest;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLesson;
use App\Models\CourseLessonContent;
use App\Models\OrderCourse;
use App\Models\UserAddress;
use App\Models\CourseLessonHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrCourses = Course::with('category')->get();

        return view('courses.index', compact(
            'arrCourses'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($slug)
    {
        $category = CourseCategory::where('slug', $slug)
            ->firstOrFail();

        $arrCourses = Course::where('category_id', $category->id)
            ->with('category')->get();

        return view('courses.category', compact(
            'arrCourses', 'category'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->firstOrFail();

        if(Auth::check()){
            $order = OrderCourse::where('course_id', $course->id)->where('user_id', Auth::id())->first();
            return view('courses.show', compact(
                'course','order'
            ));
        }
        else {
            return view('courses.show', compact(
                'course'
            ));
        }
    }

    public function update(Course $course, CourseStoreRequest $request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $data['price'] = Course::stringPriceToCents($request->price);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '') {
            $slug = $this->slugify($request->name);
        }

        if (Course::where('slug', $slug)->count()) {
            $slug .= "-1";
        }
        $data['slug'] = $slug;

        $course->update($data);

        return redirect()->route('backend.courses.edit', $course->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('backend.courses.list');
    }

    protected function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function get_billing($id)
    {
        $course = Course::with(['author', 'uploads', 'lessons'])->findOrFail($id);
        $isIncludeShipping = false;

        $countries = Country::all(['name', 'code']);
        if (auth()->user()) {
            $billing_address = auth()->user()->address_billing ? (UserAddress::find(auth()->user()->address_billing) ?? "NULL") : "NULL";
        } else {
            $billing_address = "NULL";
        }
        $user_ip = request()->ip();
        $location = geoip()->getLocation($user_ip);

        return view('courses.checkout.billing')->with([
            'countries' => $countries,
            'course' => $course,
            'locale' => 'checkout',
            'isIncludeShipping' => $isIncludeShipping,
            'billing' => $billing_address,
            'location' => $location,
        ]);
    }

    public function post_billing($id, Request $request)
    {
        $request->session()->put('billing_address1', $request->address1);
        $request->session()->put('billing_address2', $request->address2);
        $request->session()->put('billing_city', $request->city);
        $request->session()->put('billing_state', $request->state);
        $request->session()->put('billing_country', $request->country);
        $request->session()->put('billing_zipcode', $request->pin_code);
        $request->session()->put('billing_phonenumber', $request->phone);
        $request->session()->put('billing_firstname', $request->first_name);
        $request->session()->put('billing_lastname', $request->last_name);
        $request->session()->put('coupon_id', $request->coupon_id);
        if (!auth()->user()) {
            $request->session()->put('billing_email', $request->email);
        }
        if ($request->isRemember && auth()->user()) {
            $userAddress = UserAddress::find(auth()->user()->address_billing);
            if ($userAddress) {
                $userAddress->first_name = $request->first_name;
                $userAddress->last_name = $request->last_name;
                $userAddress->address = $request->address1;
                $userAddress->address2 = $request->address2;
                $userAddress->city = $request->city;
                $userAddress->state = $request->state;
                $userAddress->country = $request->country;
                $userAddress->postal_code = $request->pin_code;
                $userAddress->phone = $request->phone;
                $userAddress->update();
                $user = User::find(auth()->id());
                $user->address_shipping = $userAddress->id;
                $user->save();
            } else {
                $userAddressInfo = UserAddress::create([
                    'user_id' => auth()->id(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address1,
                    'address2' => $request->address2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'postal_code' => $request->pin_code,
                    'phone' => $request->phone,
                ]);

                $user = User::find(auth()->id());
                $user->address_billing = $userAddressInfo->id;
                $user->save();
            }
        }

        return redirect()->route('courses.payment.get', ['id' => $id]);
    }

    public function get_payment($id, Request $request)
    {
        $course = Course::with('uploads')->findOrFail($id);

        $isIncludeShipping = false;

        $coupon_id = $request->session()->get('coupon_id', 0);
        $coupon_id = $coupon_id ?? 0;

        return view('courses.checkout.payment')->with([
            'course' => $course,
            'locale' => 'checkout',
            'isIncludeShipping' => $isIncludeShipping,
            'coupon_id' => $coupon_id,
        ]);
    }

    public function create_payment_intent($id, StorePaymentIntentRequest $req)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        header('Content-Type: application/json');

        $course = Course::findOrFail($id);

        try {
            if (auth()->user()) {
                $orderId = auth()->id() . strtoupper(uniqid());
                $username = auth()->user()->first_name . " " . auth()->user()->last_name;
            } else {
                $orderId = '0' . strtoupper(uniqid());
                $username = $req->session()->get('billing_firstname') . " " . $req->session()->get('billing_lastname');
            }
            $req->session()->put('order_id', $orderId);

            $description = env('APP_NAME') . ' Order#C' . $orderId;

            ////////////////////////////////////////////////////////////////////////////////////////////////
            // Calculate the total and tax
            $coupon_code = $req->coupon_code;
            $arrCouponInfo = Coupon::getCouponByUser($coupon_code);
            $coupon = $arrCouponInfo['coupon'];

            $sub_total = $course->price;
            if ($coupon == null) {
                $shipping_option_id = $req->session()->get('shipping_option_id', 0);

                if ($shipping_option_id) {
                    $sub_total += ShippingOption::find($shipping_option_id)->price;
                }

                $taxPrice = 0;

                $total = $sub_total + floor($taxPrice + 0.5);
            } else {
                $discount = 0;
                $shipping_price = 0;

                if ($coupon->type == 0) {
                    $discount = $coupon->amount * 100;
                } else {
                    $discount = floor($sub_total * $coupon->amount / 100 + 0.5);
                }

                $shipping_option_id = $req->session()->get('shipping_option_id', 0);
                if ($shipping_option_id) {
                    $shipping_price = ShippingOption::find($shipping_option_id)->price;
                }

                $taxPrice = 0;
                if ($sub_total < $discount) {
                    $total = 0;
                } else {
                    $taxPrice = $taxPrice * ($sub_total - $discount) / $sub_total;
                    $total = $sub_total - $discount + $shipping_price + floor($taxPrice + 0.5);
                }
            }

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $total,
                'currency' => 'usd',
                'customer' => null,
                'description' => $description,
                'statement_descriptor' => substr($description, 0, 22),
                'shipping' => [
                    'address' => [
                        'city' => $req->session()->get('billing_city'),
                        'state' => $req->session()->get('billing_state'),
                        'country' => $req->session()->get('billing_country'),
                        'postal_code' => $req->session()->get('billing_zipcode'),
                        'line1' => $req->session()->get('billing_address1'),
                        'line2' => $req->session()->get('billing_address2'),
                    ],
                    'name' => $username,
                    'phone' => $req->session()->get('billing_phonenumber'),
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            return $output;
        } catch (Error $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function store_order($id, Request $request)
    {
        $this->validate($request, (new PlaceOrderRequest)->rules());

        $order = new OrderCourse();
        $total = 0;

        $course = Course::findOrFail($id);

        $order->user_id = auth()->id();
        $order->course_id = $id;
        $order->order_id = "C" . auth()->id() . strtoupper(uniqid());
        $order->price = $course->price;
        $order->payment_intent = '';

        $order->save();

        $request->session()->put('order_id', $order->id);

        return response(['ok' => true], 200);
    }

    public function finish(Request $request)
    {
        $order_id = $request->session()->get('order_id');

        $order = OrderCourse::with(['course.uploads', 'user'])->findOrFail($order_id);

        $order->status_payment = 2; // paid
        $order->payment_intent = $request->get('payment_intent');
        $order->save();

        $amount = 0;
        // $seller = $order->course->seller;
        $seller = null;
        if ($seller) {
            if ($seller->sales_commission_rate) {
                $amount = $order->price * $seller->sales_commission_rate / 100;
            } else {
                $amount = $order->price * Config::get('constants.default_sales_commission_rate') / 100;
            }
            SellersWalletHistory::create([
                'user_id' => $seller->user_id,
                'amount' => $amount,
                'order_id' => $order->id,
                'sale_type' => 2,
                'type' => 'add',
            ]);
        }

        // Mail::to(auth()->user()->email)->send(new OrderPlacedMail($order));

        // $request->session()->forget('order_id');
        // redirect to order details
        return view('courses.checkout.detail', ['order' => $order]);
    }

    public function cancel(CancelCheckoutRequest $req)
    {
        $order_id = $req->session()->get('order_id');
        $error = $req->error;
        $order = OrderCourse::findOrFail($order_id);

        $order->status_payment = 2;
        $order->payment_intent = $error['payment_intent']['id'];
        $order->status_payment_reason = $error['code'];
        $order->save();

        $req->session()->forget('order_id');

        return response(null, 204);
    }

    public function orders(Request $request)
    {
        $user_id = auth()->id();
        $orders = OrderCourse::with('course')->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);

        return view('courses.orders', ['orders' => $orders]);
    }

    public function order_detail($id)
    {
        $order = OrderCourse::with(['course.uploads'])->where('order_id', $id)->first();
        return view('courses.order_detail', ['order' => $order]);
    }

    public function take_show(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)
            ->firstOrFail();
        $isPurchased = !!OrderCourse::where([
            "user_id" => Auth::id(),
            "course_id" => $course->id
        ])->count();
        if( $isPurchased == false ) {
            return redirect()->route("courses.show", [
                "slug" => $slug
            ]);
        }
        $displayText = $course->description;
        $currentId = -1;
        if($request->has("content")){
            $currentId = $request->content;
            $lessonContent = CourseLessonContent::find($request->content);
            if( $lessonContent ) $displayText = $lessonContent->content;
        }
        $lesson = CourseLesson::where('course_id', $course->id)->pluck('id')->toArray();
        $content = CourseLessonContent::whereIn('lesson_id', $lesson)->pluck('id')->toArray();
        $history = CourseLessonHistory::where('user_id', Auth::id())->whereIn('lesson_content_id', $content)->orderBy('id', 'DESC')->pluck('lesson_content_id')->first();

        $nextId = $request->content;
        $key = array_search($request->content, $content);
        if( $key < count($content) - 1 ) $nextId = $content[$key + 1];

        return view('courses.take.show', compact(
            'course', 'history', 'displayText', 'currentId', 'nextId'
        ));
    }

    public function complete_lesson(Request $request, $id)
    {
        $obj = [
            'user_id' => Auth::id(),
            'lesson_content_id' => $id,
            'status' => 1,
        ];
        CourseLessonHistory::updateOrCreate($obj, $obj);
        return redirect(route(
            "courses.take",
            [
                "slug" => $request->slug,
                "content" => $request->content
            ]
        ));
    }
}
