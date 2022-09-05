@extends('layout.console.master2')
@php
$tenants = App\Models\Tenant\Tenant::where('id', 10)->first();
@endphp

@section('content')
@php
use App\User;
$user = User::where('remember_token', $token)->first();
$user_id = $user->id;
@endphp
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
                            <h5 class="text-primary font-weight-heavy mb-2">Set Password </h5>
                            @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {!! Session::get('success') !!}
                            </div>
                            @endif
                            <form method="POST" action="{{ url('create-new-password/'.$token.'/pass') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" readonly="" autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- @php
                                $info = "<ul>";
                                    $info .= "<li>English uppercase characters (A – Z)</li>";
                                    $info .= "<li>English lowercase characters (a – z) </li>";
                                    $info .= "<li>Base 10 digits (0 – 9)</li>";
                                    $info .= "<li>Non-alphanumeric (For example: !, $, #, or %)</li>";
                                    $info .= "<li>Unicode characters</li>";
                                    $info .= "</ul>";
                                @endphp -->
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="English uppercase characters (A – Z)
English lowercase characters (a – z)
Base 10 digits (0 – 9)
Non-alphanumeric (For example: !, $, #, or %)
Unicode characters"></i></span>

                                    </label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                    @if ($errors->has('password_confirmation'))
                                    <span class=".help-block" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-sm btn-primary" style="width:100%">
                                        {{ __('Set Password') }}
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