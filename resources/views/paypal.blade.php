<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   
    <form method="post" action="{{route('paypal',['total'=>$total1,'data'=>$data])}}" id="payment-form">

        @csrf
        
        <label for="fname">Paywith Paypal:</label><br>
        
        price:
        
        <input type="text" id="amount" name="amount" value="{{$total1}}"><br><br>
    <input type="hidden" value="{{$data}}">
        <input type="submit" value="Pay with Paypal">
        
        </form>


</body>
</html>