@extends('client.layouts.app')
@section('title')
    @lang('app.brands')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="h4 text-uppercase mb-4">
            @lang('app.brands')
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3 g-md-4">
            @foreach($brands as $brand)
                <div class="col">
                    @include('client.app.brand')
                </div>
            @endforeach
        </div>
    </div>
@endsection
