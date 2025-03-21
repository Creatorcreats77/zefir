<div class="bg-secondary bg-opacity-10">
    <div class="container-xxl py-4">
        <div class="h4 text-uppercase mb-4">
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
               class="link-dark text-decoration-none">
                @lang('app.similarProducts') <i class="bi-chevron-right"></i>
            </a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-2 g-md-3">
            @foreach($similar as $product)
                <div class="col">
                    @include('client.app.product')
                </div>
            @endforeach
        </div>
    </div>
</div>
