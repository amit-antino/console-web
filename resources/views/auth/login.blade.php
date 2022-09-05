@extends('layout.console.master2')
@php
$tenants = App\Models\Tenant\Tenant::where('id', 1)->first();
@endphp
@section('content')
<div class="">

    <div class="card">
        <div class="row">
            <div class="col-lg-9 col-md-12 pr-md-0">
                @if (!empty($tenants->images['banner_img']))
                <img class="login_img" src="{{asset($tenants->images['banner_img'])}}">
                @else
                <img class="login_img" src="https://via.placeholder.com/219x452">
                @endif
            </div>
            <div class="col-lg-3 col-md-12 pl-md-0" id="change-div">
                <div class="auth-form-wrapper px-4 py-5">
                    <a href="/" class="noble-ui-logo d-block mb-3">
                        <img class="img-fluid" src="{{ asset('/assets/images/logo.png') }}" alt="" width="150px;">
                    </a>
                    <br>
                    <h5 class="text-primary font-weight-heavy mb-2">Welcome back ! </h5>
                    <h6 class="text-muted font-weight-normal mb-5">Log in to your account.</h6>
                    @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {!! Session::get('success') !!}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="username" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @if ($errors->first('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                        <div class="form-group mt-2">
                            <label for="password" class="">Password </label>
                            <a href="javascript:void(0)" data-target="#change-div" data-request="ajax-append-list" data-url="{{ route('password.request') }}" class="d-block text-muted float-right">Forgot
                                Password?</a>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @if ($errors->first('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if(!empty($tenants->ldap_auth) && $tenants->ldap_auth=='on')
                        <div class="form-group mt-2">
                            <label for="login_method" class="">Authentication Type </label>
                            <select class="form-control" name="login_method" id="login_method">
                                <option @if(old('login_method')=='ldap' ) selected @endif value="ldap">LDAP</option>
                                <option @if(old('login_method')=='local' ) selected @endif value="local">Local</option>
                            </select>
                            @if ($errors->first('login_method'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('login_method') }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif
                        <div class="form-check form-check-flat form-check-secondary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input">
                                Remember me
                            </label>
                        </div>
                        <div class="mt-3">
                            <!-- <a type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="login"]' class="btn btn-secondary mr-2 mb-2 mb-md-0">Login</a> -->
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                
                @if (!empty($tenants['images']['main_logo']))
                
                <div class="row">
                    <div class="col-md-6 offset-4">
                        <img class="" style="max-width: 100%;height:30px;margin-top:-35px;" src="{{ asset($tenants['images']['main_logo']) }}" alt="">
                    </div>
                </div>
                @endif
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
