<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class Product extends Component
{

    public $productName;
    public $wishlist;
    public $productVariants;
    public $productId;
    public $selectedVariantValues;
    public $variantValues;
    public $itemCount;
    public $price;
    public $in_stock;
    public $limit;
    public $productCount;
    public $shippingFee;
    public $vendorId;
    public $success;
    public $inWishList;

    public function mount(){
        $productVariant = ProductVariant::where('product_id', $this->productId)->first();
        if ($productVariant){
            $this->getVariantValues($productVariant);
        }

        // if ($productVariant){
        //     $this->productVariants = collect(json_decode($productVariant->variant, true));
        // }else{
        //     $this->productVariants = collect([]);
        // }

        $this->processVariant();
        $this->loadProduct();
        $this->loadSuccess();
        $this->loadWishlist();
    }

    public function processVariant(){
        if (!$this->productVariants->isEmpty()){
            foreach($this->productVariants as $key => $vrnt){
                $variantArray = [];
                $variantArray['variant'] = $vrnt['variant'];
                $variantArray['values'] = explode(",",$vrnt['value']);
                $this->selectVariantValues($key, $variantArray['values'][0]);
                $this->productVariants->put($key, $variantArray);
            }
        }else{
            $this->selectVariantValues = [];
        }
    }

    public function selectVariantValues($index, $value){
        $this->selectedVariantValues[$index] = $value;
    }

    public function getVariantValues($productVariants){
        $variantValues = json_decode($productVariants->variant_to_values, true);
        foreach ($variantValues as $key => $value) {
            $this->variantValues[$value["'listing_name'"]] = [
                'price' => $value["'listing_price'"],
                'in_stock' => $value["'listing_no_in_stock'"],
                'limit' => $value["'listing_purchase_limit'"]
            ];
        }
    }

    public function chooseVariants($index, $value){
        $this->selectedVariantValues[$index] = $value;
        $this->loadProduct();
    }

    public function loadProduct(){
        if ($this->selectedVariantValues != null){
            $pointer = join(" / ", $this->selectedVariantValues);
            $selected = $this->variantValues[$pointer];
            $this->price = $selected['price'];
            $this->in_stock = $selected['in_stock'];
            $this->limit = $selected['limit'];
            $this->productCount = 1;
        }
        else{
            $this->productCount = 1;
        }

    }

    public function loadSuccess($message=""){
        if ($message != ""){
            $this->success = $message;
        }
        else
        {
            $this->success = "";
        }
    }

    public function increment(){
        if ($this->productCount < $this->limit){
            $this->productCount++;
        }
    }

    public function decrement(){
        if ($this->productCount > 0){
            $this->productCount--;
        }
    }

    public function loadWishlist(){
        $check = Wishlist::where(['product_id' => $this->productId, "user_id" => Auth::id()])->first();

        if ($check){
            $this->inWishList = false;
        }else{
            $this->inWishList = true;
        }
    }

    public function addToWishList(){

        $check = Wishlist::where(['product_id' => $this->productId, "user_id" => Auth::id()])->first();

        if ($check){
            $check->delete();
            $this->inWishList = false;
        }
        else
        {
            $wishlist = Wishlist::create([
                "user_id" => Auth::id(),
                "wish_category_id" => 0,
                "product_id" => $this->productId
            ]);
            $this->inWishList = true;
        }

        $this->emit('checkWishList');

    }

    public function addToCart(Request $request){
        $user = Auth::user();

        $variants = $this->selectedVariantValues != null ? join(" / ", $this->selectedVariantValues) : "";
        // Check if the the product, color and size has been added already
        $check = Cart::where(['product_id' => $this->productId,'user_id' => $user->id, 'variants' => $variants])->first();

        if ($check){
            $check->quantity += $this->productCount;
            $check->price = $check->quantity *  $this->price;
            $check->save();
        }else{
            $cart = new Cart;
            $cart->user_id = $user->id;
            $cart->vendor_id = $this->vendorId;
            $cart->product_id = $this->productId;
            $cart->quantity = $this->productCount;
            $cart->price = $this->productCount *  $this->price;
            $cart->shipping_fee = $this->shippingFee;
            $cart->variants = $variants;
            $cart->save();
        }
        $this->success = "Saved to Cart";

        $this->emit('checkCart');
    }

    public function render()
    {
        return view('livewire.product');
    }
}
