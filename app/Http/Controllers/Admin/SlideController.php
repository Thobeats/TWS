<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    public function index(){
        $slides = Slide::select("*")->get();
        return view('admin.slides.all_slides',compact('slides'));
    }

    public function create(){
        $tags = Tag::where('status', 1)->get()->toArray();
        return view('admin.slides.new_slide', compact('tags'));
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

        Slide::create($request->only('title','subtitle','image','tags','status','slug'));

        toastr()->success('slide created');
        return redirect('/admin/slide/');
    }

    public function edit($id){
        $slide = Slide::find($id);
        $tags = Tag::where('status', 1)->get()->toArray();

        return view('admin.slides.edit_slide',compact('slide','tags'));
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

         Slide::where('id', $request->id)->update($request->only('title','subtitle','image','tags','status','slug'));

         toastr()->success('slide updated');
         return redirect('/admin/slide/');
    }

    public function delete($id){

    }

    public function toggle(Request $request,$id){
        $request->validate([
            'status' => 'required|boolean'
        ]);
        
        // Deactivate the Slide
        $slide = Slide::find($id);
        $slide->status = $request->status;
        $slide->save();

        //Redirect to index
        return redirect('/admin/slide/');
    }
}
