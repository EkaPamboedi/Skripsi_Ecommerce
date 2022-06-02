@extends('layouts.app_login')

@section('content')
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
   <img style="width:15%;" src="{{ asset('/Logo_Kedai/Icon_KenalKopi.png') }}" class="user-image img-profil"
    alt="User Image"><b>Kenal Kopi</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login for Admin Only </p>



    <form method="POST" action="{{ route('login') }}">
        @csrf

      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      @if(session('wrong'))
          <span style="color:red;" class="invalid-feedback" role="alert">
              <strong>{{ session('wrong')}}</strong>
          </span>

      @endif
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a  href="{{ route('kenalkopi.index') }}" class="btn btn-block btn-social btn-success btn-flat"><i class="fa fa-qrcode"></i> Sign in as
        User using
        Qr Code</a>
      @if (Route::has('password.request'))
      <!-- <a  href="{{ route('password.request') }}" class="btn btn-block btn-social btn-warning btn-flat"><i class="fa fa-exclamation"></i> Forgot Password</a> -->
      @endif
    </div>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
</body>
@endsection
