<a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
   class="link-dark text-decoration-none">
    <div class="w-50 mx-auto mb-2">
        <img src="{{ $brand->getImage() }}" alt="" class="img-fluid rounded-circle">
    </div>
    <div class="text-center">
        {{ $brand->getName() }} <i class="bi-chevron-right"></i>
    </div>
</a>
