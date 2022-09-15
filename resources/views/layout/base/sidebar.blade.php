<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="clipboard"></span>
                    {{ __('messages.sidebar_dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route(name: 'invoices', absolute: false) }}">
                    <span data-feather="file"></span>
                    {{ __('messages.sidebar_invoices') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route(name: 'customers', absolute: false) }}">
                    <span data-feather="users"></span>
                    {{ __('messages.sidebar_customers') }}
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>{{ __('messages.sidebar_settings') }}</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="{{ route(name: 'company-edit', absolute: false) }}">
                    <span data-feather="home"></span>
                    {{ __('messages.sidebar_company') }}
                </a>
            </li>
        </ul>
    </div>
</nav>
