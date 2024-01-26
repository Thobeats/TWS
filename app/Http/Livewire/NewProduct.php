<?php

namespace App\Http\Livewire;

use Exception;
use Validator;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\ProductVariant;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NewProduct extends Component
{
    use WithFileUploads;

    public $session;
    public $pictures;
    public $uploadedPictures = [];
    public $sessionId;
    public $page = "new_product";
    public $hasVariant = true;
    public $product = [
        "productName" => "",
        "category" => "",
        "tags" => [],
        "product_sku" => "",
        "section" => "",
        "shipping_fee" => "",
        "moq" => "",
        "description" => "",
        "pics" => "",
    ];

    public $myErrorBag = [];

    public $variants = [
        [
            'images' => 0,
            'no_in_stock' => 0,
            'price' => 0,
            'purchase_limit' => 0,
            'imagesCount' => 0,
            'upload' =>  ''
        ]
    ];
    public $tags;
    public $sections;
    public $shipping;
    public $categoryTemp;
    public $price;
    public $tableTemplate;


    protected $rules = [
        "pictures" => "image|mimes:jpg,png|max:2000",
        "variants.*.images" => "image|mimes:jpg,png|max:2000",
    ];

    protected $priceRules = [
        "price" => "required|integer",
    ];

    protected $productRules = [
        'product.productName' => 'required|string',
        'product.category' => 'required|array',
        'product.tags' => 'required|array',
        'product.shipping_fee' => 'integer',
        'product.section' => 'required|array',
        'product.sku' => 'nullable|string',
        'product.moq' => 'required|integer',
        'product.description' => 'required|string',
    ];

    protected $messages = [
        "pictures.image" => "It should be an image",
        "pictures.max" => "Mmaximum image size is 2MB",
        "pictures.mimes" => "Allowed format is jpg or png"
    ];

    protected $priceMessage = [
       "price.required" => "please enter the price",
       "price.integer" => "Price must be a valid number"
    ];
    protected $listeners = ["selectedCategory", "selectedTags", "selectedSections","saveDescription", "processVariantTable"];

    public function switchPage($page=""){
        if ($page == "") {
            $this->page = "new_product";
        }else{
            $this->page = $page;
        }
    }

    public function selectedCategory($value){
        $this->product['category'] = $value;
    }

    public function selectedTags($value){
        $this->product['tags'] = $value;
    }

    public function selectedSections($value){
        $this->product['section'] = $value;
    }

    public function saveDescription($value){
        $this->product['description'] = $value;
    }

    public function updated($propertyName){
        try{
            if ($propertyName == 'pictures')
            {
                $validator = Validator::make([
                    $propertyName => $this->$propertyName,
                ],$this->rules, $this->messages);

                $validator->validate();
                $this->myErrorBag = [];
                if (count( $this->uploadedPictures) >= 3){
                    $newError = new MessageBag;
                    $newError->add('pictures', 'You have reached the max amount of picture to upload');
                    $this->myErrorBag = $newError->toArray();
                }else{
                    $file_name = $this->pictures->getClientOriginalName();
                    if (in_array('/products/'. $file_name, $this->uploadedPictures)){
                        $newError = new MessageBag;
                        $newError->add('pictures', 'You have uploaded this picture already');
                        $this->myErrorBag = $newError->toArray();
                    }else{
                        $this->pictures->storeAs('public/products', $file_name);
                        $this->uploadedPictures[] = '/products/'. $file_name;
                    }

                }
            }
            elseif($propertyName == 'price'){
                $validator = Validator::make([
                    $propertyName => $this->$propertyName,
                ],$this->priceRules, $this->priceMessage);

                $validator->validate();
                $this->myErrorBag = [];
            }

            // elseif()
            // {
            //     $validator = Validator::make([
            //         'product' => $this->product,
            //     ],$this->productRules);

            //     $validator->validate();
            //     $this->myErrorBag = [];
            // }



        }catch(ValidationException $ve){
            $errors = $ve->validator->errors();

            // Assign the validation errors to the $myErrorBag property
            $this->myErrorBag = $errors->messages();

        }catch(Exception $e){

        }

    }

    public function removeImg($id){
        if (isset($this->uploadedPictures[$id])){
            Storage::delete("public". $this->uploadedPictures[$id]);
            unset($this->uploadedPictures[$id]);
            $this->uploadedPictures = array_values($this->uploadedPictures);
        }
    }


    public function publishProduct()
    {
        dd($this->product);
    }

    public function saveToDraft()
    {

    }

    public function processVariantTable($array)
    {
        $user = Auth::user();
        if ($array != [])
        {
            $keys = $array[0];
            $values = $array[1];
            $results = $array[2];
            $map = [];

            info("results:" .json_encode($results));

            foreach ($keys as $index => $key){
                $map[] = [
                    'variant' => $key,
                    'value' => implode(",",$values[$index])
                ];
            }

            // Save the Map and Session in the Database then generate the Table
            $newVariant  = ProductVariant::updateOrCreate(['vendor_id' => $user->id, 'sessionId'=>$this->sessionId, 'session_status' => 0],
                                ['variant' => json_encode($map)]);
            $this->tableTemplate = $results;
        }
    }




    public function switchVariant()
    {
        if ($this->hasVariant == true){
            $this->hasVariant = false;
            $this->emit('loadJquery');
        }else{
            $this->hasVariant = true;
        }
    }




    public function render()
    {
        $this->dispatchBrowserEvent('jquery');
        return view('livewire.new-product');
    }
}
