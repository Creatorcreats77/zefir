<div>
    <form action="{{ url()->current() }}" method="get">

        <div class="mb-3">
            <label for="gender" class="form-label fw-semibold">@lang('app.gender')</label>
            <select class="form-select" id="gender" name="gender">
                <option value>-</option>
                @foreach($genders as $gender)
                    <option value="{{ $gender->slug }}" {{ $gender->slug == $f_gender ? 'selected':'' }}>
                        {{ $gender->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label fw-semibold">@lang('app.category')</label>
            <select class="form-select" id="category" name="category">
                <option value>-</option>
                @foreach($categories as $grandparent)
                    <option value="{{ $grandparent->slug }}" {{ $grandparent->slug == $f_category ? 'selected':'' }}>
                        {{ $grandparent->getName() }}
                    </option>
                    @foreach($grandparent->children as $parent)
                        <option value="{{ $parent->slug }}" {{ $parent->slug == $f_category ? 'selected':'' }}>
                            {{ $grandparent->getName() }} / {{ $parent->getName() }}
                        </option>
                        @foreach($parent->children as $child)
                            <option value="{{ $child->slug }}" {{ $child->slug == $f_category ? 'selected':'' }}>
                                {{ $grandparent->getName() }} / {{ $parent->getName() }} / {{ $child->getName() }}
                            </option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label fw-semibold">@lang('app.brand')</label>
            <select class="form-select" id="brand" name="brand">
                <option value>-</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->slug }}" {{ $brand->slug == $f_brand ? 'selected':'' }}>
                        {{ $brand->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="colors" class="form-label fw-semibold">@lang('app.colors')</label>
            <select class="form-select" id="colors" name="colors[]" multiple size="3">
                @foreach($colors as $color)
                    <option value="{{ $color->id }}" {{ in_array($color->id, $f_colors) ? 'selected':'' }}>
                        {{ $color->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sizes" class="form-label fw-semibold">@lang('app.sizes')</label>
            <select class="form-select" id="sizes" name="sizes[]" multiple size="3">
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}" {{ in_array($size->id, $f_sizes) ? 'selected':'' }}>
                        {{ $size->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sortBy" class="form-label fw-semibold">@lang('app.sortBy')</label>
            <select class="form-select" id="sortBy" name="sortBy">
                <option value {{ 'random' == $f_sortBy ? 'random':'' }}>
                    @lang('app.random')
                </option>
                <option value="newToOld" {{ 'newToOld' == $f_sortBy ? 'selected':'' }}>
                    @lang('app.newToOld')
                </option>
                <option value="lowToHigh" {{ 'lowToHigh' == $f_sortBy ? 'selected':'' }}>
                    @lang('app.lowToHigh')
                </option>
                <option value="highToLow" {{ 'highToLow' == $f_sortBy ? 'selected':'' }}>
                    @lang('app.highToLow')
                </option>
            </select>
        </div>

        <div class="row g-2">
            <div class="col">
                <button type="submit" class="btn btn-primary w-100">
                    @lang('app.filter')
                </button>
            </div>
            <div class="col">
                <a href="{{ url()->current() }}" class="btn btn-light w-100">
                    @lang('app.clear')
                </a>
            </div>
        </div>

    </form>
</div>
