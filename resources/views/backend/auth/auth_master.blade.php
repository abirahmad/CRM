<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Akij CRM - Admin Panel">
  <meta name="keywords" content="Akij CRM - Admin Panel">
  <meta name="author" content="Akij Group">

  <link rel="icon" href="public/img/ARL-main.png" type="image/x-icon">
  <link rel="shortcut icon" href="public/img/ARL-main.png" type="image/x-icon">

  <title>@yield('title', 'Akij Resource CRM - Admin Panel Login')</title>

  @include('backend.layouts.partials.styles')
  <style>
    .page-wrapper .page-body-wrapper .page-body {
      margin-top: 0px;
      padding: 0px;
    }
  </style>
</head>

<body>

  @include('backend.layouts.partials.loader')

  <!-- page-wrapper Start-->
  <div class="page-wrapper">

    <!-- Page Body Start-->
    <div class="page-body-wrapper">


      <div class="page-body">

        <div class="container-fluid">
          @yield('top-content')
        </div>
        <!-- login page start-->
        <div class="authentication-main">
          <div class="row">
            <div class="col-md-12">
              <div class="auth-innerright">
                @yield('login-content')
              </div>
            </div>
          </div>
          <!-- login page end-->
        </div>
      </div>
    </div>
  </div>
  @include('backend.layouts.partials.scripts')
  @include('backend.layouts.partials.flash-messages')
</body>

</html>