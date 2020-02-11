@extends('layouts.shopping')
@section('content')
<h1>Available Products</h1>
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
    @foreach($products as $key => $product)
    {!! Form::open(['url' => 'add_to_cart', 'files' => true]) !!}
    {{ Form::hidden('product_id', $product->id) }}
    <div class="row" >
        <div class="col-md-2"><img style="width: 150px" src="{{url("get_product_image/".$product->id)}}"/></div>
        <div class="col-md-4">
            <h2>{{ $product->name }} {{$product->unit_price}}</h2>
            <h4>{{ $product->description }}</h4>
            <div class="form-group">
                {{ Form::number('quantity', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::submit('Add to Cart', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @endforeach
    <div class="row" >
        <div class="col-md-6">
            <div class="form-group">
                <a href="{{url('view_cart')}}" class="btn btn-success btn-block" role="button">View Cart</a> 
            </div>
        </div>
    </div>
</div>
@endsection