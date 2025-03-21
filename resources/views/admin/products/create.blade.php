@extends('admin.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">

                <div class="h4 mb-3">
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                        <i class="bi-chevron-left"></i> @lang('app.products')
                    </a> / @lang('app.add')
                </div>

                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">
                            @lang('app.category') <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required autofocus>
                            @foreach($categories as $grandparent)
                                @foreach($grandparent->children as $parent)
                                    @foreach($parent->children as $child)
                                        <option value="{{ $child->id }}">
                                            {{ $grandparent->getName() }} / {{ $parent->getName() }} / {{ $child->getName() }}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                        @error('category')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="brand" class="form-label fw-semibold">
                                @lang('app.brand') <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('brand') is-invalid @enderror" id="brand" name="brand" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">
                                        {{ $brand->getName() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="color" class="form-label fw-semibold">
                                @lang('app.color') <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('color') is-invalid @enderror" id="color" name="color" required>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">
                                        {{ $color->getName() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('color')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-4">
                            <label for="group_id" class="form-label fw-semibold">
                                @lang('app.groupId') <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('group_id') is-invalid @enderror" id="group_id"
                                   name="group_id" value="{{ old('group_id') }}" required>
                            @error('group_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="name" class="form-label fw-semibold">
                                @lang('app.name') <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">
                            @lang('app.description') <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" id="description" rows="2" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="discounted_price" class="form-label fw-semibold">
                                @lang('app.discountedPrice') <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.1" min="0"
                                   class="form-control @error('discounted_price') is-invalid @enderror" id="discounted_price"
                                   name="discounted_price" value="0" required>
                            @error('discounted_price')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="selling_price" class="form-label fw-semibold">
                                @lang('app.sellingPrice') <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.1" min="0"
                                   class="form-control @error('selling_price') is-invalid @enderror" id="selling_price"
                                   name="selling_price" value="0" required>
                            @error('selling_price')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sizes" class="form-label fw-semibold">
                            @lang('app.sizes') <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('sizes') is-invalid @enderror" id="sizes" name="sizes[]" multiple size="3" required>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">
                                    {{ $size->getName() }}
                                </option>
                            @endforeach
                        </select>
                        @error('sizes')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        @lang('app.add')
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
