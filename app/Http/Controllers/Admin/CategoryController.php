<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ParentToChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        // Get all the Categories
        $categories = Category::all();

        // Return the Category View
        return view('admin.categories.all_categories', compact('categories'));
    }

    public function create(){
        $parent = Category::where('status', 1)->select('id', 'name')->get();

       //Return the Create Category Form
       return view('admin.categories.new_category', compact('parent'));
    }

    public function store(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);
        $request->validate([
            'name' => 'required|string',
            'parent_id' => 'required|numeric',
            'description' => 'required|string',
            'status' => 'required|boolean'
        ]);

        // Create the Category
        $new_category = Category::create($request->only('name','description','status'));

        //Create Parent to CHild relationship
        ParentToChild::create(['parent_id' => $request->parent_id, 'category_id' => $new_category->id]);

        // Return view with Success report
        toastr()->success('New Category Saved');
        return redirect('/admin/categories');
    }

    public function show($id){

    }

    public function edit($id){
        $category = Category::find($id);
        $parent = Category::where(['status'=> 1])->where('id',"!=","$id")->select('id', 'name')->get();

        // Return the View
        return view('admin.categories.edit_category', compact('category','parent'));
    }

    public function update(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'parent_id' => 'required',
            'description' => 'required|string',
            'status' => 'required|boolean'
        ]);

        //Update the new category Details
        $update = Category::where('id', $request->id)->update($request->only('name','description','status'));

        //Create Parent to CHild relationship
        ParentToChild::where('category_id', $request->id)->update(['parent_id' => $request->parent_id]);

        //Redirect
        return redirect('/admin/categories/');
    }

    public function delete($id){
        //Delete the Category
        Category::destroy($id);

        // Redirect to Index
        return redirect('/admin/categories');
    }

    public function toggleActive(Request $request, $id){
        $request->validate([
            'status' => 'required|boolean'
        ]);
        // Deactivate the Category
        $category = Category::find($id);
        $category->status = $request->status;
        $category->save();

        //Redirect to index
        return redirect('/admin/categories');
    }
}
