<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Http\Request;

class VendorsPage extends Component
{
    public $tr;
    public $vendors;
    public $title;
    public $categories;
    public $categoryQuery = [];
    // public $featureQuery = [];
    public $cat;
    public $feature = [];

    public function mount(){
        $this->generateTable();
        $this->getCategories();
        $this->vendors();
    }

    public function generateTable(){
        $alpha = range('A', 'Z');
        $index = 1;
        $tr = "<tr>";

        foreach($alpha as $alp){
            $tr .= "<td align='center' wire:click=filterVendor('$alp')><b>$alp</td>";

            if($index % 4 == 0){
                $tr .= "</tr><tr>";
            }

            $index++;
        }

        $tr .= "<td align='center' colspan='2' wire:click=filterVendor('#')>0-9</td></tr>";

        $this->tr = $tr;
    }

    public function filterVendor(Request $request,$alphabet){

        if($alphabet == "#"){
            $filterVendors = Vendor::where('users.account_status', 1)
                                ->where('users.business_name','LIKE',"[0-9]%")
                                ->join('users','users.id','=','vendors.user_id')
                                ->get();
        }else{
            $filterVendors = Vendor::where('users.account_status', 1)
                            ->where('users.business_name','LIKE',"$alphabet%")
                            ->join('users','users.id','=','vendors.user_id')
                            ->get();
        }

        $this->title = $alphabet;

        $this->vendors = $filterVendors->count() < 1 ? [] : $filterVendors;
    }


    public function getCategories(){
        $this->categories = Category::where('parent_to_children.parent_id', 0)
                                    ->join('parent_to_children','parent_to_children.category_id','=','categories.id')
                                    ->get();
    }

    public function vendorsByCategories($category_id){

        if(in_array($category_id,$this->categoryQuery)){
            unset($this->categoryQuery[array_search($category_id,$this->categoryQuery)]);
            array_values($this->categoryQuery);
        }else{
            array_push($this->categoryQuery,$category_id);
        }

        $this->vendors();
    }

    public function vendorsByFeature($feature){
        if(array_key_exists($feature,$this->featureQuery) && $this->featureQuery[$feature] == 1){
           $this->featureQuery[$feature] = 0;
        }else{
            $this->featureQuery[$feature] = 1;
        }
        $this->vendors();
    }



    public function vendors(){

        $this->title = "All Vendors";

        $query = Vendor::where('users.account_status', 1);

        // Category
        if(count($this->categoryQuery) > 0){
            $queryOptions = $this->categoryQuery;
            $query->where(function(Builder $query)use($queryOptions){
                foreach($queryOptions as $option){
                    $query->orWhereJsonContains('vendors.products',$option);
                }
            });
        }

        $this->vendors = $query->join('users','users.id','=','vendors.user_id')
                        ->leftJoin('orders','orders.vendor_id','=','vendors.user_id')
                        ->selectRaw("count(orders.vendor_id) as cnt, users.business_name, users.profile, users.id")
                        ->groupBy('users.id')
                        ->orderBy('cnt', 'DESC')
                        ->get();
    }



    public function render()
    {
        return view('livewire.vendors-page');
    }
}
