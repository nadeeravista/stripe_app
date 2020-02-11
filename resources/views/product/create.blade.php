@extends('layouts.main')
@section('content')

<h1>Add a Product</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- if there are creation errors, they will show here -->


{!! Form::open(['url' => 'product', 'files' => true,'id'=>'frm_product']) !!}

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

{{ Form::submit('Create the Prodcut', array('class' => 'btn btn-primary')) }}
{!! Form::close() !!}
@endsection