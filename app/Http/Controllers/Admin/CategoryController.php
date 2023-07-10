<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryFormRequest;


class CategoryController extends Controller
{
    //
    public function index(){
        $category = Category::all();
        return view('admin.category.index',compact('category'));
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(CategoryFormRequest $request)
    {
       $data = $request->validated();
        $category = new Category;
        $category->name= $data['name'];
        $category->slug= $data['slug'];
        $category->description= $data['description'];

        if($request->hasfile('image')){
            $file = $request->file('image');
            $filename = time().'.' .$file ->getClientOriginalExtension();
            $file->move('uploads/category',$filename);
            $category->image= $filename;
        }
        $category->meta_title= $data['meta_title'];
        $category->meta_description= $data['meta_description'];
        $category->meta_keyword = $data['meta_keyword'];
        $category->navbar_status =  $request->navbar_status == true ? '1':'0';
        $category->status= $request->status == true ? '1':'0';
        $category->created_by = Auth::user()->id;
        $category->save();
        return redirect('admin/category')->with('message','Category added successfully');
    }
    public function edit($category_id)
    {
     //echo 'here'; die;
     $category = Category::find($category_id);
    // dd($category);
     return view('admin.category.edit',compact(['category']));
    }
    

}
