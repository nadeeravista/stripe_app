@extends('layouts.shopping')
@section('content')
<div class="container">
    <nav class="navbar navbar-inverse">
        <div class="row" >
            <div class="col-md-11">
                <ul class="nav navbar-nav">
                    <li><a href="{{ URL::to('shopping') }}">View All Products</a></li>
                    <li><a href="{{ URL::to('product/create') }}">View Cart</a>
                </ul>
            </div>
        </div>
    </nav>
    <div class="alert alert-info">
        <h1>Your payment successful</h1>
    </div>
    <div class="container">

    </div>
</div>
@endsection