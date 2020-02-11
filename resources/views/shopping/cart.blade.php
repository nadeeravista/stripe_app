@extends('layouts.shopping')
@section('content')

<h1>Todays deals</h1>
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
    @foreach($cartItems as $key => $item)
    <div class="row" >
         @if($item->product)
        <div class="col-md-4"><img style="width: 150px" src="{{url("get_product_image/".$item->product->id)}}"/></div>
        <div class="col-md-4">
            <h2>{{ $item->product->name}} {{ $item->quantity}}</h2>
            <h4>{{ $item->unit_price}}x{{ $item->quantity}} = {{ $item->total}}</h4>
            <div class="form-group">
                <a href="{{url('remove_from_cart/'.$item->id)}}" class="btn btn-danger" role="button">Remove from Cart</a> 
            </div>
            
        </div>
        @else
        <div class="col-md-4">{{$item->product_id}}(Product deleted)</div>
        <div class="col-md-4">
            <h4>{{ $item->unit_price}}x{{ $item->quantity}} = {{ $item->total}}</h4>
         <div class="form-group">
                <a href="{{url('remove_from_cart/'.$item->id)}}" class="btn btn-danger" role="button">Remove from Cart</a> 
            </div>
        </div>
          
          @endif
    </div>
    @endforeach
    <div class="row" style="color: gray">
        <h3>
            <div class="col-md-5">
                Sub Total:
            </div>
            <div class="col-md-2">
                {{$cartTotal}}
            </div>
        </h3>
    </div>
    <div class="row" style="color: gray">
        <h3>
            <div class="col-md-5">
                Shipping:
            </div>
            <div class="col-md-2">
                0
            </div>
        </h3>
    </div>
    <div class="row">
        <h3>
            <div class="col-md-5">
                Total:
            </div>
            <div class="col-md-2">
                {{$cartTotal}}
            </div>
        </h3>
    </div>
    <br/>
    <div class="row">

        <div class="col-md-6 right">
            <div class="form-group">
                <a href="{{url('checkout')}}" class="btn btn-success btn-block" role="button">Check Out</a> 
            </div>
        </div>
    </div>
</div>
@endsection