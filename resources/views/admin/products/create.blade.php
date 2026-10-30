@extends('admin.layouts.app')

@section('title', 'Ürün Ekle')

@section('content')
    @include('admin.products.form', ['action' => route('admin.products.store')])
@endsection
