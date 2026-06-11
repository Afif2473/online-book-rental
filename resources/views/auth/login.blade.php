<x-guest-layout>
    <div class="d-inline-flex mb-4 bg-white border rounded-pill p-1 shadow-sm" style="gap: 2px;">
        @foreach(config('app.supported_locales') as $localeCode => $localeName)
            <a href="{{ route('lang.switch', $localeCode) }}" 
            class="btn btn-sm rounded-pill px-4 py-2 fw-semibold border-0 {{ App::getLocale() === $localeCode ? 'bg-primary text-white' : 'bg-transparent text-secondary' }}">
                {{ strtoupper($localeCode) }}
            </a>
        @endforeach
    </div>
    <div class="text-center mb-5">
                    <div style="font-size: 3rem;">
                        <img src="{{ asset('images/PL_Logo.png') }}" alt="Planet Library Logo" style="height: 5rem;">
                    </div>
                    <h2 class="fw-bold mt-2" style="color: #111827;">Planet Library</h2>
    </div>
    <form method="POST" action="{{ route('login') }}" class="w-100" style="max-width: 350px;">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger pb-0">
                <ul class="mb-2">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <input type="email" class="form-control figma-input w-100" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('message.auth.Email') }}">
        </div>

        <div class="mb-3">
            <input type="password" class="form-control figma-input w-100" name="password" placeholder="{{ __('message.auth.Password') }}">
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <input id="remember_me" type="checkbox" class="form-check-input mt-0 me-2" name="remember">
                <label for="remember_me" class="form-check-label text-muted" style="font-size: 0.85rem;">{{ __('message.auth.Remember Me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #3b82f6;">
                    {{ __('message.auth.Forgot password') }}
                </a>
            @endif
        </div>
        <div class="mb-3">
            <button type="submit" class="w-100 figma-btn">{{ __('message.auth.Sign In') }}</button>
        </div>

        <div class="text-start">
            <a href="{{ route('register') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #3b82f6;">{{ __('message.auth.No Account?') }}</a>
        </div>
    </form>
</x-guest-layout>