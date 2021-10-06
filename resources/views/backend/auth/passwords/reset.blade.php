@extends('backend.auth.master')

@section('stylesheets')
<style>

.bg-login-image {
  background: url("{{ asset('public/admin/img/bg-login-image.png') }}");
  background-position: center;
  background-size: cover;
}
</style>
@endsection

@section('content')
<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Reset Password </h1>
              </div>
              @if (Session::has('status'))
              <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {!! Session::get('status') !!}
              </div>
              @endif
              <form class="user" method="POST" action="{{ route('admin.password.request') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                 <input id="email" type="email" class="form-control form-control-user {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Email Address">

                 @if ($errors->has('email'))
                 <span class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input id="password" type="password" class="form-control form-control-user {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="New Password">

                @if ($errors->has('password'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input id="password-confirm" type="password" class="form-control form-control-user {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required placeholder="Confirm New Password">

                @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
              </div>

              
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Reset Password
              </button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="{{ route('admin.password.request') }}">Forgot Password?</a>

              <br>
              <br>
              <p>©{{ date('Y') }} All Rights Reserved. Hire Gallaxy</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

</div>
@endsection