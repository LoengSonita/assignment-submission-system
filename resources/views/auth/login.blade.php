<x-guest-layout>
    <div class="text-center mb-4">
        <i class="fas fa-sign-in-alt fa-2x text-primary"></i>
        <h4 class="mt-2 fw-bold">Welcome Back!</h4>
        <p class="text-muted small">Sign in to your account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">
                <i class="fas fa-envelope me-1 text-primary"></i> Email Address
            </label>
            <input type="email" id="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">
                <i class="fas fa-lock me-1 text-primary"></i> Password
            </label>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label small">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-gradient w-100">
            <i class="fas fa-sign-in-alt me-2"></i> Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                    Create an account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
