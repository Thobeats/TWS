<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'for',
        'position',
        'created_at',
        'updated_at'
    ];


    public function products(){
        $products = Product::whereRaw("section_id LIKE '%". "$this->id" . "%'")
                            ->where('publish_status', 1)
                            ->get();

        return $products;
    }

    public function adminSectionProducts(){
        if($this->id == 1){
            $new_arrivals = Product::where('publish_status', 1)
            ->orderBy('id','DESC')
            ->limit(10)
            ->get();

            return $new_arrivals;
        }

        if($this->id == 2){
            $top_vendors = Sales::where('sale_status', 1)
                                 ->selectRaw('vendor_id, count(vendor_id) as cnt')
                                 ->groupBy('vendor_id')
                                 ->orderBy('cnt', 'DESC')
                                 ->get();

            return $top_vendors;
        }
    }
}
