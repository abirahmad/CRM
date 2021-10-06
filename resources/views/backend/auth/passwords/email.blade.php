@extends('backend.auth.auth_master')

@section('title')
Forget Password | Akij CRM
@endsection

@section('login-content')
<div class="authentication-box">

  <div class="card mt-0">
    <div class="card-body">
      <div class="text-center mb-2"><img src="{{ asset('public/backend/images/logo-sm.png') }}" alt=""></div>
      <div class="text-center">
        <h4>Forget Password</h4>
      </div>
      <form class="theme-form" action="{{ route('admin.password.email') }}" method="post">
        @csrf
        @include('backend.layouts.partials.messages')
        @if (Session::has('success'))
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {!! Session::get('success') !!}
            </div>
          </div>
        </div>
        @endif
        <div class="form-group">
          <input class="form-control" type="text" name="email" id="email" required
            placeholder="Enter your email address">
        </div>

        <div class="form-group form-row mt-3 mb-0">
          <button class="btn btn-primary btn-block" type="submit">
            Send Password Reset Link
          </button>
        </div>

        <div class="form-group form-row mt-3 mb-0 float-right ">
          <p class="width-100">
            <a href="{{ route('admin.login') }}">Check Login</a>
          </p>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div> <!-- end authentication box -->
@endsection