{{-- Noty -> Notification Style  --}}

@if ($errors->any())
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endif

@if (Session::has('success'))
  <script>
  new Noty({
    theme: 'sunset',
    type: 'success',
    layout: 'topCenter',
    text: "{!! Session::get('success') !!}",
    timeout: 2000
  }).show();
  </script>
@endif

@if (Session::has('error'))
  <script>
  //new Noty({
   // theme: 'sunset',
   // type: 'error',
   // layout: 'topCenter',
   // text: "{!! Session::get('error') !!}",
   // timeout: 2000
  // }).show();
  
  var notify = $.notify("{!! Session::get('error') !!}", {
        type: 'theme',
        allow_dismiss: true,
        delay: 2000,
        timer: 300
    });
  </script>
@endif

@if (Session::has('sticky_error'))
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! Session::get('sticky_error') !!}
      </div>
    </div>
  </div>
@endif

@if (Session::has('db_error'))
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! Session::get('db_error') !!}
      </div>
    </div>
  </div>
@endif

@if (Session::has('sticky_success'))
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! Session::get('sticky_success') !!}
      </div>
    </div>
  </div>
@endif

@if (Session::has('message'))
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-info">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! Session::get('message') !!}
      </div>
    </div>
  </div>
@endif

@if (Session::has('login_error'))
<div class="row justify-content-center mb-3">
    <div class="col-md-12">
        <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! Session::get('login_error') !!}
        </div>
    </div>
</div>
@endif
