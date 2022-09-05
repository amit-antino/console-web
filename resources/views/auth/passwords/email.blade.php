{{-- <div class="col-lg-3 col-md-12 pl-md-0" id="change-div"> --}}
    <div class="auth-form-wrapper px-4 py-5">
        <a href="/" class="noble-ui-logo d-block mb-3">
            <img class="img-fluid" src="{{ asset('/assets/images/logo.png') }}" alt="" width="150px;">
        </a>
        <br>
        <h5 class="text-primary font-weight-heavy mb-2">Forgot Password !</h5>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('success') !!}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" oninput="this.value = this.value.toLowerCase()" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" style="width:100%">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
{{-- </div> --}}
