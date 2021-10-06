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
  new Noty({
      theme: 'sunset',
      type: 'error',
      layout: 'topCenter',
      text: "{!! Session::get('error') !!}",
      timeout: 2000
    }).show();
</script>
@endif