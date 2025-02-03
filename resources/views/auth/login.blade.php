@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #000;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0" style="background-color: #1a1a1a; color: #f5f5f5;">
            <div class="card-header text-center" style="background-color: #333; border-bottom: 1px solid #444;">
                <h4 style="color: #fff;">{{ __('Login') }}</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                               style="background-color: #2c2c2c; color: #fff; border: 1px solid #444;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password" 
                               style="background-color: #2c2c2c; color: #fff; border: 1px solid #444;">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" 
                               {{ old('remember') ? 'checked' : '' }} style="border: 1px solid #444;">
                        <label class="form-check-label" for="remember" style="color: #ddd;">{{ __('Remember Me') }}</label>
                    </div> --}}

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" style="background-color: #555; border: none;">{{ __('Login') }}</button>
                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #1e90ff;">{{ __('Forgot Your Password?') }}</a>
                        @endif --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
