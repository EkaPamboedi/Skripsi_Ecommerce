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
    <p class="login-box-msg">Forgot | Reset Password Admin</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <a  type="submit"  class="btn btn-block btn-social btn-warning btn-flat"><i class="fa fa-exclamation"></i> Send Password Reset Link </a>

    </form>

        <div class="social-auth-links text-center">
          <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a  href="{{ route('kenalkopi.index') }}" class="btn btn-block btn-social btn-success btn-flat"><i class="fa fa-qrcode"></i> Sign in as
            User using
            Qr Code</a>
          <a  href="{{ route('login') }}" class="btn btn-block btn-social btn-primary btn-flat"><i class="fa fa-lock"></i> Login</a>
        </div>
        </div>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
</body>
@endsection
