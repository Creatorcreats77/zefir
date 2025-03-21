<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Navbar">
    <div class="container-xxl">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">@lang('app.admin')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse position-relative" id="navbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link link-light" href="{{ route('admin.banners.index') }}"><i class="bi-image"></i> @lang('app.banners')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light" href="{{ route('admin.products.index') }}"><i class="bi-box"></i> @lang('app.products')</a>
                </li>
                @if(auth()->user()['is_admin'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            @lang('app.more')
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.genders.index') }}">@lang('app.genders')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">@lang('app.categories')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.brands.index') }}">@lang('app.brands')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.attributes.index') }}">@lang('app.attributes')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.attributeValues.index') }}">@lang('app.attributeValues')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.variants.index') }}">@lang('app.variants')</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">@lang('app.users')</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link link-warning" href="{{ route('home') }}" target="_blank">
                        <i class="bi-house"></i> @lang('app.home')
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                        <i class="bi-box-arrow-up-right"></i> @lang('app.logout')
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="logout">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
