<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Chat;
use App\Models\Size;
use App\Models\User;
use App\Models\Color;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\EINModel;
use App\Models\OTPModel;
use App\Traits\AppTrait;
use App\Models\TWLStripe;
use App\Models\VendorCard;
use App\Models\ShippingType;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    use AppTrait;

    public $category_template;

    // BEFORE VERIFICATION

    public function get_started(){
        $user = Auth::user();
        return view('vendor.get_started',compact('user'));
    }

    public function verify_email(){
        $user = Auth::user();

        if($user->email_verified_at != null){
            return redirect('/vendor/dashboard');
        }

        //Send OTP to user's email
        $otpModel = new OTPModel;
        $token  = $otpModel->getOTP($user->email);

        $this->sendConfirmEmail($user->email,$token);

        // $send = Http::post("http://127.0.0.1:8000/api/sendMail", [
        //     "otp" => $token,
        //     "logo" => "https://test.thewholesalelounge.com/images/logo.png",
        //     "email" => $user->email,
        //     "website" => "The Wholesale Lounge",
        //     "website_url" => "https://test.thewholesalelounge.com"
        // ]);

        return view('vendor.verify.email');
    }

    public function emailVerify(Request $request){
        $user = Auth::user();
        $otpModel = new OTPModel;

        $validate = $otpModel->verifyOTP($user->email,$request->token);

        if($validate->status == false){
            toastr()->error('Invalid OTP','Error');

            return redirect()->back();
        }

        $user->email_verified_at = now();
        $user->save();

        toastr()->success('Email verified');
        return redirect('vendor/dashboard');

    }

    public function verify_business(Request $request){
        $user = Auth::user();
        $step = $request->step ? $request->step : "ein";

        return view('vendor.verify.business',compact('step','user'));
    }

    public function verifyBusiness(Request $request){
        try{

            $user = Auth::user();

            $validate = Validator::make($request->all(),[
                'business_name' => 'required|string',
                'address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip' => 'required|numeric',
                'proof_of_bus' => 'required|mimes:pdf,doc,docx'
            ],[
                'proof_of_bus.required' => 'Please upload your business certificate',
                'proof_of_bus.mimes' => 'Please upload either a pdf or doc file',
            ]);

            if($validate->fails()){
                foreach($validate->errors()->messages() as $key => $error){
                    toastr()->error($error[0]);
                }

                return redirect('/vendor/verify_business?step=business');
            }

            //Upload the file
            $file = $this->uploadFile($request,'proof_of_bus','businessDocs');

            if(!$file){
                toastr()->error('File upload error: File exists');
                return redirect('/vendor/verify_business?step=business');
            }

            // Save Address
            $address[] = $request->only('address','city','state','zip');

            // Save Data
            $data = [
                'proof_of_bus' => $file,
                'verify_business' => 2 //Pending
            ];

            // Save in Vendor
            $vendor = Vendor::where('user_id', $user->id)->update($data);

            //Save the Business Name
            $user->business_name = $request->business_name;
            $user->address = json_encode($address);
            $user->save();

            toastr()->success('Your documents have been submitted for approval');

            return redirect('/vendor/get_started');

        }catch(Exception $e){

        }
    }

    public function verifyCustomerReview(Request $request){
        try{

            $user = Auth::user();

            $validate = Validator::make($request->all(),[
                'customer_review' => 'required|mimes:pdf,jpg,png'
            ],[
                'customer_review.required' => 'Please upload a customer review',
                'customer_review.mimes' => 'Only pdf, jpg or png file formats are allowed'
            ]);

            if($validate->fails()){
                foreach($validate->errors()->messages() as $key => $error){
                    toastr()->error($error[0]);
                }

                return redirect('/vendor/verify_business?step=customer');
            }

            //Upload the file
            $file = $this->uploadFile($request,'customer_review','businessDocs');

            if(!$file){
                toastr()->error('File upload error: File exists');
                return redirect('/vendor/verify_business?step=customer');
            }

            // Save Data
            $data = [
                'customer_review' => $file,
                'verify_customer_review' => 2 //Pending
            ];

            // Save in Vendor
            $vendor = Vendor::where('user_id', $user->id)->update($data);

            toastr()->success('Your document has been submitted for verification');

            return redirect('/vendor/get_started');

        }catch(Exception $e){

        }
    }


    public function verifyEin(Request $request){
        try{

            $user = Auth::user();

            $validate = Validator::make($request->all(),[
                'ein' => 'required|numeric|digits:9'
            ],[
                'ein.required' => 'Please enter your EIN',
                'ein.numeric' => 'Your EIN must follow the correct format',
                'ein.digits' => 'Your EIN must be 9 digits long'
            ]);

            if($validate->fails()){
                foreach($validate->errors()->messages() as $key => $error){
                    toastr()->error($error[0]);
                }

                return redirect('/vendor/verify_business?step=ein');
            }

            // Verify EIN
            $einmodel = new EINModel;
            $response = $einmodel->verifyEin($request->ein);

            $einDetails = $response['EIN'];

            if(empty($einDetails)){
                toastr()->error('EIN record not found');
                return redirect('/vendor/verify_business?step=ein');
            }

            //? TODO: Verify the phone number and populate the vendor details VIA the EIN

            // Save Data
            $data = [
                'ein' => $request->ein,
                'verify_ein' => 3 //Verified
            ];

            // Save in Vendor
            $vendor = Vendor::where('user_id', $user->id)->update($data);

            toastr()->success('Your EIN is verified');

            return redirect('/vendor/dashboard');

        }catch(Exception $e){

        }
    }

    public function accountSetup(){
        $user = Auth::user();
        return view('vendor.account.setup',compact('user'));
    }

    /// Cards
    public function saveCard(Request $request){
        try{
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'card' => 'required|string',
            ]);

            if($validator->fails()){
                return ['code' => 1, 'msg' => $validator->errors()];
            }

            $token = json_decode($request->card,true);
            $token_id = $token['token']['id'];
            $card = json_encode($token['token']['card']);
            $type = $token['token']['type'];

            // Create an External Account
            $vendor = Vendor::where('user_id', $user->id)->first();
            $account = json_decode($vendor->account_details,true);
            $stripe = $this->initialiseStripe();
            $response = $stripe->accounts->createExternalAccount(
                $account['id'],
                ['external_account' => $token_id]
            );

            // Create a new card
            $vendorCard = VendorCard::create(['user_id' => $user->id, 'token' => $token_id, 'card' => $card, 'type' => $type, 'external_account' => $response->id]);
            $vendor->payment_setup = 1;
            $vendor->save();

            toastr()->success('Card Saved');
            return ['code' => 0, 'msg' => $vendorCard];

        }catch(Exception $e){
            info($e->getMessage());

            return ['code'=>1, 'msg'=>$e->getMessage()];
        }
    }

    public function createPaymentMethod(Request $request){
        try{
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'card' => 'required|string',
            ]);

            if($validator->fails()){
                return ['code' => 1, 'msg' => $validator->errors()];
            }

            $payM = json_decode($request->card,true);
            $payM_id = $payM['paymentMethod']['id'];
            $user->payment_method = $payM_id;
            $user->save();

            toastr()->success('Card Saved');
            return ['code' => 0, 'msg' => "Payment Method Created"];

        }catch(Exception $e){
            info($e->getMessage());

            return ['code'=>1, 'msg'=>$e->getMessage()];
        }
    }

    public function subscribe(Request $request){

        $user = Auth::user();

        if($request->method() == "GET"){

            // Check if user has set payment and has verified business
            if(!$user->vendor()->payment_setup || $user->vendor()->verify_business != 3 || $user->vendor()->verify_customer_review != 3){
                toastr()->error('Business details and payment details not verified yet.');
                return redirect()->back();
            }

            $packages = Package::where('status', 1)->get()->toArray();
            return view('vendor.verify.subscribe', compact('packages','user'));
        }

        if($request->method() == "POST"){

            // Create Subscription
            // Create a Stripe Subscription
            // Save the sub id in the database and other details



            // Subscription
            $stripe = $this->initialiseStripe();
            $twlStripe = new TWLStripe;

            // Create Customer
            // $vendorCard = VendorCard::where('user_id',$user->id)->first();
            // $createpaymentMethod = $stripe->paymentMethods->create([
            //     'type' => 'card',
            //     'card' => [
            //       'token' => $vendorCard['token']
            //     ],
            //   ]);

            // dd($createpaymentMethod);

            $newCustomer = $twlStripe->createCustomer($stripe, $user->email, $user->payment_method);
            $user->stripe_customer = $newCustomer->id;
            $user->save();
            $package = Package::find($request->package_id);
            $stripeRef = $package->getStripeRef();
            $newSub = $twlStripe->subscribe($stripe, $newCustomer->id,$stripeRef,$request->only('cycle','total'));
            $data = [
                'vendor_id' => $user->id,
                'package_id' => $request->package_id,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'stripe_reference' => json_encode($newSub),
                'from' => date("Y-m-d",$newSub->current_period_start),
                'end_date' => date("Y-m-d",$newSub->current_period_end),
                'validity' => $request->cycle
            ];

            $vendor = Vendor::where('user_id', $user->id)->first();

            $newSubscription = Subscription::create($data);

            if(!$newSubscription->id){
                toastr()->error('Subscription Failed');
                return redirect()->back();
            }

            $vendor->subscribed = 1;
            $vendor->verified = 1;
            $vendor->save();

            toastr()->success('Subscription Successful');
            return redirect('/vendor/dashboard');
        }
    }

    public function planSubscription(Request $request, $id){
        try{
            $user = Auth::user();
            $plan = Package::find($id);

            return view('vendor.verify.plan_subscribe', compact('plan','user'));
        }catch(Exception $e){

        }
    }


    //AFTER VERIFICATION

    // DASHBOARD
    public function dashboard(Request $request){
        $user = Auth::user();

        //Check if the vendor has upload Proof of Business and Customer Review
        $vendor = Vendor::where('user_id',$user->id)->first()->toArray();

        //Check if vendor has registered card
        $vendor_card = VendorCard::where('user_id', $user->id)->first();

        //Recent Sales
        $recent_sales = Order::where("orders.vendor_id", $user->id)
                                ->join('users', 'users.id', '=', 'orders.customer_id')
                                ->join('products', 'products.id', '=', 'orders.order_details->product_id')
                                ->join('order_status', 'order_status.id', '=', 'orders.status')
                                ->select('orders.id', 'products.name','orders.total_price',
                                        'orders.status','users.id as user_id', 'users.firstname',
                                        'users.lastname','orders.order_details->num_of_product as num_products',
                                        'order_status.name as status',
                                        'orders.status as status_id',
                                        'orders.order_details->product_id as prodID')
                                ->limit(5)
                                ->orderBy('orders.created_at', 'desc')
                                ->get()
                                ->toArray();

        //Top Selling Products
        $top_selling = Order::where("orders.vendor_id", $user->id)
                        ->join('products', 'products.id', '=', 'orders.order_details->product_id')
                        ->selectRaw("SUM(orders.order_details->'$.num_of_product') as sold, products.pics as picture, products.name , products.price , SUM(orders.total_price) as revenue")
                        ->groupBy('products.id')
                        ->orderBy('sold', 'desc')
                        ->get()
                        ->toArray();

        return view('vendor.dashboard', compact('user', 'vendor','vendor_card', 'recent_sales','top_selling'));
    }


    //User's Profile
    public function profile(Request $request){
        $user = Auth::user();
        $tab = $request->tab ? $request->tab : "profile";
        $vendor = Vendor::where('user_id', $user->id)->first();

        return view('vendor.profile', compact('user', 'vendor', 'tab'));
    }

    public function setLogo(Request $request){

        $user = Auth::user();
        $vendor = Vendor::where('user_id', $user->id)->first();

        $validate = Validator::make($request->all(),[
            'b_logo' => 'required|mimes:png,jpg,jpeg'
        ],[
            'b_logo.required' => 'Please upload your logo',
            'b_logo.mimes' => 'png, jpg and jpeg are the only allowed formats'
        ]);

        if($validate->fails()){
            toastr()->error($validate->errors()->first(), 'Validation Error');
            return redirect()->back()->with('tab', 'edit_profile');
        }

        //Upload the Picture
        $response = $this->uploadFile($request,'b_logo','businessLogo');

        if(!$response){
            toastr()->error('File Exists', 'Upload Error');
            return redirect()->back();
        }

        $vendor->business_logo = $response;

        $vendor->save();


        toastr()->success('Logo is set', 'Upload Success');

        return redirect()->back();
    }

    public function setBanner(Request $request){

        $user = Auth::user();
        $vendor = Vendor::where('user_id', $user->id)->first();

        $validate = Validator::make($request->all(),[
            'banner' => 'required|mimes:png,jpg,jpeg'
        ],[
            'banner.required' => 'Please upload your banner',
            'banner.mimes' => 'png, jpg and jpeg are the only allowed formats'
        ]);

        if($validate->fails()){
            toastr()->error($validate->errors()->first(), 'Validation Error');
            return redirect()->back()->with('tab', 'edit_profile');
        }

        //Upload the Picture
        $response = $this->uploadFile($request,'banner','businessBanners');

        if(!$response){
            toastr()->error('File Exists', 'Upload Error');
            return redirect()->back();
        }

        $vendor->business_banner = $response;

        $vendor->save();

        toastr()->success('Banner is set', 'Upload Success');

        return redirect()->back();
    }

    public function updateProfile(Request $request){
        $user = Auth::user();

        $validate = Validator::make($request->all(),[
            'about' => 'required|string',
            'bphone' => 'nullable|numeric',
            'twitter' => 'nullable',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'website' => 'nullable|url',
            'products' => 'required|array'
        ],[
            'bphone.required' => 'Please enter a phone number',
            'bphone.numeric' => 'Wrong phone number format'
        ]);

        if($validate->fails()){
            foreach($validate->errors()->messages() as $error){
                toastr()->error($error[0], 'Validation Error');
            }
            return redirect()->back()->with('tab', 'edit_profile');
        }

        //Update profile
        $vendor = Vendor::where('user_id', $user->id)->update([
            'about' => $request->about,
            'bphone' => $request->bphone,
            'business_website' => $request->website,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instgram,
            'products' => json_encode($request->products)
        ]);

        if(!$vendor){
            toastr()->success('Update Failes, please check your inputs', 'Error');
            return redirect()->back()->with('tab', 'edit_profile');
        }

        toastr()->success('Update Successful', 'Success');
        return redirect()->back()->with('tab', 'edit_profile');
    }


    //Add Chat Status to the table
                            //Rename admin status to general status
                            //Ongoing,Online,offline,busy,ended -> General Status

    public function uploadDoc(){
        return view('vendor.account.doc');
    }

    public function saveDoc(Request $request){
        $validate = Validator::make($request->all(),[
            'type' => 'required|string',
            'doc' => 'required|mimes:png,jpg,pdf,doc,docx'
        ]);

        if($validate->fails()){
            foreach($validate->errors()->messages() as $key => $error){
                toastr()->error($error[0]);
            }

            return redirect('/vendor/account/uploadDoc');
        }

        $user = Auth::user();
        //Upload the Doc
        $doc = $this->uploadFile($request,'doc',$request->type);

        if(!$doc){
            toastr()->error('File Exists');
            return redirect('/vendor/account/uploadDoc');
        }

        //Save the Doc
        $update = Vendor::where('user_id', $user->id)->update(["$request->type" => $doc]);

        toastr()->success('File Saved');

        return redirect('/vendor/dashboard');
    }

    public function create_product(){
        $categories = Category::where(['categories.status' => '1', 'parent_to_children.parent_id' => 0])
                                ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                                ->select('categories.id', 'categories.name','parent_to_children.parent_id')->get()->toArray();
        $tags = Tag::where('status', 1)->get()->toArray();
        $sections = Section::where('for',2)->get();
        $shipping = ShippingType::select('id','name')->get();
        // $cats = $this->buildTree($categories);
        // $this->buildTemplate($cats);
        // $category_template = $this->category_template;


        //Sizes
        $sizes = Size::select('id', 'size_code')->get()->toArray();
        $colors = Color::select('id', 'name')->get()->toArray();
        return view('vendor.products.new_product', compact('tags', 'categories','sizes', 'colors','sections','shipping'));
    }

    protected function buildTree($elements, $parent_id = 0){
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parent_id) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    protected function buildTemplate($elements, $id=[],&$option=""){
        foreach($elements as $key => $element){

            $selected = in_array($element['id'], $id) ? 'selected' : '';

            $option .= "<option $selected value='" . $element['id'] ."'>". $element['name'] ."</option>";

            if(isset($element['children'])){

                $option .= "<optgroup label='". $element['name'] . "'>";
                $this->buildTemplate($element['children'],$id,$option);

                $option .= "</optgroup>";
            }
        }

       $this->category_template = $option;
    }

    public function store(Request $request){
      
            if($request->has('save')){
                $ps = 1;

                $validator = Validator::make($request->all(),[
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'category_id' => 'required|array',
                    'tags' => 'required|array',
                    'sizes.*' => 'required|array',
                    'colors' => 'required|array',
                    'price' => 'required|numeric',
                    'no_in_stock.*' => 'required|array',
                    'pics' => 'required|array',
                    'shipping_fee' => 'integer',
                    'sections' => 'required|array',
                    'sku' => 'nullable|string',
                    'moq' => 'required|integer'
                ]);

            }else{
                $ps = 0;

                $validator = Validator::make($request->all(),[
                    'name' => 'nullable|string',
                    'description' => 'nullable|string',
                    'category_id' => 'nullable|array',
                    'tags' => 'nullable|array',
                    'sizes.*' => 'nullable|array',
                    'colors' => 'nullable|array',
                    'price' => 'nullable|numeric',
                    'no_in_stock.*' => 'nullable|array',
                    'pics' => 'nullable|array',
                    'shipping_fee' => 'integer',
                    'sections' => 'nullable|array',
                    'sku' => 'nullable|string',
                    'moq' => 'nullable|integer'
                ]);
            }

            $request->merge(['publish_status' => $ps]);
           

          //  $user = Auth::user();

            if($validator->fails() && count($request->pics) > 0){
                foreach($request->pics as $pic){
                    Storage::delete('public/products/'.$pic);
                }

                return redirect()->back()->withErrors($validator->errors());
            }

            if($validator->fails()){

                return redirect()->back()->withErrors($validator->errors());
            }

            // if($tmp->count() > 0){
            //     foreach($tmp as $tp){
            //         Storage::copy('products/tmp/'.$tp->image_uniqID . '/'.$tp->image_name,"public/products/".$tp->image_uniqID . '/'.$tp->image_name);
            //         $pics[] = $tp->image_uniqID . '/'. $tp->image_name;
            //         Storage::deleteDirectory('products/tmp/'.$tp->image_uniqID);
            //         $tp->delete();
            //     }
            // }

            $pics = $request->pics;
            $item_listing = [];
            
            for ($i=0; $i < count($request->colors); $i++) { 
                $listing = [
                    $request->sizes[$i],
                    $request->no_in_stock[$i],
                ];

                $item_listing[$request->colors[$i]] = $listing;
            }

            $user = Auth::user();

            // Attach the Vendor Id to the request
            $request->merge(['vendor_id' => $user->id,
                            'tags' => json_encode($request->tags),
                            'item_listing' => json_encode($item_listing),
                            'pics' => json_encode($pics),
                            'category_id' => json_encode($request->category_id),
                            'section_id' => json_encode($request->sections),
                        ]);
            
            //Create a new product
            Product::create($request->only('vendor_id',
                                'name','description',
                                'tags',
                                'pics','category_id','price',
                                'publish_status','section_id',
                                'shipping_fee', 'sku','item_listing','moq'
                            ));

            // Return view with Success report
            toastr()->success('New Product Saved');

            if(!$ps){
                return redirect('/vendor/products/drafts');
            }
            return redirect('/vendor/products');

    }

    public function all_products(){
        $user = Auth::user();
        $products = Product::where(["vendor_id" => $user->id, "publish_status" => 1])->get();
        return view('vendor.products.all_products', compact('products'));
    }

    public function all_drafts(){
        $user = Auth::user();
        $products = Product::where(["vendor_id" => $user->id, "publish_status" => 0])->get();
        return view('vendor.products.all_drafts', compact('products'));
    }

    public function editProduct($id){
        $product = Product::find($id);
        $categories = Category::where(['categories.status' => '1', 'parent_to_children.parent_id' => 0])
                                ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                                ->select('categories.id', 'categories.name','parent_to_children.parent_id')->get()->toArray();

        $tags = Tag::where('status', 1)->get()->toArray();
        $sections = Section::where('for',2)->get();

        //Sizes
        $sizes = Size::select('id', 'size_code')->get()->toArray();
        $colors = Color::select('id', 'name')->get()->toArray();

        //Images
        $images = json_decode($product->pics,true);


        ///category settings
        $cats = json_decode($product->category_id);
        if(count($cats) > 1){
            $subcats = Category::where(['categories.status' => '1', 'parent_to_children.parent_id' => $cats[0]])
                                ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                                ->select('categories.id', 'categories.name','parent_to_children.parent_id')->get()->toArray();
            $subcatTemp = "<option>Select</option>";
            foreach($subcats as $sb){
                $selected = in_array($sb['id'], $cats) ? 'selected' : '';
                $subcatTemp .= "<option $selected value='" .$sb['id'] . "'>" . $sb['name'] . "</option>";
            }
        }else{
            $subcatTemp  = "";
        }

        if(count($cats) > 2){
            $subcats2 = Category::where(['categories.status' => '1', 'parent_to_children.parent_id' => $cats[1]])
                                ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                                ->select('categories.id', 'categories.name','parent_to_children.parent_id')->get()->toArray();
            $subcatTemp2 = "<option>Select</option>";
            foreach($subcats2 as $sb){
                $selected = in_array($sb['id'], $cats) ? 'selected' : '';
                $subcatTemp2 .= "<option $selected value='" .$sb['id'] . "'>" . $sb['name'] . "</option>";
            }
        }else{
            $subcatTemp2  = "";
        }



        return view('vendor.products.edit_product', compact('product','tags', 'categories','sizes', 'colors', 'images', 'sections', 'subcatTemp', 'subcatTemp2', 'cats'));
    }

    public function updateProduct(Request $request){
        if($request->has('save')){
            $ps = 1;

            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required|array',
                'tags' => 'required|array',
                'sizes.*' => 'required|array',
                'colors' => 'required|array',
                'price' => 'required|numeric',
                'no_in_stock.*' => 'required|array',
                'pics' => 'required|array',
                'shipping_fee' => 'integer',
                'sections' => 'required|array',
                'sku' => 'nullable|string',
                'product_id' => 'required|integer',
                'moq' => 'required|integer'
            ]);

        }else{
            $ps = 0;

            $validator = Validator::make($request->all(),[
                'name' => 'nullable|string',
                'description' => 'nullable|string',
                'category_id' => 'nullable|array',
                'tags' => 'nullable|array',
                'sizes.*' => 'nullable|array',
                'colors' => 'nullable|array',
                'price' => 'nullable|numeric',
                'no_in_stock.*' => 'nullable|array',
                'pics' => 'nullable|array',
                'shipping_fee' => 'integer',
                'sections' => 'nullable|array',
                'sku' => 'nullable|string',
                'product_id' => 'required|integer',
                'moq' => 'nullable|integer'
            ]);
        }

        $request->merge(['publish_status' => $ps]);

        $product = Product::find($request->product_id);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $pics = $request->pics;
            $item_listing = [];
            
            for ($i=0; $i < count($request->colors); $i++) { 
                $listing = [
                    $request->sizes[$i],
                    $request->no_in_stock[$i],
                ];

                $item_listing[$request->colors[$i]] = $listing;
            }

            $user = Auth::user();

            // Attach the Vendor Id to the request
            $request->merge(['vendor_id' => $user->id,
                            'tags' => json_encode($request->tags),
                            'item_listing' => json_encode($item_listing),
                            'pics' => json_encode($pics),
                            'category_id' => json_encode($request->category_id),
                            'section_id' => json_encode($request->sections),
                        ]);

                        //Update the Product
        Product::where('id', $product->id)->update($request->only('vendor_id',
                                                'name','description',
                                                'tags','item_listing',
                                                'pics','category_id','price',
                                                'publish_status','section_id',
                                                'shipping_fee', 'sku','moq'
                                            ));

        // Return view with Success report
        toastr()->success('Updated Saved');
        if(!$ps){
            return redirect('/vendor/products/drafts');
        }
        return redirect('/vendor/products');
    }

    public function deleteProduct($id){
        $product = Product::find($id);

        foreach(json_decode($product->pics, true) as $pic){
            Storage::deleteDirectory('public/products/'.$pic);
        }

        $product->delete();

        // Return view with Success report
        toastr()->success('Product Deleted');
        return redirect('/vendor/products');
    }

    public function toggleActive(Request $request,$id){
        $validate = Validator::make($request->all(),[
            'status' => 'required|boolean'
        ]);

        if($validate->fails()){
            toastr()->error($validate->errors()[0]);
            return redirect('/vendor/products');
        }

        $product = Product::find($id);

        $product->publish_status = $request->status;
        $product->save();

        $message = $product->publish_status == 0 ? 'Disabled' : "Activated";

        // Return view with Success report
        toastr()->success("Product $message");
        return redirect('/vendor/products');
    }



    // Orders
    public function allOrders(){
       // $user = Auth::user();
       // $orders = Order::where("vendor_id", $user->id)->get();
       $orders = collect([]);
        return view('vendor.orders.all_orders', compact('orders'));
    }

    public function showOrder($id){
        $order = Order::find($id);
        $details = json_decode($order->order_details,true);
        return view('vendor.orders.show_order',compact('order','details'));
    }


    //Customers



    /// My Subscription
    public function mySubscription(){
        try{

            $user = Auth::user();

            $mySub = Subscription::where('subscriptions.vendor_id', $user->id)
                                            ->join('packages', 'packages.id','=','subscriptions.package_id')
                                            ->select('package_id', 'validity', 'subscriptions.id','from','end_date','package_name')
                                            ->first();
            $base = 1;
            $start =  floatval(strtotime(date("Y-m-d", strtotime('+ 8 days'))) - strtotime($mySub['from']))/(strtotime($mySub['end_date']) - strtotime($mySub['from']));
            $end = 1 - $start;

            return view('vendor.subscriptions.index', compact('mySub', 'start', 'end'));

        }catch(Exception $e){
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function chat(Request $request){
        $user = Auth::user();
        $chats = Chat::where('chats.vendor_id',$user->id)
                        ->join('users', 'users.id', '=', 'chats.customer_id')
                        ->select('users.firstname', 'users.lastname','chats.customer_id','chats.id')
                        ->get();
        $sessions = $chats->pluck('id')->toArray();

        if(empty($sessions)){
            $sessions = [];
            $request->session()->put(['activeChatSession'=>'']);
        }else{
            if(!$request->session()->has('activeChatSession')){
                $request->session()->put(['activeChatSession'=>$sessions[0]]);
            }
        }

        return view('vendor.chat', compact('user', 'chats', 'sessions'));
    }

    public function chatHistory(Request $request){
        $chatHistory = Chat::find($request->chat_id);

        if(!$chatHistory){
            return ['code' => 1, 'chat_message' => ""];
        }
        $request->session()->put(['activeChatSession'=>$request->chat_id]);
        $logs = $chatHistory->chat_message;
        $chatHistory->vendor_read_status = true;
        $chatHistory->save();

        return ['code' => 0, 'chat_message' => json_decode($logs, true)];
    }

    public function saveChat(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'recipient' => 'required|integer',
                'from' => 'required|integer',
                'message' => 'required|string'
            ]);


            if($validate->fails()){
                return ['code' => 1, "message" => $validate->errors()];
            }

            $msg = $request->all();

            // Save in the Database
            $vendor = $msg['source'] == 'vendor' ? $msg['from'] : $msg['recipient'];
            $customer = $msg['source'] == 'customer' ? $msg['from'] : $msg['recipient'];

            // Chat structure: from,message,time.
            $chat_message = [
                'from' => $msg['source'],
                'message' => $msg['message'],
                'time' => $msg['time']
            ];

            // Get the previous messages
            $query = Chat::where([
                        "vendor_id" => $vendor,
                        "customer_id" => $customer
                    ])->first();

            if($query){
                $all_messages = json_decode($query->chat_message, true);
            }
            $all_messages[] = $chat_message;

            $chatInsert = Chat::updateOrCreate(
                [
                    "vendor_id" => $vendor,
                    "customer_id" => $customer
                ],
                [
                    'chat_message' => json_encode($all_messages),
                    'customer_read_status' => 0,
                    'vendor_read_status' => 1
                ]
            );

            return ['code' => 1, "message" => $chatInsert];

        }catch(Exception $e){

        }
    }

    public function getCategory($id){
        $categories = Category::where(['categories.status' => '1', 'parent_to_children.parent_id' => $id])
                                ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                                ->select('categories.id', 'categories.name','parent_to_children.parent_id')->get()->toArray();

        return $categories;
    }

    public function myStore(){
        $user = Auth::user();

        $products = Category::whereIn('id', json_decode($user->vendor()->products))
                                ->select('name')
                                ->get()->toArray();
        
        return view('vendor.store.store', compact('user','products'));
    }

    public function myStoreSetup(){
        $user = Auth::user();
        $products = Category::select('id','name')->get();
        return view('vendor.store.setup', compact('user','products'));
    }

}