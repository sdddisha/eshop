<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Aboutus;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Page;
use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    //
    public function index()
{
    $products = Product::all();
    $sub=Page::all();
    return view('frontend.index',compact('sub','products'));
}
    
public function submitcontactus(Request $request)
{
   
    Validator::make($request->all(), [
        'name' => 'required|min:3|max:35',
        'email' =>'required|min:3|max:35',
        'subject' =>'required|min:3|max:35',
        'msg'=> 'required|min:3',
    
    ])->validate();
    $dataArray      =       array(
        "name"         =>          $request->name,
        "email"        =>          $request->email,
        "subject"      =>          $request->subject,
        "msg"          =>          $request->msg,
        
        );
        
        
        $contact= Contact::create($dataArray);
      
        Toastr::success('Message sent successfully :)','Success');
        return back();
        
       
}
public function aboutus(){
    $sub=Page::all();
    $data=Aboutus::first();

    return view('frontend.aboutus',compact('sub','data'));
}
public function contactus(){
    $sub=Page::all();
    

    return view('frontend.contactus',compact('sub'));
}

}
