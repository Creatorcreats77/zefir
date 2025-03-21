@extends('admin.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="h3 mb-0">@lang('app.products')</div>
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi-plus-lg"></i> Add
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th width="10%">@lang('app.image')</th>
                        <th width="15%">@lang('app.name')</th>
                        <th width="20%">@lang('app.description')</th>
                        <th width="15%">@lang('app.attributes')</th>
                        <th>@lang('app.price')</th>
                        <th>@lang('app.stock')</th>
                        <th>@lang('app.sizes')</th>
                        <th><i class="bi-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($objs as $obj)
                    <tr>
                        <td>{{ $obj->id }}</td>
                        <td>
                            <img src="{{ $obj->getImage() }}" alt="" class="img-fluid rounded-3">
                        </td>
                        <td>
                            <div>
                                <a href="{{ route('products.show', $obj->slug) }}" class="text-decoration-none" target="_blank">
                                    {{ $obj->name }}
                                </a>
                            </div>
                            <div class="small font-monospace">
                                <span class="text-secondary">@lang('app.groupId')</span>: {{ $obj->group_id }}
                            </div>
                            <div class="small font-monospace">
                                <i class="bi-upc-scan text-secondary"></i> {{ $obj->product_id }}
                            </div>
                        </td>
                        <td>
                            {{ $obj->description }}
                        </td>
                        <td>
                            <div class="mb-1">
                                <span class="text-secondary">@lang('app.user')</span>: {{ $obj->user->getName() }}
                            </div>
                            <div class="mb-1">
                                <span class="text-secondary">@lang('app.gender')</span>: {{ $obj->gender->getName() }}
                            </div>
                            <div class="mb-1">
                                <span class="text-secondary">@lang('app.category')</span>: {{ $obj->category->getName() }}
                            </div>
                            <div class="mb-1">
                                <span class="text-secondary">@lang('app.brand')</span>: {{ $obj->brand->getName() }}
                            </div>
                            <div>
                                <span class="text-secondary">@lang('app.color')</span>: {{ $obj->color->getName() }}
                            </div>
                        </td>
                        <td>
                            <div class="fs-5">
                                {{ number_format($obj->discounted_price, 2, '.', ' ') }} <small>TMT</small>
                            </div>
                            @if($obj->has_discount)
                                <div class="small text-secondary">
                                    {{ number_format($obj->selling_price, 2, '.', ' ') }} <small>TMT</small>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($obj->has_stock)
                                <i class="bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi-x-circle-fill text-secondary"></i>
                            @endif
                        </td>
                        <td>
                            @foreach($obj->variants->sortBy('size.sort_order') as $variant)
                                <div class="{{ $loop->last ? '':'border-bottom' }}">
                                    <div>
                                        <span class="me-2">{{ $variant->size->getName() }}</span>
                                        <span class="small">
                                            <span class="text-secondary">@lang('app.stock')</span>: {{ $variant->stock }}
                                        </span>
                                    </div>
                                    <div class="small font-monospace">
                                        <i class="bi-upc-scan text-secondary"></i> {{ $variant->variant_id }}
                                    </div>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <div class="mb-1">
                                <a href="{{ route('admin.products.edit', $obj->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi-pencil-fill"></i> @lang('app.edit')
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi-trash-fill"></i> @lang('app.delete')
                                </button>
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-5" id="deleteModalLabel">@lang('app.delete')</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $obj->getName() }}
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('admin.products.destroy', $obj->id) }}">
                                                    @csrf
                                                    {{ method_field('DELETE') }}

                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">@lang('app.close')</button>
                                                    <button type="submit" class="btn btn-dark btn-sm">@lang('app.delete')</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $objs->links() }}
    </div>
@endsection
