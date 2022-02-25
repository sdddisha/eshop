<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use App\Models\Order;
use Exception;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Notification;
use PayPal\Api\Capture;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;


class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request,$total,$data)
    {
       // dd($data);
      // dd($request);
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
        $redirect_urls->setReturnUrl(URL::to('status',['data'=>$data,'total'=>$total])) /** Specify return URL **/
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
                return Redirect::to('/cart');

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/cart');

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
        return Redirect::to('/cart');

    }

    public function getPaymentStatus($data,$total)
    {
       // dd($data);
       $request=explode(",",$data);
       $fname=$request[1];
       $lname=$request[2];
       $address=$request[3]; 
       $city=$request[4];
       $country=$request[5];
       $zip=$request[6];
       $pnumber=$request[7];
       $payment_method=$request[9];
        $request=request();//try get from method
       // dd($data);
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        //dd($payment_id);
       
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        //if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        if (empty($request->PayerID) || empty($request->token)) {

            Session::put('error', 'Payment failed');
            return Redirect::to('/cart');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        //$execution->setPayerId(Input::get('PayerID'));
        $execution->setPayerId($request->PayerID);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
       //dd($result);
        $transactions = $result->transactions;
    // dd($transactions);
    $relatedResources = $transactions[0]->related_resources;
    $sale = $relatedResources[0]->sale;
    $id = $sale->id;   
   // dd($id);

        if ($result->getState() == 'approved') {
            
            Session::put('success', 'Payment success');
            //add update record for cart
            $order=new Order();
            $order->total=$total; 
            $order->fname=$fname;
            $order->lname=$lname;
            $order->address=$address;
            $order->city=$city;
            $order->country=$country;
            $order->zip=$zip;
            $order->pnumber=$pnumber;
           //$order->email=$request[8];
            $order->payment_method=$payment_method;  
            $order->transaction_id=$id;  
            $order->save();
            $request->session()->forget('cart');
            return redirect('/frontend1')->with('message','Order placed successfuly');  //back to product page
            //$request->session()->forget('cart');
        }

        Session::put('error', 'Payment failed');
        return Redirect::to('/'); 

    }
    public function refund(){
        return view('admin.refund.refund-form');
    }

    public function refund_payment(Request $request){

        $tid = $request->post('tid');
        $amount = $request->post('amount');
        $paymentValue=(string)round( $amount,2);
       // dd($paymentValue);
        $amount= new Amount();
        $amount->setCurrency('USD')
        ->setTotal($paymentValue);
        $refundRequest= new RefundRequest();
        $refundRequest->setAmount($amount);

        $sale= new Sale();
        $sale->setId($tid);
        try {
            $refundedSale= $sale->refundSale($refundRequest,$this->_api_context);

        }
        catch(Exception $e){
            return redirect('/refund')->with('message','!!Already Refunded!!');
        }
        //return 'refund';
        DB::table('orders')->where('transaction_id',$tid)->update(['refund_status'=>1]);
        return redirect('/refund')->with('message','Order Refunded');
        
    }
}