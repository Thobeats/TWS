<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index(){
        $banners = Banner::select("*")->get();
        return view('admin.banners.all_banners',compact('banners'));
    }

    public function create(){
        $tags = Tag::where('status', 1)->get()->toArray();
        return view('admin.banners.new_banner', compact('tags'));
    }

    public function store(Request $request){
        if(!$request->has('status')){ $request->merge(['status' => 0]); }
        $request->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'image' => 'required|string',
            'tags' => 'required|array',
            'status' => 'required|boolean'
        ]);

        //Create A SLug
        $slug = "query=" . implode(",", $request->tags);
        $request->merge(['slug' => strtolower($slug)]);

        //Encode the Tags and Save the New Slide
        $request->merge(['tags' => json_encode($request->tags)]);

        Banner::create($request->only('title','subtitle','image','tags','status','slug'));

        toastr()->success('banner created');
        return redirect('/admin/banner/');
    }

    public function edit($id){
        $banner = Banner::find($id);
        $tags = Tag::where('status', 1)->get()->toArray();

        return view('admin.banners.edit_banner',compact('banner','tags'));
    }

    public function update(Request $request){
        if(!$request->has('status')){$request->merge(['status' => 0]); }
        $request->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'image' => 'required|string',
            'tags' => 'required|array',
            'status' => 'required|boolean'
        ]);

        //Update The Slide
         $slug = "query=" . implode(",", $request->tags);
         $request->merge(['slug' => strtolower($slug)]);

         //Encode the Tags and Save the New Slide
         $request->merge(['tags' => json_encode($request->tags)]);

         Banner::where('id', $request->id)->update($request->only('title','subtitle','image','tags','status','slug'));

         toastr()->success('banner updated');
         return redirect('/admin/banner/');
    }

    public function delete($id){

    }

    public function toggle(Request $request,$id){
        $request->validate([
            'status' => 'required|boolean'
        ]);

        // Deactivate the Slide
        $banner = Banner::find($id);
        $banner->status = $request->status;
        $banner->save();

        //Redirect to index
        return redirect('/admin/banner/');
    }
}
