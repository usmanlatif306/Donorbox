@extends('layouts.auth')

@section('content')
    <!--begin::Wrapper-->
    <div class="w-lg-500px p-10">
        <form id="kt_sign_in_form" class="form w-100" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
            </div>

            <div class="fv-row mb-8">
                <input type="email" placeholder="Enter Email Address" name="email" autocomplete="off"
                    class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}"
                    required />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="fv-row mb-3">
                <input type="password" placeholder="Password" name="password" autocomplete="off"
                    class="form-control bg-transparent @error('password') is-invalid @enderror" required />
            </div>

            <div class="fv-row mb-3">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="remember" @checked(old('remember')) />
                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{ __('Remember Me') }}
                </label>
            </div>

            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <a href="{{ route('password.request') }}" class="link-primary">{{ __('Forgot Password ?') }}</a>
            </div>

            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('Sign In') }}</span>
                </button>
            </div>

            @if (Route::has('register'))
                <div class="text-gray-500 text-center fw-semibold fs-6">{{ __('Not a Member yet?') }}
                    <a href="{{ route('register') }}" class="link-primary">{{ __('Sign up') }}</a>
                </div>
            @endif
        </form>
    </div>
@endsection
