<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Akij Resource CRM - Admin Panel">
  <meta name="keywords" content="Akij Resource CRM - Admin Panel">
  <meta name="author" content="Akij Resource Ltd.">

  <link rel="icon" href="public/img/ARL-main.png" type="image/x-icon">
  <link rel="shortcut icon" href="public/img/ARL-main.png" type="image/x-icon">
  <title>@yield('title', 'Akij Resource CRM - Admin Panel')</title>

  @include('backend.layouts.partials.styles')
  @yield('styles')
</head>

<body>

  @include('backend.layouts.partials.loader')

  <!-- page-wrapper Start-->
  <div class="page-wrapper">
    @include('backend.layouts.partials.header')
    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      @include('backend.layouts.partials.sidebar')
      @include('backend.layouts.partials.sidebar-right')

      <div class="page-body">

        <div class="container-fluid">
          @yield('top-content')
        </div>

        <!-- Container-fluid starts-->

        <div class="container-fluid">
          @yield('admin-content')
        </div>
        <!-- Container-fluid Ends-->


      </div>
      @include('backend.layouts.partials.footer')
    </div>
  </div>
  @include('backend.layouts.partials.scripts')
  @yield('scripts')
</body>

</html>