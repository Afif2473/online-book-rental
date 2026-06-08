<x-guest-layout>
    <!-- Logo Header matching login.blade.php -->
    <div class="text-center mb-5">
        <div style="font-size: 3rem;">
            <img src="{{ asset('images/PL_Logo.png') }}" alt="Planet Library Logo" style="height: 5rem;">
        </div>
        <h2 class="fw-bold mt-2" style="color: #111827;">Set New Password</h2>
    </div>

    <!-- Form wrapper matching login.blade.php -->
    <form method="POST" action="{{ route('password.store') }}" class="w-100" style="max-width: 350px;">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Error Handling matching login.blade.php -->
        @if ($errors->any())
            <div class="alert alert-danger pb-0">
                <ul class="mb-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Email Address (Static/Readonly) -->
        <div class="mb-3">
            <!-- Added readonly, bg-light, and text-muted to make it visually clear it cannot be edited -->
            <input type="email" class="form-control figma-input w-100 bg-light text-muted" name="email" value="{{ old('email', $request->email) }}" required readonly placeholder="Email">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <!-- Moved autofocus here since the email is already filled out -->
            <input type="password" class="form-control figma-input w-100" name="password" required autofocus placeholder="New Password" autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <input type="password" class="form-control figma-input w-100" name="password_confirmation" required placeholder="Confirm New Password" autocomplete="new-password">
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="w-100 figma-btn">Reset Password</button>
        </div>
    </form>
</x-guest-layout>