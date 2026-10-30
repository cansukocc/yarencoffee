@extends('admin.layouts.app')

@section('title', 'Ürünü Düzenle')

@section('content')
    @include('admin.products.form', ['action' => route('admin.products.update', $product), 'method' => 'PUT'])
@endsection
