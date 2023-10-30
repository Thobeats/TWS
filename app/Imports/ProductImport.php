<?php

namespace App\Imports;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $categories = array_map(function($x){ return "'" .$x . "'"; },explode("|", $row['category']));
        $imploded_cat = implode(",", $categories);
        $cats = Category::whereRaw("LOWER(name) in ($imploded_cat)")->select('id')->get()->toArray();
        $category_id = array_map(function($c){ return  (string)$c; }, array_column($cats,'id') );
        $tags = array_map(function($x){ return "'" .$x . "'"; },explode("|", $row['tag']));
        $imploded_tag= implode(",",$tags);
        $tag = Tag::whereRaw("LOWER(name) in ($imploded_tag)")->select('id')->get()->toArray();
        $tag_id = array_map(function($c){ return (string)$c; }, array_column($tag,'id'));
        
        return new Product([
            'name' => $row['name'],
            'vendor_id' => auth()->user()->id,
            'price' => $row['price'],
            'category_id' => json_encode($category_id),
            'description' => $row['description'],
            'shipping_fee' => $row['shipping_fee'],
            'tags' => json_encode($tag_id),
            'sku' => $row['sku'],
            'moq' => $row['moq'],
            'publish_status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
