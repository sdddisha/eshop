<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function show()
    {
        $product=Product::all();
        return view('admin.product.show',compact('product'));
    }    
    public function add()
    {
        $category=Category::select("*")->where("parent_id", 0) ->get();
        
        return view('admin.product.add',compact('category'));
    }

    public function insert(Request $request)
    { 
      $request->validate([
        'pname' => 'required',
        'price' => 'required',
        'desc' => 'required',
    ]);

    // ensure the request has a file before we attempt anything else.
    if ($request->hasFile('file')) {

        $request->validate([
            'image' => 'mimes:jpeg,bmp,png,jpg' // Only allow .jpg, .bmp and .png file types.
        ]);

        // Save the file locally in the storage/public/ folder under a new folder named /product
        $request->file->store('product', 'public');

        // Store the record, using the new file hashname which will be it's new filename identity.
        $product = new Product([
            "pname" => $request->get('pname'),
            "price" => $request->get('price'),
            "cat_id" => $request->get('cat_id'),
            "sub_cat" => $request->get('sub_cat'),
            "desc" => $request->get('desc'),
            "file_path" => $request->file->hashName()
        ]);
        $product->save(); // Finally, save the record.
    }

    return back();

}
    
    public function delete(Product $product,$id){
  
      Product::destroy(array('id',$id));
        return redirect('product.add');
    }
    public function subcat(Request $request){
   
  
      $parent_id = $request->cat_id;
         
      $subcat = Category::where('parent_id',$parent_id)->get();
      return response()->json([ 
          'subcat'=> $subcat
      ]);
    }

    
}
