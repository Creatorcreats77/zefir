@extends('client.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="row g-4">
            <div class="col-md-4 col-xl-3">
                <div class="position-relative mb-2">
                    <img src="{{ $product->getImage() }}" alt="" class="img-fluid rounded-3">
                    <div class="position-absolute top-0 start-0 m-1">
                        @if($product->isNew())
                            <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">
                                @lang('app.new')
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="h4 fw-semibold">
                    <a href="{{ route('products.index', ['brand' => $product->brand->slug]) }}"
                       class="link-dark text-decoration-none">
                        {{ $product->brand->getName() }}
                    </a>
                </div>
                <div class="h4 fw-semibold">
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                       class="link-dark text-decoration-none">
                        {{ $product->category->getName() }}
                    </a>
                </div>
                <div class="h3">
                    <a href="{{ route('products.show', $product->slug) }}" class="link-dark text-decoration-none">
                        {{ $product->getName() }}
                    </a>
                </div>
                @if($product->has_discount)
                    <div class="h4 text-danger">
                        {{ number_format($product->discounted_price, 2, '.', ' ') }} <small>TMT</small>
                        <span class="small text-secondary text-decoration-line-through">
                            {{ number_format($product->selling_price, 2, '.', ' ') }}
                        </span>
                    </div>
                @else
                    <div class="h4 text-primary">
                        {{ number_format($product->discounted_price, 2, '.', ' ') }} <small>TMT</small>
                    </div>
                @endif
                <div>
                    {{ $product->description }}
                </div>

                <div class="row">
                    <div class="col-md-10 col-xl-6">
                        @include('client.products.show.colors')
                        @include('client.products.show.sizes')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.products.show.similar')
@endsection
