<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="{{asset('website/images/favicon.png')}}" type="">
      <title>Eshop </title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('website/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('website/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('website/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('website/css/responsive.css')}}" rel="stylesheet" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   </head>
   <body>

         <!-- header section strats -->
         <header class="header_section">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="index.html"><img width="250" src="{{asset('website/images/logo.png')}}" alt="#" /></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav">
                        @foreach($sub as $item)
                        <li class="nav-item active">
                           <a class="nav-link" href="{{$item->link}}">{{$item->name}}<span class="sr-only">(current)</span></a>
                        </li>
                        @endforeach
                           
            <div class="dropdown">
               <button type="button" class="btn btn-info" data-toggle="dropdown">
                   <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
               </button>
                        <div class="dropdown-menu">
                           <div class="row total-header-section">
                               <div class="col-lg-6 col-sm-6 col-6">
                                   <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                               </div>
                               @php $total = 0 @endphp
                               @foreach((array) session('cart') as $id => $details)
                                   @php $total += $details['price'] * $details['quantity'] @endphp
                               @endforeach
                               <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                   <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                               </div>
                           </div>
                           @if(session('cart'))
                               @foreach(session('cart') as $id => $details)
                                   <div class="row cart-detail">
                                       <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                           <p>{{ $details['name'] }}</p>
                                           <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                       </div>
                                   </div>
                               @endforeach
                           @endif
                           <div class="row">
                               <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                   <a href="{{ route('cart2') }}" class="btn btn-primary btn-block">View all</a>
                               </div>
                           </div>
                       </div>
                   </div>
                        <form class="form-inline">
                           <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                           <i class="fa fa-search" aria-hidden="true"></i>
                           </button>
                        </form>
                     </ul>
                  </div>
               </nav>
            </div>
         </header>

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
<form action="{{route('placeorder1',['id'=>$id,'total'=>$prodID,'ship'=>$ship])}}" method="POST">
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
                                    <input type="email" class="form-control" id="email" name="email" value="" >
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
                            <button type="submit" class="btn btn-success ">Place order</button>
                            {{-- <button type="button" class= "btn btn-success paypal">PayPal</button> --}}
                        </div>

                            <input type="hidden" name="amount" value="{{$prodID}}"> 
                            <input type="hidden" name="amount" value="{{$ship}}"> 
                            
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

 </section>

 <!-- footer start -->
 <footer>
    <div class="container">
       <div class="row">
          <div class="col-md-4">
              <div class="full">
                 <div class="logo_footer">
                   <a href="#"><img width="210" src="{{asset('website/images/logo.png')}}" alt="#" /></a>
                 </div>
                 <div class="information_f">
                   <p><strong>ADDRESS:</strong> 28 White tower, Street Name New York City, USA</p>
                   <p><strong>TELEPHONE:</strong> +91 987 654 3210</p>
                   <p><strong>EMAIL:</strong> yourmain@gmail.com</p>
                 </div>
              </div>
          </div>
          <div class="col-md-8">
             <div class="row">
             <div class="col-md-7">
                <div class="row">
                   <div class="col-md-6">
                <div class="widget_menu">
                   <h3>Menu</h3>
                   <ul>
                      <li><a href="#">Home</a></li>
                      <li><a href="#">About</a></li>
                      <li><a href="#">Services</a></li>
                      <li><a href="#">Testimonial</a></li>
                      <li><a href="#">Blog</a></li>
                      <li><a href="#">Contact</a></li>
                   </ul>
                </div>
             </div>
             <div class="col-md-6">
                <div class="widget_menu">
                   <h3>Account</h3>
                   <ul>
                      <li><a href="#">Account</a></li>
                      <li><a href="#">Checkout</a></li>
                      <li><a href="#">Login</a></li>
                      <li><a href="#">Register</a></li>
                      <li><a href="#">Shopping</a></li>
                      <li><a href="#">Widget</a></li>
                   </ul>
                </div>
             </div>
                </div>
             </div>     
             <div class="col-md-5">
                <div class="widget_menu">
                   <h3>Newsletter</h3>
                   <div class="information_f">
                     <p>Subscribe by our newsletter and get update protidin.</p>
                   </div>
                   <div class="form_sub">
                      <form>
                         <fieldset>
                            <div class="field">
                               <input type="email" placeholder="Enter Your Mail" name="email" />
                               <input type="submit" value="Subscribe" />
                            </div>
                         </fieldset>
                      </form>
                   </div>
                </div>
             </div>
             </div>
          </div>
       </div>
    </div>
 </footer>
 <!-- footer end -->
 <div class="cpy_">
    <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
    
       Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
    
    </p>
 </div>
 <!-- jQery -->
 <script src="{{asset('website/js/jquery-3.4.1.min.js')}}"></script>
 <!-- popper js -->
 <script src="{{asset('website/js/popper.min.js')}}"></script>
 <!-- bootstrap js -->
 <script src="{{asset('website/js/bootstrap.js')}}"></script>
 <!-- custom js -->
 <script src="{{asset('website/js/custom.js')}}"></script>    
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
      var a=2;
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
 {{-- <script>
  $(document).ready(function(){
    $('.paypal').click(function(){
       // console.log('Paypal');
      var fname= $('#fname_shipping').val();
      var lname=$('#lname_shipping').val();
      var address=$('#address_shipping').val();
      var city=$('#city_shipping').val();
      var country=$('#country_shipping').val();
      var zip=$('#zip_shipping').val();
      var pnumber=$('#pnumber_shipping').val();
      var email=$('#email_shipping').val();
      var data={
        'fname': fname,
       'lname':lname,
       'address':address,
       'city':city,
       'country':country,
       'zip':zip,
       'pnumber':pnumber,
       'email':email,

      }
       $.ajax({
           type:POST,
           url:"place-paypal",
           data:data,
           success: function (response){}

       })
      });
  });
</script>  --}}
<!-- Scripts -->
<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}" defer></script>    
</body>
</html>
