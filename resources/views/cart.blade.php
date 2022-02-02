
@extends('layouts.app')
<div>
@section('content')

<div class="container"> 

<table class="table">
  <thead>
    <tr>
    <!-- <th scope="col">#</th> -->
      <th scope="col">product Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Sub Total</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php $total=0 ?>
  @foreach($item as $product)
    <tr>  
    <?php   $total+= $product->price*$product->quantity    ?> 
    <!-- <td><img src="{{asset('/storage/product/'.$product->product->file_path) }}" alt="img" class="card-img-top"></td> -->
      <th scope="row">{{$product->product->pname}}</th>
      <th scope="row">{{$product->quantity}}</th>
      <th scope="row"><?php echo $product->price*$product->quantity ; ?></th>
       
      <td><a href="{{route('delete',['id'=>$product->id,'pid'=>$product->product_id])}}" class="btn btn-primary">Delete</a></td>
      
    </tr>
    @endforeach
    
  </tbody>
</table>
<strong><h5>Total={{$total}}</strong></h5>
<a href="{{route('checkout',['id'=>$product->user_id,'total'=>$total])}}" class="btn btn-success">Checkout</a >
</div>

@endsection
</div>

</div>