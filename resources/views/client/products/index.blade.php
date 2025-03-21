@extends('client.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="row g-4">
            <div class="col-md-4 col-xl-3">
                @include('client.products.index.filter')
            </div>
            <div class="col">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-2 g-md-3">
                    @foreach($products as $product)
                        <div class="col">
                            @include('client.app.product')
                        </div>
                    @endforeach
                </div>
                <div class="pt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
