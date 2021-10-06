<!-- latest jquery-->
<script src="{{ asset('public/backend/js/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('public/backend/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('public/backend/js/bootstrap/bootstrap.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('public/backend/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('public/backend/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('public/backend/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('public/backend/js/config.js') }}"></script>
<!-- Plugins JS start-->

<!-- Chart JS -->
{{--  <script src="{{ asset('public/backend/js/chart/chartist/chartist.js') }}"></script>
<script src="{{ asset('public/backend/js/chart/knob/knob.min.js') }}"></script>
<script src="{{ asset('public/backend/js/chart/knob/knob-chart.js') }}"></script> --}}
<!-- Chart JS -->

<script src="{{ asset('public/backend/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('public/backend/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('public/backend/js/noty/noty.min.js') }}"></script>
<script src="{{ asset('public/backend/js/counter/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('public/backend/js/counter/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('public/backend/js/counter/counter-custom.js') }}"></script>
<script src="{{ asset('public/backend/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('public/backend/js/notify/bootstrap-notify.min.js') }}"></script>
{{--  <script src="{{ asset('public/backend/js/dashboard/default.js') }}"></script> --}}
{{-- <script src="{{ asset('public/backend/js/notify/index.js') }}"></script> --}}

<!-- Data Tables -->
<script src="{{ asset('public/backend/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>

<!-- Parsley JS For Validation -->
<script src="{{ asset('public/backend/js/parsley/parsley.min.js') }}"></script>

<!-- Select2 Js For Multiple -->
<script src="{{ asset('public/backend/js/select2/select2.min.js') }}"></script>

{{--  <script src="{{ asset('public/backend/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('public/backend/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('public/backend/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('public/backend/js/chat-menu.js') }}"></script>
<script src="{{ asset('public/backend/js/height-equal.js') }}"></script> --}}
<script src="{{ asset('public/backend/js/tooltip-init.js') }}"></script>
{{--  <script src="{{ asset('public/backend/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('public/backend/js/typeahead-search/typeahead-custom.js') }}"></script> --}}

<!-- Theme js-->
<script src="{{ asset('public/backend/js/script.js') }}"></script>
<!-- <script src="{{ asset('public/backend/js/theme-customizer/customizer.js') }}"></script> -->
<!-- Plugin used-->

<!-- Common JS -->

<script src="{{ asset('public/backend/js/custom.js') }}"></script>
<!-- Common JS -->

<!-- Data table -->
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>

<script>
    $('.select2').select2();
</script>
<style>
    .dataTables_wrapper button {
        padding: 5px 8px !important;
        border-radius: 0px !important;
        color: #fff !important;
        background: #2f3c4e !important;
        font-size: 15px;
        margin: 5px 5px 10px;
        border: none !important;
        cursor: pointer !important;
    }
    .dt-button-collection {
        margin-top: -5px !important;
    }
</style>

@include('backend.layouts.partials.flash-messages')