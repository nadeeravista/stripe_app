@extends('layouts.shopping')
@section('content')
<h1>Orders</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-info">
    {{ Session::get('success') }}
</div>
@endif

<div class="container">
    @foreach($orders as $key => $order)

    <div class="row" >
        <div class="col-md-12">
            <h2>{{ $order->status }} {{ config('cart_settings.currency').$order->payment}}</h2>
            <h4>{{ $order->description }}</h4>
        </div>
        @foreach($order->items as  $item)
        <div class="col-md-12">
          
             <div class="col-md-2"><img style="width: 150px" src="{{url("get_order_product_image/".$order->id)}}"/></div>
            <div class="col-md-2">
                {{ $item->name }}
            </div>
            <div class="col-md-2">
                {{ $item->unit_price }} x {{ $item->quantity }} = {{ config('cart_settings.currency').$item->total }}
            </div>
            
        </div>
        @endforeach
    </div>
    @endforeach

</div>
@endsection