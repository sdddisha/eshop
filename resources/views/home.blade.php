
@extends('layouts.app')
<div>
@section('content')

<div class="container"> 

<a href="{{route('cartItem')}}" class="btn btn-success ml-auto">Cart ({{$total}})</a>

<div class="row">
@foreach($products as $product)
<div class="col-4 col-sm-4 col-md-4 col-lg-4">
<div class="card" style="width: 18rem;">
  <img src="{{asset('/storage/product/'.$product->file_path) }}" width="150px" height="300px" alt="img" class="card-img-top">
  <div class="card-body">
    <h5 class="card-title">{{$product->pname}}</h5>
    <p class="card-text">{{$product->desc}}</p>
    <strong><h7 class="card-text">RS {{$product->price}}</h7></strong>
    <a href="{{route('addtocart',['pid'=>$product->id,'price'=>$product->price])}}" class="btn btn-primary">Add to cart</a>
  </div>

</div>
</div>
@endforeach
</div>
@endsection
</div>
</div>