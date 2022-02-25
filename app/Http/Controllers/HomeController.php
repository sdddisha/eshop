<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Page;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


/** All Paypal Details class **/
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;

use URL;
use Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



//ajax

public function index()
{ $sub=Page::all();
    $products = Product::all();
    return view('products',compact('sub','products'));
}

/**
 * Write code on Method
 *
 * @return response()
 */
public function cart()
{
    $sub=Page::all();
    return view('cart1',compact('sub'));;
}

/**
 * Write code on Method
 *
 * @return response()
 */
public function addToCart($id)
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

/**
 * Write code on Method
 *
 * @return response()
 */
public function update(Request $request)
{
    if($request->id && $request->quantity){
        $cart = session()->get('cart');
        $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
        session()->flash('success', 'Cart updated successfully');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
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
        return redirect('/');
    }
    
    function checkout($total){
        $sub=Page::all();
        $coupon=Coupon::all();
            $id=Auth::id();
            $prodID=base64_decode($total);
            $ship=0;
          return view('checkout',compact('prodID','id','ship','sub','coupon'));
            }

            function storeCheckoutDetails(Request $request,$id,$total,$ship){
                
                $pay=  $request['payment_method'];
               // dd('gg');
                if ($pay=='paypal')
                {
                   // dd('gg');
                    if($total<50000){
                        $ship=2;
                        $total1=$total+$ship;
                    }
                    else{
                        $ship=500;
                        $total1=$total+$ship;
                    }
                   
                    $string=$request->all();
                    $data=implode(",",$string);
                    return view(('paypal'),compact('total1','data'));
                   
                }
                    else{
                       //dd('else');
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
                    $ship=200;
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
                $request->session()->forget('cart');
                return redirect('/home')->with('message','Order placed successfuly');
               // $request->session()->forget('cart');
            }   
        }
            

           public function payWithpaypal(Request $request,$total)
            {
              
                if($request['amount']<50000){
                    $shipping_cost=200;
                    $request['amount']=$request['amount']+$shipping_cost;
        
                }
                else{
                    $shipping_cost=500;
                    $request['amount']=$request['amount']+$shipping_cost;
                }
              
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
    
                $item_1 = new Item();
    
                $item_1->setName('Item 1') /** item name **/
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($total); /** unit price **/
    
                $item_list = new ItemList();
                $item_list->setItems(array($item_1));
    
                $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($total);
    
                $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');
    
                $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
                    ->setCancelUrl(URL::to('status'));
    
                $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/
                try {
    
                    $payment->create($this->_api_context);
    
                } catch (\PayPal\Exception\PPConnectionException $ex) {
    
                    if (\Config::get('app.debug')) {
    
                        \Session::put('error', 'Connection timeout');
                        return Redirect::to('/');
    
                    } else {
    
                        \Session::put('error', 'Some error occur, sorry for inconvenient');
                        return Redirect::to('/');
    
                    }
    
                }
    
                foreach ($payment->getLinks() as $link) {
    
                    if ($link->getRel() == 'approval_url') {
    
                        $redirect_url = $link->getHref();
                        break;
    
                    }
    
                }
    
                /** add payment ID to session **/
                Session::put('paypal_payment_id', $payment->getId());
    
                if (isset($redirect_url)) {
    
                    /** redirect to paypal **/
                    return Redirect::away($redirect_url);
    
                }
    
                Session::put('error', 'Unknown error occurred');
                return Redirect::to('/');
    
            }
    
            public function getPaymentStatus()
            {
                
                $request=request();//try get from method
    
                /** Get the payment ID before session clear **/
                $payment_id = Session::get('paypal_payment_id');
    
                /** clear the session payment ID **/
                Session::forget('paypal_payment_id');
                //if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
                if (empty($request->PayerID) || empty($request->token)) {
    
                    Session::put('error', 'Payment failed');
                    return Redirect::to('/home');
    
                }
    
                $payment = Payment::get($payment_id, $this->_api_context);
                $execution = new PaymentExecution();
                //$execution->setPayerId(Input::get('PayerID'));
                $execution->setPayerId($request->PayerID);
    
                /**Execute the payment **/
                $result = $payment->execute($execution, $this->_api_context);
    
                if ($result->getState() == 'approved') {
    
                    Session::put('success', 'Payment success');
                    //add update record for cart
                    return redirect('/home')->with('message','Order placed successfuly') ;//back to product page
    
                }
    
                Session::put('error', 'Payment failed');
                return Redirect::to('/'); 
            
            }
     
}

