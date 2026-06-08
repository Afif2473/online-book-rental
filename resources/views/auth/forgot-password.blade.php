<x-guest-layout>
    <div class="text-center mb-4">
        <div style="font-size: 3rem;">
            <img src="{{ asset('images/PL_Logo.png') }}" alt="Planet Library Logo" style="height: 5rem;">
        </div>
        <h3 class="fw-bold mt-2" style="color: #111827;">Reset Password</h3>
    </div>

    <div class="mb-4 text-muted text-center" style="font-size: 0.9rem;">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    <!-- Session Status (Shows the success message after email is sent) -->
    @if (session('status'))
        <div class="alert alert-success pb-0 mb-4" style="font-size: 0.85rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="w-100" style="max-width: 350px;">
        @csrf

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger pb-0 mb-4" style="font-size: 0.85rem;">
                <ul class="mb-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Email Address -->
        <div class="mb-4">
            <input type="email" class="form-control figma-input w-100" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
                Back to login
            </a>
            <button type="submit" class="figma-btn px-4 border-0 rounded-pill text-white fw-bold" style="background-color: #3b82f6; padding: 0.5rem 1rem;">
                Email Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>