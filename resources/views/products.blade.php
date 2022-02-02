@extends('layout1')
<div>

@section('content')

                    
  <ul class="navbar-nav">
      @foreach($sub as $item)
      <li class="nav-item active">
         <a class="nav-link" href="{{$item->link}}">{{$item->name}}<span class="sr-only">(current)</span></a>
      </li>
      @endforeach
  </ul>

<div class="container"> 

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message')}}
    </div>
@endif
<div class="row">
@foreach($products as $product)
<div class="col-4 col-sm-4 col-md-4 col-lg-4 mt-4">
<div class="card" style="width: 18rem;">
  <img src="{{asset('/storage/product/'.$product->file_path) }}" width="100" height="100" class="img-responsive"/>
  <div class="card-body">
    <h5 class="card-title">{{$product->pname}}</h5>
    <p class="card-text">{{$product->desc}}</p>
    <strong><h7 class="card-text">RS {{$product->price}}</h7></strong>
    <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
  </div>

</div>
</div>
@endforeach
</div>
@endsection
</div>
</div>