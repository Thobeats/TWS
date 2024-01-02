<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Color;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_id',
        'category_id',
        'section_id',
        'tags',
        'price',
        'pics',
        'description',
        'shipping_fee',
        'publish_status',
        'discount_price',
        'sku',
        'moq',
        'item_listing',
        'created_at',
        'updated_at'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        $categories = Category::whereIn('id',json_decode($this->category_id,true))->select('id','name')->get();
        return $categories;
    }

    public function images(){
        $images = json_decode($this->pics,true);
        $imgs =[];

        foreach($images as $image){
            $imgs[] = url('storage/products/'. $image);
        }

        return $imgs;
    }

    // public function sizes(){
    //     $sizes = Size::whereIn('id', json_decode($this->sizes,true))->select('id','size_code as name')->get();
    //     $option = '<option>Choose Size</option>';

    //     foreach($sizes as $size){
    //         $option .= "<option value='$size->id'>$size->name</option>";
    //     }

    //     return $option;
    // }

    // public function colors(){
    //     $colors = Color::whereIn('id', json_decode($this->colors,true))->select('id','name')->get();
    //     $option = '<option>Choose Color</option>';
    //     foreach($colors as $color){
    //         $option .= "<option value='$color->id'>$color->name</option>";
    //     }

    //     return $option;
    // }

    public function item_listing(){
        return json_decode($this->item_listing);
    }

    public function vendor(){
        $vendor = User::find($this->vendor_id);
        return collect(['id'=>$this->vendor_id, 'name' => $vendor->business_name]);
    }

    public function otherVendorProducts(){
        $products = Product::where(['vendor_id' => $this->vendor_id, 'publish_status' => 1])->whereNot('id', $this->id)->limit(10)->get();
        return $products;
    }

    public function otherProducts(){
        $products = Product::where('publish_status', 1)->whereJsonContains('category_id', json_decode($this->category_id,true))->whereNot('id', $this->id)->limit(10)->get();
        return $products;
    }

    public function inWishList(){
        $user = Auth::user();
        //User WishList
        $wishlist = Wishlist::where(['user_id' => $user->id, 'product_id' => $this->id])->first();

        if($wishlist){
           return true;
        }

        return false;
    }

    public function vendorName(){
        $vendorName = User::find($this->vendor_id);

        return $vendorName->business_name;
    }

    public function quantityAvailable($color, $size){
        $item_listing = json_decode($this->item_listing, true);

        $colorRecord = $item_listing[$color];
        $sizeIndex = array_search($size, $colorRecord[0]);
        $num_in_stock = $colorRecord[1][$sizeIndex];

        return $num_in_stock;
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class,'product_id', 'id')
                    ->join('users', 'users.id', '=', 'product_reviews.from')
                    ->get();
    }



}
