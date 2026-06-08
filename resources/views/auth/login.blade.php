<x-guest-layout>
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
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <input type="email" class="form-control figma-input w-100" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
        </div>

        <div class="mb-3">
            <input type="password" class="form-control figma-input w-100" name="password" required placeholder="Password">
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <input id="remember_me" type="checkbox" class="form-check-input mt-0 me-2" name="remember">
                <label for="remember_me" class="form-check-label text-muted" style="font-size: 0.85rem;">Remember Me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #3b82f6;">
                    Forgot password?
                </a>
            @endif
        </div>
        <div class="mb-3">
            <button type="submit" class="w-100 figma-btn">Sign In</button>
        </div>

        <div class="text-start">
            <a href="{{ route('register') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #3b82f6;">Don't have an account?</a>
        </div>
    </form>
</x-guest-layout>