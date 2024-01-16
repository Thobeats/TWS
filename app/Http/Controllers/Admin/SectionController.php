<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SectionController extends Controller
{
    public function index(){
        //Return all Sections
        $sections =  Section::join('user_types', 'user_types.id' , '=', 'sections.for')
                                    ->select('sections.id','sections.name', 'sections.description','user_types.name as for', 'sections.status')
                                    ->get();



        //return the view
        return view('admin.sections.all_sections', compact('sections'));
    }

    public function create(){
        $user_types = UserType::where('id','!=',1)->get()->toArray();
       // $positions = Section::where('status', 1)->count(;)


        return view('admin.sections.new_section', compact('user_types'));
    }

    public function store(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);
        $request->validate([
            'name' => 'required|string|min:5',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'for' => 'required|integer',
            'position' => 'required|integer'
        ]);


        //Create a new Section
        $new_section = Section::create($request->only('name','description','status','for','position'));

        if($new_section->id){
            //toastr()->success("$request->name Created");
            return redirect('admin/section/');
        }

        //toastr()->error("Error: $request->name not created, Please try again");
        return redirect('admin/section/create');
    }

    public function edit($id){
        $section = Section::find($id);
        $user_types = UserType::where('id','!=',1)->get()->toArray();
        return view('admin.sections.edit_section', compact('user_types','section'));
    }

    public function update(Request $request){
        if(!$request->has('status'))$request->merge(['status' => 0]);
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|min:5',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'for' => 'required|integer',
            'position' => 'required|integer'
        ]);


        //Create a new Section
        $update_section = Section::where('id', $request->id)->update($request->only('name','description','status','for','position'));

        if($update_section){
            //toastr()->success("$request->name Updated");
            return redirect('admin/section/');
        }

        //toastr()->error("Error: $request->name not updated, Please try again");
        return redirect("admin/section/edit/$request->id");
    }

    public function toggleActive(Request $request, $id){
        $request->validate([
            'status' => 'required|boolean'
        ]);
        // Deactivate the Category
        $category = Section::find($id);
        $category->status = $request->status;
        $category->save();

        //Redirect to index
        return redirect('/admin/section');
    }
}
