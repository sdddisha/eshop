@extends('layouts.app')

@section('content')
<div class="container"> 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('placeorder',['id'=>$id,'total'=>$prodID,'ship'=>$ship    ])}}" method="POST">
 @csrf
<div class="row">
    <div class="col-md-6">
      <div class="card">
         <header class="card-header">
             <h4 class="card-title mt-2">Shipping Details</h4>
                            </header>
                            <article class="card-body">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" id="fname" name="fname">
                                    </div>
                                    <div class="col form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" id="lname" name="lname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city" name="city">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Country</label>
                                        <input type="text" class="form-control" id="country" name="country">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group  col-md-6">
                                        <label>Post Code</label>
                                        <input type="text" class="form-control" name="zip" id="zip">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" id="pnumber" name="pnumber">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" disabled>
                                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                              
                            </article>
                        </div>
                        <p><b>Billing Details  <label><input type="checkbox" value="" id="check-address">  Same as Shipping ?</label></b></p> 
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
         <header class="card-header">
             <h4 class="card-title mt-2">Billing Details</h4>
                            </header>
                            <article class="card-body">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" id="fname_shipping" name="fname">
                                    </div>
                                    <div class="col form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" id="lname_shipping" name="lname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" id="address_shipping" name="address">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city_shipping" name="city">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Country</label>
                                        <input type="text" class="form-control" id="country_shipping" name="country">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group  col-md-6">
                                        <label>Post Code</label>
                                        <input type="text" class="form-control" id="zip_shipping" name="zip" id="zip">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" id="pnumber_shipping" name="pnumber">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" id="email_shipping" name="email" value="" >
                                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                               
                            </article>
                        </div>
                    </div>
                </div>
     

<div class="row">
<div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <header class="card-header">
                                        <h4 class="card-title mt-2">Your Order</h4>
                                    </header>
                                    <article class="card-body">
                                        <dl class="dlist-align">
                                            <dt id="total">Total cost:Rs {{$prodID}}</dt>
                                            {{-- <dt>Coupon Codes
                                                <select class="form-control">
                                                    <option value=""> -- Choose from below coupons --</option>
                                                @foreach ($coupon as $item)
                                                    <option value="{{$item->value}}">{{$item->code}}</option>
                                                @endforeach
                                            </select>
                                            <input type="button" name="coupon" id="coupon" value="Apply Coupon" onclick="">
                                            </dt> --}}
                                            <dt id="ship">Shipping cost:Rs </dt>
                                            <dt id="totalcost">Total cost:Rs </dt>
                                        </dl>
                                    </article>
                                </div>
                            </div>
                 
                            <div class="col-md-12 mt-4">
                            
                      <input type="radio"  name="payment_method" value="COD"/><label>Pay on Delivery</label>
                            
                            <input type="radio"  name="payment_method" value="paypal"/><label>Pay using PayPal</label>
                           
                            </div>
                            <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-success">Place Your Order</button>
                            <input type="hidden" name="amount" value="{{$prodID}}"> 
                            <input type="hidden" name="amount" value="{{$ship}}"> 
                            </div>

                            @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message')}}
    </div>
@endif
                        </div>
                    </div>
</div>
</div>
</form>
<div class="container">
    {{-- <form method="post" action="{!! URL::to('paypal') !!}" >
    @csrf
    <input type="hidden" name="amount" value="{{$prodID}}"> 
    <input type="submit" name="paynow" value="Pay with PayPal">                   
    </form><div> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

// $(document).ready(function(){
//     $('select').click(function(){
//         var coupon= $(this).val(); 
//         console.log(coupon);
//     });

// });
var t={{$prodID}};
  if(t< 50000){
      var a=200;
      var total=t+a;
    }
    else{  
        var a=500;
        var total=t+a;
    }
    
    
$(document).ready(function(){
  
    $("#ship").hide();
    $("#total").hide();
    $('#lname').click(function(){
        $("#total").show();
    });
    $('#pnumber').click(function(){
    
    $("#ship").show().append(a);
    $("#totalcost").show().append(total);
  });

  $('#check-address').click(function(){ 
     if ($('#check-address').is(":checked")) {
      $('#fname_shipping').val($('#fname').val());
      $('#lname_shipping').val($('#lname').val());
      $('#address_shipping').val($('#address').val());
      $('#city_shipping').val($('#city').val());
      $('#country_shipping').val($('#country').val());
      $('#zip_shipping').val($('#zip').val());
      $('#pnumber_shipping').val($('#pnumber').val());
      $('#email_shipping').val($('#email').val());
     } else { 
         //Clear on uncheck
      $('#fname_shipping').val("");
      $('#lname_shipping').val("");
      $('#address_shipping').val("");
      $('#city_shipping').val("");
      $('#country_shipping').val("");
      $('#zip_shipping').val("");
      $('#pnumber_shipping').val("");
      $('#email_shipping').val("");
     };
    });
});


</script>
@endsection

