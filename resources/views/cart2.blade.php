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
  
            @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div> 
            @endif
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:50%">Product</th>
                        <th style="width:10%">Price</th>
                        <th style="width:8%">Quantity</th>
                        <th style="width:22%" class="text-center">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr data-id="{{ $id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $details['name'] }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">${{ $details['price'] }}</td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                                </td>
                                <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                                <td class="actions" data-th="">
                                    <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                            <?php
                                      $str = $total;
                                      $prodID= base64_encode($str);
                                      ?>
            
                            <a href= "{{url('checkout1',$prodID)}}" class="btn btn-success">Checkout as Guest</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
         
        </div>
           <!-- subscribe section -->
      <section class="subscribe_section">
        <div class="container-fuild">
           <div class="box">
              <div class="row">
                 <div class="col-md-6 offset-md-3">
                    <div class="subscribe_form ">
                       <div class="heading_container heading_center">
                          <h3>Subscribe To Get Discount Offers</h3>
                       </div>
                       <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                       <form action="">
                          <input type="email" placeholder="Enter your email">
                          <button>
                          subscribe
                          </button>
                       </form>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>
     <!-- end subscribe section -->
     <!-- client section -->
     <section class="client_section layout_padding">
        <div class="container">
           <div class="heading_container heading_center">
              <h2>
                 Customer's Testimonial
              </h2>
           </div>
           <div id="carouselExample3Controls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                 <div class="carousel-item active">
                    <div class="box col-lg-10 mx-auto">
                       <div class="img_container">
                          <div class="img-box">
                             <div class="img_box-inner">
                                <img src="images/client.jpg" alt="">
                             </div>
                          </div>
                       </div>
                       <div class="detail-box">
                          <h5>
                             Anna Trevor
                          </h5>
                          <h6>
                             Customer
                          </h6>
                          <p>
                             Dignissimos reprehenderit repellendus nobis error quibusdam? Atque animi sint unde quis reprehenderit, et, perspiciatis, debitis totam est deserunt eius officiis ipsum ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.
                          </p>
                       </div>
                    </div>
                 </div>
                 <div class="carousel-item">
                    <div class="box col-lg-10 mx-auto">
                       <div class="img_container">
                          <div class="img-box">
                             <div class="img_box-inner">
                                <img src="images/client.jpg" alt="">
                             </div>
                          </div>
                       </div>
                       <div class="detail-box">
                          <h5>
                             Anna Trevor
                          </h5>
                          <h6>
                             Customer
                          </h6>
                          <p>
                             Dignissimos reprehenderit repellendus nobis error quibusdam? Atque animi sint unde quis reprehenderit, et, perspiciatis, debitis totam est deserunt eius officiis ipsum ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.
                          </p>
                       </div>
                    </div>
                 </div>
                 <div class="carousel-item">
                    <div class="box col-lg-10 mx-auto">
                       <div class="img_container">
                          <div class="img-box">
                             <div class="img_box-inner">
                                <img src="images/client.jpg" alt="">
                             </div>
                          </div>
                       </div>
                       <div class="detail-box">
                          <h5>
                             Anna Trevor
                          </h5>
                          <h6>
                             Customer
                          </h6>
                          <p>
                             Dignissimos reprehenderit repellendus nobis error quibusdam? Atque animi sint unde quis reprehenderit, et, perspiciatis, debitis totam est deserunt eius officiis ipsum ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.
                          </p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="carousel_btn_box">
                 <a class="carousel-control-prev" href="#carouselExample3Controls" role="button" data-slide="prev">
                 <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                 <span class="sr-only">Previous</span>
                 </a>
                 <a class="carousel-control-next" href="#carouselExample3Controls" role="button" data-slide="next">
                 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                 <span class="sr-only">Next</span>
                 </a>
              </div>
           </div>
        </div>
     </section>
     <!-- end client section -->
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
     <script type="text/javascript">
          
        $(".update-cart").change(function (e) {
            e.preventDefault();
      
            var ele = $(this);
      
            $.ajax({
                url: '{{ route('update.cart2') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id"), 
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                   window.location.reload();
                }
            });
        });
      
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
      
            var ele = $(this);
      
            if(confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart2') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
      
    </script>
  </body>
</html>
     