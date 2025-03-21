<div class="card my-4">
    <div class="card-body">
        <div class="h5 text-uppercase">
            @lang('app.colors')
        </div>
        <div class="row row-cols-4 g-2">
            @foreach($colors->sortBy('color.name') as $color)
                <div class="col position-relative text-center">
                    <div class="mb-2">
                        <img src="{{ $color->getImage() }}" alt="" class="img-fluid rounded-3 border {{ $product->id == $color->id ? 'border-danger':'' }} rounded-3">
                    </div>
                    <div class="h6">
                        <a href="{{ route('products.show', $color->slug) }}"
                           class="link-dark text-decoration-none stretched-link">
                            {{ $color->color->getName() }}
                        </a>
                    </div>
                    @if($color->has_stock)
                        <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">
                            <i class="bi-check-circle-fill"></i> @lang('app.inStock')
                        </span>
                    @else
                        <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">
                            <i class="bi-x-circle-fill"></i> @lang('app.outOfStock')
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
