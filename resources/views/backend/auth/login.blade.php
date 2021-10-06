@extends('backend.auth.auth_master')

@section('title')
Login | Akij CRM
@endsection

@section('login-content')
<div class="authentication-box">

    <div class="card mt-0">
        <div class="card-body">
            <div class="text-center mb-2"><img src="{{ asset('public/img/ARL-full.png') }}" alt="" style="width: 200px;"></div>
            <div class="text-center">
                <h4>LOGIN</h4>
                <h6>Enter your Username and Password </h6>
            </div>
            <form class="theme-form" action="{{ route('admin.login.submit') }}" method="post">
                @csrf
                @include('backend.layouts.partials.messages')
                <div class="form-group">
                    <label class="col-form-label pt-0">Your User Name</label>
                    <input class="form-control" type="text" required="" name="username">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Your Password</label>
                    <input class="form-control" type="password" required="" name="password">
                </div>

                <div class="checkbox p-0">
                    <input id="checkbox1" type="checkbox" name="remember">
                    <label for="checkbox1">Remember me</label>
                </div>

                <div class="form-group form-row mt-3 mb-0">
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </div>

                <div class="form-group form-row mt-3 mb-0 float-right ">
                    <p class="width-100">
                        <a href="{{ route('admin.password.request') }}">Forget Password ?</a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div> <!-- end authentication box -->
@endsection