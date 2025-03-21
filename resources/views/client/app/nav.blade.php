<nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Navbar">
    <div class="container-xxl">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">@lang('app.appName')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse position-relative" id="navbar">
            <ul class="navbar-nav me-auto">
                @foreach($categories as $category)
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle"
                           href="{{ route('products.index', ['category' => $category->slug]) }}"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->getName() }}
                        </a>
                        <div class="dropdown-menu w-100 py-0 px-3">
                            @foreach($category->children as $child)
                                <div class="my-3">
                                    <a class="h6 mb-3 link-dark text-decoration-none text-uppercase"
                                       href="{{ route('products.index', ['category' => $child->slug]) }}">
                                        {{ $child->getName() }}
                                    </a>
                                    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-0">
                                        @foreach($child->children as $grandchild)
                                            <div class="col">
                                                <a class="link-dark text-decoration-none text-truncate"
                                                   href="{{ route('products.index', ['category' => $grandchild->slug]) }}">
                                                    {{ $grandchild->getName() }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </li>
                @endforeach
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        @lang('app.language')
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="{{ route('locale', 'tm') }}"
                               class="dropdown-item {{ app()->getLocale() == 'tm' ? 'fw-bold' : '' }}">Türkmen</a></li>
                        <li><a href="{{ route('locale', 'ru') }}"
                               class="dropdown-item {{ app()->getLocale() == 'ru' ? 'fw-bold' : '' }}">Русский</a></li>
                        <li><a href="{{ route('locale', 'en') }}"
                               class="dropdown-item {{ app()->getLocale() == 'en' ? 'fw-bold' : '' }}">English</a></li>
                    </ul>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link link-warning" href="{{ route('admin.dashboard') }}" target="_blank">
                            <i class="bi-speedometer"></i> @lang('app.dashboard')
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            @lang('app.merchant')
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('login') }}">@lang('app.login')</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">@lang('app.register')</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
