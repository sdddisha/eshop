<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Aboutus;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Page;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
class WebsiteController extends Controller
{
    //
    public function index()
{
    $products = Product::all();
    $sub=Page::all();
    return view('frontend.index',compact('sub','products'));
}
public function buyNow($id)
{
    $product = Product::findOrFail($id);
      
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->pname,
            "quantity" => 1,
            "price" => $product->price,
           // "image" => $product->file_path
            "image" => '/storage/product/'.$product->file_path
        ];
    }
      
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart successfully!');
}
public function cart()
{   
    $sub=Page::all();
    return view('cart2',compact('sub'));
}
public function update(Request $request)
{
    if($request->id && $request->quantity){
        $cart = session()->get('cart');
        $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
        session()->flash('success', 'Cart updated successfully');
    }
}
public function remove(Request $request)
{
    if($request->id) {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        session()->flash('success', 'Product removed successfully');
    }
}
public function perform(Request $request)
    {
        $request->session()->forget('cart');
       
       Session::flush(); //both code works
       $request->session()->forget('cart');
        return redirect('/frontend1');
    }

public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
       
    }

    
    public function handleGoogleCallback()
    {
        try {
            
            $user = Socialite::driver('google')->stateless()->user();
//dd($user);
            $finduser = User::where('google_id', $user->id)->first();
       
            if($finduser){
       
                Auth::login($finduser);
                
                $data1=Auth::user();
                $data=$data1['email'];
                return redirect()->intended('home');
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
      
                Auth::login($newUser);
              
                return redirect()->intended('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    function checkout($total){
        $sub=Page::all();
        $coupon=Coupon::all();
            $id= rand(2,50);
            $prodID=base64_decode($total);
            $ship=0;
          return view('checkout1',compact('prodID','id','ship','coupon','sub'));
            }

            function storeCheckoutDetails(Request $request,$id,$total,$ship){
               // dd($request->all());
                $pay=  $request['payment_method'];
               // dd($pay);
                if ($pay=='paypal')
                {

                    if($total<50000){
                        $ship=2;
                        $total1=$total+$ship;
                    }
                    else{
                        $ship=500;
                        $total1=$total+$ship;
                    }
                 
                   $string=$request->all();
                   //dd($data);
                   $data=implode(",",$string);
                    return view(('paypal'),compact('total1','data'));
                   
                //     $request=$request->all();
                //     //return $this->sendRequest($uri);
                //    return $this->payWithpaypal($request);
                }
                else{
                   
            Validator::make($request->all(), [
                'fname' => 'required|min:3|max:35',
                'lname' =>'required|min:3|max:35',
                'address' =>'required',
                'zip'=> 'required|max:6',
                'email'=>'required|email',
                'pnumber'=>'required|max:10',
                'payment_method' => 'required',
            ])->validate();

                if($total<50000){
                    $ship=2;
                }
                else{
                    $ship=500;
                }

                $order=new Order();
                $order->user_id=$id; 
                $order->total=$total+$ship; 
                $order->fname=$request->input('fname');
                $order->lname=$request->input('lname');
                $order->address=$request->input('address');   
                $order->pnumber=$request->input('pnumber'); 
                $order->city=$request->input('city');  
                $order->country=$request->input('country');  
                $order->zip=$request->input('zip');   
                $order->payment_method=$request->input('payment_method');  
                $order->save();
                return redirect('/frontend1')->with('message','Order placed successfuly');
                $request->session()->forget('cart');
            }
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
