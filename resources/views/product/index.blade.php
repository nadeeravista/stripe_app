@extends('layouts.main')
@section('content')

<h1>All the Products</h1>
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Unit Price</td>
            <td>Quantity</td>
            <td>Category</td>

        </tr>
    </thead>
    <tbody>
        @foreach($products as $key => $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{config("cart_settings.currency")}}{{ $product->unit_price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->category }}</td>
            <td>
                <a class="btn btn-small btn-info" href="{{ URL::to('product/' . $product->id . '/edit') }}">Edit this Product</a>
            </td>
            <td>
                {{ Form::open(array('url' => 'product/' . $product->id, 'class' => 'pull-right')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete this Product', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection