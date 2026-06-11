<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block collapse">
    <div class="bg-white rounded-4 p-4 d-flex flex-column" style="position: sticky; top: 1.5rem; height: calc(100vh - 3rem); overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
        <div class="d-inline-flex mb-4 bg-white border rounded-pill p-1 shadow-sm" style="gap: 2px;">
            @foreach(config('app.supported_locales') as $localeCode => $localeName)
                <a href="{{ route('lang.switch', $localeCode) }}" 
                class="btn btn-sm rounded-pill flex-fill px-4 py-2 fw-semibold border-0 {{ App::getLocale() === $localeCode ? 'bg-primary text-white' : 'bg-transparent text-secondary' }}">
                    {{ strtoupper($localeCode) }}
                </a>
            @endforeach
        </div>
        
        <div class="text-center mb-4">
            <img src="{{ asset('images/PL_Logo_whiteBG.png') }}" alt="Logo" style="height: 60px; object-fit: contain;">
        </div>
        
        <h6 class="text-primary fw-bold text-uppercase mb-3 px-2" style="letter-spacing: 1px; font-size: 0.85rem;">{{ __('message.nav.Book Rental') }}</h6>
        
        <ul class="nav flex-column mb-auto gap-2">
            <li class="nav-item">
                <a class="nav-link fw-bold rounded-3 px-3 py-2 {{ request()->routeIs('dashboard') ? 'active' : 'text-muted' }}" 
                   style="font-size: 0.85rem; {{ request()->routeIs('dashboard') ? 'background-color: #eff6ff; color: #3b82f6;' : '' }}" 
                   href="{{ route('dashboard') }}">
                    {{ __('message.nav.Active Rentals') }}
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fw-bold rounded-3 px-3 py-2 {{ request()->routeIs('books.*') ? 'active' : 'text-muted' }}" 
                   style="font-size: 0.85rem; {{ request()->routeIs('books.*') ? 'background-color: #eff6ff; color: #3b82f6;' : '' }}" 
                   href="{{ route('books.index') }}">
                    {{ __('message.nav.Book Collections') }}
                </a>
            </li>

            @can('admin')
            <li class="nav-item">
                <a class="nav-link fw-bold rounded-3 px-3 py-2 {{ request()->routeIs('report.*') ? 'active' : 'text-muted' }}" 
                   style="font-size: 0.85rem; {{ request()->routeIs('report.*') ? 'background-color: #eff6ff; color: #3b82f6;' : '' }}" 
                   href="{{ route('report.index') }}">
                    {{ __('message.nav.Report') }}
                </a>
            </li>
            @endcan

            <li class="nav-item">
                <a class="nav-link fw-bold rounded-3 px-3 py-2 {{ request()->routeIs('settings') ? 'active' : 'text-muted' }}" 
                   style="font-size: 0.85rem; {{ request()->routeIs('settings') ? 'background-color: #eff6ff; color: #3b82f6;' : '' }}" 
                   href="{{ route('settings') }}">
                    {{ __('message.nav.Settings') }}
                </a>
            </li>
        </ul>

        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center px-2">
            <div>
                <span class="d-block fw-bold" style="color: #1f2937; font-size: 0.95rem;">{{ auth()->user()->name }}</span>
                <span class="text-muted" style="font-size: 0.8rem;">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold p-0" style="font-size: 0.85rem;">{{ __('message.auth.Logout') }}</button>
            </form>
        </div>   
    </div> 
</nav>