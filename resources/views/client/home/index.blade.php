@extends('client.layouts.app')
@section('title')
    @lang('app.home')
@endsection
@section('content')
    @include('client.home.index.brands')
    @include('client.home.index.categories')
@endsection
