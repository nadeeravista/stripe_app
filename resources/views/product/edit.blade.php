@extends('layouts.main')
@section('content')


<h1>Edit {{ $product->name }}</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div>
    <img style="width: 150px" src="{{url('get_product_image/'.$product->id)}}" >
</div>
{{ Form::model($product, array('route' => array('product.update', $product->id), 'method' => 'PUT',  'files' => true,'id'=>'frm_product')) }}

<div class="form-group">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('description', 'Description') }}
    {{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('unit_price', 'Unit Price ('.config("cart_settings.currency").")") }}
    {{ Form::text('unit_price', Input::old('unit_price'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('quantity', 'Qantity') }}
    {{ Form::number('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('category', 'Category') }}
    {{ Form::select('category', $productCategory, Input::old('category'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {!! Form::label('Product Image') !!}
    {!! Form::file('image', null) !!}
</div>
<br/>

{{ Form::submit('Update Prodcut', array('class' => 'btn btn-primary')) }}
{!! Form::close() !!}
@endsection