<div class="position-relative bg-white h-100 rounded-3 p-1 p-sm-2 shadow-sm">
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
    <div class="small fw-semibold">
        {{ $product->brand->getName() }}
    </div>
    <div class="small fw-semibold">
        {{ $product->category->getName() }}
    </div>
    <a href="{{ route('products.show', $product->slug) }}"
       class="d-block small link-dark text-decoration-none stretched-link">
        {{ $product->getName() }}
    </a>
    @if($product->has_discount)
        <div class="fw-semibold text-danger">
            {{ number_format($product->discounted_price, 2, '.', ' ') }} <small>TMT</small>
            <span class="small text-secondary text-decoration-line-through">
                {{ number_format($product->selling_price, 2, '.', ' ') }}
            </span>
        </div>
    @else
        <div class="fw-semibold text-primary">
            {{ number_format($product->discounted_price, 2, '.', ' ') }} <small>TMT</small>
        </div>
    @endif
</div>
