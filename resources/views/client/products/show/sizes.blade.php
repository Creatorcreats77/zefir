<div class="card my-4">
    <div class="card-body">
        <div class="h5 text-uppercase">
            @lang('app.sizes')
        </div>
        <div class="row row-cols-4 g-2">
            @foreach($sizes->sortBy('size.sort_order') as $size)
                <div class="col text-center">
                    <div class="h6 text-center border rounded-3 p-1 p-sm-2">
                        {{ $size->size->getName() }}
                    </div>
                    @if($size->stock > 0)
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
