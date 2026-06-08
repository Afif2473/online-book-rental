@extends('layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8fafc;">
    <div class="bg-white rounded-4 shadow-sm p-5" style="max-width: 500px; width: 100%;">
        
        <div class="text-center mb-4">
            <img src="{{ asset('images/PL_Logo.png') }}" alt="Planet Library Logo" style="height: 4rem;">
            <h3 class="fw-bold mt-3" style="color: #111827;">Verify Your Email</h3>
        </div>

        <p class="text-muted text-center mb-4">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>

        @if (session('message') == 'Verification link sent!')
            <div class="alert alert-success border-0 rounded-3 text-center mb-4">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="d-flex flex-column gap-3 mt-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-100 m-0">
                @csrf
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-100 m-0 text-center">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold p-0">
                    Log out
                </button>
            </form>
        </div>

    </div>
</div>
@endsection