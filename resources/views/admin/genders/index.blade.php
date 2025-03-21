@extends('admin.layouts.app')
@section('title')
    @lang('app.genders')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="h3 mb-3">@lang('app.genders')</div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.name') <span class="text-primary">TM</span></th>
                        <th>@lang('app.name') <span class="text-primary">RU</span></th>
                        <th>@lang('app.categoriesCount')</th>
                        <th>@lang('app.productsCount')</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($objs as $obj)
                    <tr>
                        <td>{{ $obj->id }}</td>
                        <td>{{ $obj->name }}</td>
                        <td>{{ $obj->name_tm }}</td>
                        <td>{{ $obj->name_ru }}</td>
                        <td>
                            <a href="{{ route('admin.categories.index', ['gender' => $obj->id]) }}" class="text-decoration-none" target="_blank">
                                {{ $obj->categories_count }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.index', ['gender' => $obj->id]) }}" class="text-decoration-none" target="_blank">
                                {{ $obj->products_count }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
