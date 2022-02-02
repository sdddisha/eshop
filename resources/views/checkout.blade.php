
@extends('layouts.app')

@section('content')
<div class="container"> 

<!-- <form action="{{route('placeorder',['id'=>$id,'total'=>$total])}}" method="POST"> -->
<form method="post" action="{!! URL::to('paypal') !!}" >
 @csrf
<div class="row">
    <div class="col-md-8">
      <div class="card">
         <header class="card-header">
             <h4 class="card-title mt-2">Billing Details</h4>
                            </header>
                            <article class="card-body">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" name="fname">
                                    </div>
                                    <div class="col form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" name="lname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" name="city">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group  col-md-6">
                                        <label>Post Code</label>
                                        <input type="text" class="form-control" name="zip">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="pnumber">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled>
                                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                              
                            </article>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <header class="card-header">
                                        <h4 class="card-title mt-2">Your Order</h4>
                                    </header>
                                    <article class="card-body">
                                        <dl class="dlist-align">
                                            <dt>Total cost: {{$total}}</dt>
                                        
                                        </dl>
                                    </article>
                                </div>
                            </div>
                         

                            <div class="col-md-12 mt-4">
                            <input type="hidden" name="amount" value="{{$total}}"> 
                      <input type="submit" name="paynow" value="Pay with PayPal">
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
@endsection

