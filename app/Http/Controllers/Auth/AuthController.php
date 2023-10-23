<?php

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use Exception;
use \Stripe\StripeClient as Stripe;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Customer;
use App\Traits\AppTrait;
use App\Models\SecretKey;
use App\Mail\ConfirmEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use AppTrait;

    public function initialiseStripe(){
        $key = new SecretKey;
        $stripe = new Stripe($key->getSecret());
        return $stripe;
    }

    public function register(){
        return view('market.register');
    }

    public function buyerSignup(){
        return view('market.buyer_signup')->with(['data' => 'buyer_signup']);
    }

    public function sellerSignup(Request $request){
        if($request->method() == 'POST'){
            $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|between:8,16',
                'zip_code' => 'required|integer',
                'business_name' => 'required|string',
                'address' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                // 'ein' => 'required|numeric|digits:9',
                'products' => 'required|array',
                'consent' => 'required|string'
            ]);

            $fullname = $request->firstname . " " . $request->lastname;

            if(strtolower($request->consent) != strtolower($fullname)){
                toastr()->error('Please enter your fullname to agree with the T and C');
                return redirect('/seller_signup');
            }

             /**
             * Give the vendor a role of 2 and set the account status to 0 and generate user_code
             * */
            $user_code = $this->generateUserCode();
            $request->merge(['role' => 2,'account_status' => 0,'password' => Hash::make($request->password), 'user_code' => $user_code]);
            $address[] = $request->only('address','state','city');
            // Save to Users and Customers Table
            $users_data = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password,
                'zip_code' => $request->zip_code,
                'business_name' => $request->business_name,
                'address' => json_encode($address),
                'role' => $request->role,
                'account_status' => $request->account_status,
                'password' => $request->password,
                'user_code' => $user_code,
                'country_code' => 840
            ];

            //Create an Account on stripe
            $stripe = $this->initialiseStripe();
            $response = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'US',
                'email' => $request->email,
                "business_type" => "individual",
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                // 'individual' => [
                //     'address' => $request->address,
                //     'first_name' => $request->firstname,
                //     'last_name' => $request->lastname
                // ],
                // 'company' => [
                //     'name' => $request->business_name
                // ]
            ]);

            $new_user = User::create($users_data);

            //Insert customers
            $new_customer = Vendor::create(
                [
                    'user_id' => $new_user->id,
                    // 'ein' => $request->ein,
                    'products' => json_encode($request->products),
                    'account_details' => json_encode($response)
                ]
            );

            // Send Confirmation Email
             $this->sendConfirmEmail($request->email, $user_code);

            return redirect('/login');
        }


        // $response = Http::get('https://restcountries.com/v3.1/all');

        // $country_collection = collect($response->json())->map(function($item){
        //     return [
        //         'name' => $item['name']['common'],
        //         'cca2' => $item['cca2']
        //     ];
        // });

        $categories = Category::where('parent_to_children.parent_id',0)
                                ->join('parent_to_children','parent_to_children.category_id','=','categories.id')
                                ->get();

        return view('market.seller_signup')->with(['data' => 'seller_signup','categories' => $categories]);
    }

    public function saveBuyer(Request $request){

        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|between:8,16',
            'zip_code' => 'required|integer',
            'business_name' => 'required|string',
            'address' => 'required|string',
            'cert' => 'required|mimes:pdf,doc',
            'add_cert' => 'mimes:pdf,doc',
            'yes' => 'required|boolean'
        ]);

        /**
         * Give the buyer a role of 1 and set the account status to 0
         * */
        $user_code = $this->generateUserCode();
        $request->merge(['role' => 1,'account_status' => 0,'password' => Hash::make($request->password)]);

        $customer_path = $this->uploadFile($request,'cert','customer');

        if(!$customer_path){
            toastr()->error('File Exists!');
            return redirect('/buyer_signup');
        }

        if($request->file('add_cert')){
            $add_cert_path = $this->uploadFile($request,'add_cert','customer');

            if(!$add_cert_path){
                toastr()->error('File Exists!');
                return redirect('/buyer_signup');
            }
        }else{
            $add_cert_path = "";
        }

        $address[] = $request->only('address');

        // Save to Users and Customers Table
        $users_data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'zip_code' => $request->zip_code,
            'business_name' => $request->business_name,
            'address' => json_encode($address),
            'role' => $request->role,
            'account_status' => $request->account_status,
            'password' => $request->password,
            'user_code' => $user_code
        ];

        $new_user = User::create($users_data);

        //Insert customers
        $new_customer = Customer::create([
            'user_id' => $new_user->id,
            'cert' => $customer_path,
            'add_cert' => $add_cert_path
        ]);

         // Send Confirmation Email
         $this->sendConfirmEmail($request->email, $user_code);

        return redirect('/success');
    }

    public function logout(){
        Auth::logout();

        return redirect('/');
    }

    public function confirmEmail(Request $request){

        $user = User::where('user_code', $request->user)->first();

        if(!$user){
            toastr()->error('Invald ID, email not confirmed');
        }else{
            if(Hash::check($user->email, $request->token)){
                // Update the email to confirmed
                $user->email_verified_at = now();
                $user->save();

                //Login the User
                Auth::login($user);
                toastr()->success('Email Verified, you can start using our services');

                // redirect to the respective routes
                if($user->role == 1){
                    // redirect to Customer Page
                    return redirect('/customer/profile');
                }elseif($user->role == 2){
                    // redirect to vendor's page
                    return redirect('/vendors/dashboard');
                }elseif($user->role == 3){
                    return  redirect('/admin');
                }

            }else{
                toastr()->error('Invald token, email not confirmed');
            }
        }

        return redirect('/');
    }

    public function login(Request $request){
        if($request->method() == 'GET'){
            return view('market.login',['data'=>'login']);
        }

        $validator = Validator::make($request->only('email','password'),[
            'email' => 'required|email',
            'password' => 'required|string|between:8,16'
        ]);

        if($validator->fails()){
            toastr()->error($validator->errors()->first());
            return redirect('/login');
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            toastr()->error('Email does not exist');
        }else{

            if(Hash::check($request->password, $user->password)){
                Auth::login($user);
                toastr()->success('Login Succesful');

                if($user->role == 1){
                    return redirect('/customer/profile');
                }

                if($user->role == 2){
                    return redirect('/vendor/dashboard');
                }

            }else{
                toastr()->error('Wrong Password');
            }
        }

       return redirect('/');
    }

    protected function setCookie(Request $request){
        $min = 5;
        $name = Hash::make($request->email);
        $cookie = cookie($name,$request->email,$min);
        return response($name)->withCookie($cookie);
    }


    public function setProfileImage(Request $request){

        $user = Auth::user();

        $validate = Validator::make($request->all(),[
            'profile' => 'required|mimes:png,jpg,jpeg'
        ],[
            'profile.required' => 'Please upload your profile image',
            'profile.mimes' => 'png, jpg and jpeg are the only allowed formats'
        ]);

        if($validate->fails()){
            toastr()->error($validate->errors()->first(), 'Validation Error');
            return redirect()->back()->with('tab', 'edit_profile');
        }

        //Upload the Picture
        $response = $this->uploadFile($request,'profile','profileImage');

        if(!$response){
            toastr()->error('File Exists', 'Upload Error');
            return redirect()->back();
        }

        $user->profile = $response;
        $user->save();


        toastr()->success('Profile Image set', 'Upload Success');

        return redirect()->back();
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        $validate = Validator::make($request->all(),[
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'nullable|numeric',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'zip' => 'required|numeric'
        ]);

        if($validate->fails()){
            toastr()->error($validate->errors()->first(), 'Validation Error');
            return redirect()->back()->with('tab', 'edit_profile');
        }

        //Create Address
        $address = json_decode($user->address,true);
        $address[0] = $request->only('address','state','city');
        $user->address = json_encode($address);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->zip_code = $request->zip;

        $user->save();

        toastr()->success('Profile Updated', 'Update Successful');
        return redirect()->back();
    }

    public function testEmail(){
        $this->sendConfirmEmail('tobiy23@gmail.com', "5555");
    }



}
