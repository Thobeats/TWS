<?php

namespace App\Models;

use App\Traits\AppTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilePond extends Model
{
    use HasFactory, AppTrait;


    public function saveImage(Request $request,$folder){
        if($request->hasFile('pics')){
            $images = $request->file('pics');
            foreach($images as $image){
               $file_name = $image->getClientOriginalName();
               $directory = "public/$folder/". $file_name;

               if(!file_exists($directory)){
                    $image->storeAs($folder,$file_name,"public");
               }

               return $file_name;

            }
        }


        //Upload Single Pics
        if($request->hasFile('pic')){
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $directory = "public/$folder/". $file_name;

            if(!file_exists($directory)){
                 $image->storeAs($folder,$file_name,"public");
            }

            return $file_name;
        }
    }

    public function saveSlide(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $directory = "public/slides/". $image_name;

            if(!file_exists($directory)){
                $image->storeAs('slides',$image_name,"public");
            }

            return $image_name;
        }
    }

    public function saveDoc(Request $request,$folder){
        if($request->hasFile('pics')){
            $images = $request->file('pics');
            foreach($images as $image){
               $file_name = $image->getClientOriginalName();
               $directory = "public/$folder/". $file_name;

               if(!file_exists($directory)){
                    $image->storeAs("$folder",$file_name,"public");
               }

               return $file_name;

            }

        }
    }

    public function deleteImage(Request $request, $folder){
        // $file = ImageUpload::where('image_uniqID',request()->getContent())->first();
        // if($file){
        //     Storage::deleteDirectory('products/tmp/'.$file->image_uniqID);
        //     $file->delete();
        //     return response('');
        // }

        $file = $request->filName;
        $directory = storage_path("app/public/$folder/". $file);

        if(file_exists($directory)){
            Storage::delete("public/$folder/".$file);
            return "Image Removed";
        }

    }

    public function loadImage(Request $request){
        return asset('storage/products/'. $request->load);
    }
}
