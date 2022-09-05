@extends('layout.console.master2')
@php
$tenants = App\Models\Tenant\Tenant::where('id', 10)->first();
@endphp

@section('content')
<div class="">
    
            <div class="card">
                <div class="row">
                    <div class="col-lg-9 col-md-12 pr-md-0" >
                    @if (!empty($tenants['images']['banner_img']))
                    <img class="login_img" src="{{asset($tenants['images']['banner_img'])}}">
                    @else
                    <img class="login_img" src="https://via.placeholder.com/219x452">
                    @endif
                    </div>
                    <div class="col-lg-3 col-md-12 pl-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="/" class="noble-ui-logo d-block mb-3">
                                <img class="img-fluid" src="{{ asset('/assets/images/logo.png') }}" alt="" width="150px;">
                            </a>
                            <br>
                            <h5 class="text-primary font-weight-heavy mb-2">{{ __('Reset Password') }}</h5>
                            @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {!! Session::get('success') !!}
                            </div>
                            @endif
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <input id="email" type="email" oninput="this.value = this.value.toLowerCase()" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" readonly="" autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-sm btn-primary" style="width:100%">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
</div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            isLocal: false
        });
    });
</script>
@endpush