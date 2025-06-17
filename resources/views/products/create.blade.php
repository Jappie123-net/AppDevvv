@extends('layouts.app')

@section('content')
    <h2>Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('products.form')
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
