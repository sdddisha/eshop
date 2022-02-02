<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function show()

    {
        $category=Category::all();
        return view('admin.category.show',compact('category'));
    }

    public function add()
    {
        return view('admin.category.add');
    } 
    public function addsub(){
    
      $sub=Category::select("*")->where("parent_id", 0)->get();
    
        return view('admin.category.add-sub',compact('sub'));
    }

    public function insert(Request $request)
    {
        $category=new Category();
        $category->name=$request->input('name');
        $category->slug=$request->input('slug');
        $category->desc=$request->input('desc');    
        $category->save();
      return redirect('/dashboard');
    }
    public function insert_subcategory(Request $request)
    {
      
        $category=new Category();
        $category->name=$request->input('name');
        $category->parent_id=$request->input('parent_id');
        $category->slug=$request->input('slug');
        $category->desc=$request->input('desc');   
         $category->save();
      return redirect('/dashboard');
    }

    public function delete(Category $category ,$id){
  
      Category::destroy(array('id',$id));
        return view('admin.category.add');
    }
    }

