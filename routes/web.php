<?php

use App\Models\User;
use App\Models\Banner;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Section;
use App\Models\OTPModel;
use App\Models\ChargeBee;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Notifications\AppNotification;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorSubscribe;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController as AH;
use App\Http\Controllers\Admin\VendorController as AV;
use App\Http\Controllers\Admin\CustomerController as AC;
use App\Http\Controllers\Admin\SubscriptionController as ADSub;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', function () {
    return view('welcome');
});

//v=spf1 include:dc-aa8e722993._spfm.thewholesalelounge.com ~all

Route::get('/testEvent', function(){
    App\Events\ChatMessenger::dispatch('Hello world, I am testing this event');
});


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('shop',[HomeController::class, 'shop'])->name('shop');
Route::get('/buyer_signup', [AuthController::class, 'buyerSignup'])->name('buyerSignup');
Route::post('/validate/buyer', [AuthController::class, 'validateBuyer']);
Route::post('/validate/seller', [AuthController::class, 'validateSeller']);
Route::post('/save_buyer', [AuthController::class, 'saveBuyer'])->name('saveBuyer');
Route::match(['get', 'post'], '/seller_signup', [AuthController::class, 'sellerSignup'])->name('sellerSignup');
Route::match(['get', 'post'],'/confirm_email', [AuthController::class, 'confirmEmail']);
Route::match(['get','post'],'/login' , [AuthController::class, 'login'])->name('login');
Route::post('/save_email', [AuthController::class, 'saveEmail'])->name('saveEmail');
//Route::view('/success', 'market.success');
Route::view('/email', 'emails.confirm_email_markdown');
Route::get('/register', [AuthController::class,'register']);
Route::get('/sendotp/{email}', [AuthController::class, 'sendOtp']);
Route::post('/confirmOtp/{email}', [AuthController::class, 'confirmOtp']);

Route::prefix('market')->group(function () {
    Route::get('vendors', [HomeController::class, 'vendors']);
});

//Route::post('/register', [AuthController::class, 'register'])->name('user_save');

Route::middleware(['auth'])->group(function () {
    Route::put('/setProfile', [AuthController::class, 'setProfileImage']);
    Route::put('/updateProfile', [AuthController::class, 'updateProfile']);
    Route::put('/updateCustomerProfile', [AuthController::class, 'updateCustomerProfile']);

    //Auth Market
    Route::get('/addWishList/{id}', [WishListController::class, 'add']);
    //Market
    Route::prefix('market')->group(function () {
        Route::get('/product/{id}', [ProductController::class, 'show']);
        Route::post('/saveChat', [HomeController::class, 'saveChat']);
        Route::get('vendor/{id}', [HomeController::class, 'vendor']);
        Route::post('vendor/review', [HomeController::class, 'saveVendorRating'])->name('vendor.review');
        Route::post('product/review', [ProductController::class, 'saveProductRating'])->name('product.review');
        Route::get('/listing/{product_id}/{color_id}', [ProductController::class,'getItemsByColor']);
        Route::get('/subscribe/vendor/{id}', [VendorSubscribe::class, 'subscribe']);
        Route::get('/get/wishlist', [WishListController::class, 'getWishList']);
    });

    //Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/addCart', [CartController::class,'store']);
    Route::post('/setCartSession', [CartController::class, 'setCartSession']);

    Route::middleware(['checkout'])->group(function(){
        //Checkout
        Route::any('/checkout', [CheckoutController::class, 'checkout']);
        Route::post('/purchase', [CheckoutController::class, 'purchase']);
        Route::post('/process_checkout', [CheckoutController::class, 'process_checkout']);
        Route::get('/confirm_payment', [CheckoutController::class, 'confirm_payment']);
    });

    Route::get('/success', [CheckoutController::class, 'success']);
    Route::get('/error', [CheckoutController::class, 'error']);


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::group(['prefix' => 'customer'], function(){
        Route::get('/',[CustomerController::class, 'index'])->name('customer_profile');
        Route::get('/profile', [CustomerController::class, 'getProfile']);
        Route::post('/edit', [CustomerController::class, 'editPersonalDetails'])->name('customer_edit_details');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('customer_orders');
        Route::get('/new_address',[CustomerController::class, 'newAddress'])->name('customer_new_address');
        Route::post('/save_address',[CustomerController::class, 'saveAddress'])->name('customer_save_address');
        Route::get('/address',[CustomerController::class, 'address'])->name('customer_address_book');
        Route::get('/address/default/{id}',[CustomerController::class, 'setDefaultAddress'])->name('make_default');
        Route::get('/address/edit/{id}',[CustomerController::class, 'editAddress'])->name('edit_address');
        Route::put('/address/update/{id}',[CustomerController::class, 'updateAddress'])->name('update_address');
        Route::get('/address/delete/{id}',[CustomerController::class, 'deleteAddress'])->name('delete_address');
        Route::get('/chat', [CustomerController::class, 'chat']);
        Route::post('/saveChat', [CustomerController::class, 'saveChat']);

        Route::group(['prefix' => '/wishlists'], function(){
            Route::get('/', [WishListController::class, 'allWishList']);
            Route::get('/all_category', [WishListController::class, 'allCategory']);
            Route::post('/save_category', [WishListController::class, 'saveNewCategory']);
            Route::get('/remove/{id}', [WishListController::class, 'remove']);
            Route::put('/add_to_category/{product_id}', [WishListController::class, 'addWishListToCategory']);
        });

        Route::group(['prefix' => '/subscription'], function(){
            Route::get('/', [CustomerController::class, 'mySubscriptions']);
            Route::get('/unsubscribe/{vendor_id}', [CustomerController::class, 'unsubscribe']);
        });
    });

    Route::group(['prefix' => '/vendor'], function(){

        //Get Started
        Route::get('/get_started', [VendorController::class, 'get_started']);

        //Verify Email
        Route::get('/verify_email', [VendorController::class,'verify_email']);

        Route::post('/emailVerify', [VendorController::class,'emailVerify']);

       //Verify Business
       Route::get('/verify_business', [VendorController::class,'verify_business']);

       //Subscribe to Plan
       Route::any('/subscribe', [VendorController::class,'subscribe']);

       //Set up Subsciption
       Route::get('/plan_subscription/{id}', [VendorController::class, 'planSubscription']);

       Route::group(['prefix' => 'verify'], function(){
            Route::post('/ein',[ VendorController::class,'verifyEin']);
            Route::post('/business', [VendorController::class,'verifyBusiness']);
            Route::post('/customer_review', [VendorController::class,'verifyCustomerReview']);
       });
       Route::group(['prefix' => 'store'], function(){
            Route::get('/', [VendorController::class, 'myStore']);
            Route::get('/setup', [VendorController::class, 'myStoreSetup']);
        });

       //count Route
        Route::group(['prefix' => 'account'],function(){
            Route::get('/setup', [VendorController::class, 'accountSetup']);
            Route::post('/saveCard', [VendorController::class, 'saveCard']);
            Route::post('/createPaymentMethod', [VendorController::class, 'createPaymentMethod']);
            Route::get('/setup/initiate/{id}', [VendorController::class, 'initiateAccountSetup']);
            Route::get('/setup/confirm/{id}', [VendorController::class, 'confirmAccountSetup']);
        });

        Route::middleware(['verified'])->group(function () {
            //Dashboard
            Route::get('/dashboard', [VendorController::class, 'dashboard']);

            //Product Route
            Route::group(['prefix' => 'products'],function(){
                Route::get('/', [VendorController::class, 'all_products']);
                Route::get('/drafts', [VendorController::class, 'all_drafts']);
                Route::get('/create', [VendorController::class, 'create_product']);
                Route::post('/store', [VendorController::class, 'store']);
                Route::get('/edit/{id}', [VendorController::class, 'editProduct']);
                Route::put('/update', [VendorController::class, 'updateProduct']);
                Route::get('/delete/{id}', [VendorController::class, 'deleteProduct']);
                Route::get('/toggle_active/{id}', [VendorController::class, 'toggleActive']);
                Route::get('/uploadFile', [VendorController::class, 'upload_file']);
                Route::post('/upload', [VendorController::class, 'importProducts']);
            });

            //Orders Route
            Route::group(['prefix' => 'orders'],function(){
                Route::get('/', [VendorController::class, 'allOrders']);
                Route::get('/show/{id}', [VendorController::class, 'showOrder']);
                Route::put('/update', [VendorController::class, 'updateProduct']);
                Route::get('/toggle_active/{id}', [VendorController::class, 'toggleActive']);
            });

            Route::group(['prefix' => 'my_subscription'], function(){
                Route::get('/', [VendorController::class, 'mySubscription']);
            });

            // Customers
            Route::group(['prefix' => 'customer'], function(){
                Route::get('/', [VendorController::class, 'customers']);
                Route::get('/view/{id}', [VendorController::class, 'customer']);
                Route::any('/switch', [VendorController::class, 'switch']);
            });

            // Customers
            Route::group(['prefix' => 'discount'], function(){
                Route::get('/', [VendorController::class, 'discount']);
                Route::get('/new', [VendorController::class, 'newDiscount']);
                Route::get('/save', [VendorController::class, 'saveDiscount']);
                Route::get('/edit/{id}', [VendorController::class, 'editDiscount']);
                Route::put('/update/{id}', [VendorController::class, 'updateDiscount']);
            });

            // Reports
            Route::group(['prefix' => 'report'], function(){
                Route::any('/', [VendorController::class, 'reports']);
                Route::get('/download', [VendorController::class, 'downloadReport']);
            });

            Route::get('/chat', [VendorController::class, 'chat']);
            Route::post('/chatHistory', [VendorController::class, 'chatHistory']);
            Route::post('/saveChat', [VendorController::class, 'saveChat']);
        });

        //Profile
        // Route::get('/profile', [VendorController::class, 'profile']);
        //Profile Route
        Route::group(['prefix' => 'profile'],function(){
            Route::get('/', [VendorController::class, 'profile']);
            Route::put('/setLogo', [VendorController::class, 'setLogo']);
            Route::put('/setBanner', [VendorController::class, 'setBanner']);
            Route::put('/updateProfile', [VendorController::class, 'updateProfile']);
            Route::get('/signout', [VendorController::class, 'logout']);
        });

        Route::get('/filter', [VendorController::class, 'filter'])->name('filter');
    });


    //Product Routes
    //Route::resource('product', 'ProductController');

    // Admin
    Route::middleware(['admin'])->group(function(){
        Route::group(['prefix' => '/admin'], function(){
            //Dashboard
            Route::get('/', [AH::class, 'dashboard']);

            Route::get('/profile', [AH::class, 'profile']);

            //Categories Route
            Route::group(['prefix' => 'categories'],function(){
                Route::get('/', [CategoryController::class, 'index']);
                Route::get('/create', [CategoryController::class, 'create']);
                Route::post('/store', [CategoryController::class, 'store']);
                Route::get('/edit/{id}', [CategoryController::class, 'edit']);
                Route::put('/update', [CategoryController::class, 'update']);
                Route::get('/delete/{id}', [CategoryController::class, 'delete']);
                Route::get('/toggle_active/{id}', [CategoryController::class, 'toggleActive']);
            });

             //Sections Route
             Route::group(['prefix' => 'section'],function(){
                Route::get('/', [SectionController::class, 'index']);
                Route::get('/create', [SectionController::class, 'create']);
                Route::post('/store', [SectionController::class, 'store']);
                Route::get('/edit/{id}', [SectionController::class, 'edit']);
                Route::put('/update', [SectionController::class, 'update']);
                Route::get('/delete/{id}', [SectionController::class, 'delete']);
                Route::get('/toggle_active/{id}', [SectionController::class, 'toggleActive']);
            });


            //Slides Route
            Route::group(['prefix' => 'slide'],function(){
                Route::get('/', [SlideController::class, 'index']);
                Route::get('/create', [SlideController::class, 'create']);
                Route::post('/store', [SlideController::class, 'store']);
                Route::get('/edit/{id}', [SlideController::class, 'edit']);
                Route::put('/update', [SlideController::class, 'update']);
                Route::get('/delete/{id}', [SlideController::class, 'delete']);
                Route::get('/toggle_active/{id}', [SlideController::class, 'toggle']);
            });

            //Slides Route
            Route::group(['prefix' => 'banner'],function(){
                Route::get('/', [BannerController::class, 'index']);
                Route::get('/create', [BannerController::class, 'create']);
                Route::post('/store', [BannerController::class, 'store']);
                Route::get('/edit/{id}', [BannerController::class, 'edit']);
                Route::put('/update', [BannerController::class, 'update']);
                Route::get('/delete/{id}', [BannerController::class, 'delete']);
                Route::get('/toggle_active/{id}', [BannerController::class, 'toggle']);
            });

            //Customer Route
            Route::group(['prefix' => 'customers'],function(){
                Route::get('/', [AC::class, 'index']);
            });

            //Vendor Route
            Route::group(['prefix' => 'vendors'],function(){
                Route::get('/', [AV::class, 'index']);
                Route::get('/view/{id}', [AV::class,'show']);
                Route::get('/toggle/{id}', [AV::class,'toggle']);
                Route::get('/verifyBusiness/{response}/{id}', [AV::class, 'verifyProofOfBusiness']);
                Route::get('/verifyCustomerReview/{response}/{id}', [AV::class, 'verifyCustomerReview']);
            });

            //Tag Route
            Route::group(['prefix' => 'tag'],function(){
                Route::get('/', [TagController::class, 'index']);
                Route::get('/create', [TagController::class, 'create']);
                Route::post('/store', [TagController::class, 'store']);
                Route::get('/edit/{id}', [TagController::class, 'edit']);
                Route::put('/update', [TagController::class, 'update']);
                Route::get('/delete/{id}', [TagController::class, 'delete']);
                Route::get('/toggle_active/{id}', [TagController::class, 'toggleActive']);
            });

             //Subscription Route
             Route::group(['prefix' => 'subscription'],function(){
                Route::get('/', [ADSub::class, 'index']);
                Route::get('/create', [ADSub::class, 'create']);
                Route::post('/store', [ADSub::class, 'save']);
            });

             //Package Route
             Route::group(['prefix' => 'package'],function(){
                Route::get('/', [PackageController::class, 'index']);
                Route::get('/create', [PackageController::class, 'create']);
                Route::post('/store', [PackageController::class, 'store']);
                Route::get('/edit/{id}', [PackageController::class, 'edit']);
                Route::put('/update', [PackageController::class, 'update']);
                Route::get('/toggle_active/{id}', [PackageController::class, 'toggleActive']);
            });
        });
    });
});

//Route::view('/admin', 'layout.admin_layout');

Route::post('/subscribe', [ChargeBee::class, 'subscribe']);


Route::get('/testOTP/{email}', [OTPModel::class, 'getOTP']);
Route::get('/verifyOTP/{email}/{code}', [OTPModel::class, 'verifyOTP']);



// Route::get('testNotification', function(){
//     $data = [
//         "title" => "New Deals",
//         "message" => "New deals in place",
//         "ref" => "ORDER#123344",
//         "from" => auth()->user()->id,
//         "time" => now()->format('l F Y h:i:s '),
//         "type" => "info"
//     ];
//     Notification::send(User::find(14), new AppNotification($data));
// });

// Route::get('/updateVendors', function(){
//     Vendor::query()->update([
//         "verified" => 1,
//         "verify_ein" => 1,
//         "verify_business" => 1,
//         "verify_customer_review" => 1
//     ]);
// });

// Route::get('/address', function(){
//     $client = new \GuzzleHttp\Client();

//     $response = $client->request('GET', 'https://address-completion.p.rapidapi.com/v1/geocode/autocomplete?text=Wiebkestieg%201%20Hamburg&limit=1&lang=en&countrycodes=de', [
//         'headers' => [
//             'X-RapidAPI-Host' => 'address-completion.p.rapidapi.com',
//             'X-RapidAPI-Key' => '7f063eed88msh4724b3cc06730c1p1204b2jsn3fcdec979f05',
//         ],
//     ]);

//     echo $response->getBody();
// });

Route::get('address', [AuthController::class, 'getAddress']);

Route::get('/make_all_users_active',function(){
    DB::table('users')->whereNotNull('email_verified_at')->update(['account_status' => 1]);
});
Route::get('/downloadSample', function(){
    $path = url("storage/sample.csv");
    return redirect($path);
});
Route::get('/404', function(){
    return view('error.404');
});
