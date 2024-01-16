<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
     public function index(){
        // Get all Tags
        $tags = Tag::all();

        // Return the Tag View
        return view('admin.tags.all_tags', compact('tags'));
    }

    public function create(){
       //Return the Create Tag Form
       return view('admin.tags.new_tag');
    }

    public function store(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);

        $request->merge(['slug' => strtolower(str_replace("", "_",trim($request->name)))]);
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean'
        ]);

        // Create the Tag
        $new_tag = Tag::create($request->only('name','description','slug','status'));

        // Return view with Success report
        //toastr()->success('New Tag Saved');
        return redirect('/admin/tag/');
    }

    public function show($id){

    }

    public function edit($id){
        $tag= Tag::find($id);
        // Return the View
        return view('admin.tags.edit_tag', compact('tag'));
    }

    public function update(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);

        $request->merge(['slug' => strtolower(str_replace("", "_",trim($request->name)))]);
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean'
        ]);

        //Update the new category Details
        $update = Tag::where('id', $request->id)->update($request->only('name','description','slug','status'));

        //Redirect to all Tags
        return redirect('/admin/tag/');
    }

    public function delete($id){
        //Delete the Category
        Tag::destroy($id);

        // Redirect to Index
        return redirect('/admin/tag');
    }

    public function toggleActive(Request $request, $id){
        $request->validate([
            'status' => 'required|boolean'
        ]);
        // Deactivate the Tag
        $tag = Tag::find($id);
        $tag->status = $request->status;
        $tag->save();

        //Redirect to index
        return redirect('/admin/tag');
    }
}
