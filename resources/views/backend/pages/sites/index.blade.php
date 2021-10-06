@extends('backend.layouts.app')

@section('title')
All Site Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Site Lists</h3>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
 <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" id="accordion">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                            <i class="fa fa-filter" aria-hidden="true">Filters</i>
                        </a>
                    </h3>
                </div>
                <div id="collapseFilter" aria-expanded="true">
                    <div class="box-body">
                      
                        {!! Form::open(['url' => action('Backend\SitesController@index'), 'method' => 'get', 'id' => 'projects_filter_form' ]) !!}
                     <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('st_type',__('Structure Type') . ':') !!}
                            {!! Form::select('st_type', $types, null, ['placeholder' => __('All'), 'class' => 'form-control select2','id' => 'st_type', 'style' => 'width:100%']); !!}
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('created_by',__('Visitor') . ':') !!}
                            {!! Form::select('created_by', $contacts, null, ['placeholder' => __('All'), 'class' => 'form-control select2','id' => 'created_by', 'style' => 'width:100%']); !!}
                        </div>
                    </div>
                     

                      <!--<div class="col-md-3">-->
                      <!--      <div class="form-group">-->
                      <!--          {!! Form::label('projects_filter_range', __('Date Range') . ':') !!}-->
                      <!--          {!! Form::text('projects_filter_range', null, ['placeholder' => __('Date Range'), 'class' => 'form-control', 'readonly']); !!}-->
                      <!--      </div>-->
                      <!--  </div>-->
                </div>
              
                    
                        {!! Form::close() !!}
                    </div>
                </div>
                  <div class="text-right">
                   
                      <a  href="{{route('admin.sites.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add New Site</a>  
                    </div>   
            </div>
        </div>
    </div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="table-responsive product-table">
            <table class="display" id="sites_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th width="20%">First Visit</th>
                        <th>Address / Information</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
// <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
// <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
// <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
// <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
// <script type="text/javascript">

// $(function() {

//     var start = moment().subtract(29, 'days');
//     var end = moment();

//     function cb(start, end) {
//         $('#projects_filter_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
//             projects_table.ajax.reload();

//           $('#projects_filter_range').on('cancel.daterangepicker', function(ev, picker) {
//         projects_table.ajax.reload();
//         $('#projects_filter_range').val('');
//     });
//     }

//     $('#projects_filter_range').daterangepicker({
//         startDate: start,
//         endDate: end,
//         ranges: {
//           'Today': [moment(), moment()],
//           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//           'This Month': [moment().startOf('month'), moment().endOf('month')],
//           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//         }
//     }, cb);

//     cb(start, end);

// });

$('#projects_filter_form #st_type, #projects_filter_form #created_by').change(function() {
    // alert('serching');
        site_table.ajax.reload();
    });
    site_table = $('table#sites_table').DataTable({
        dom: 'Blfrtip',  
        processing: true,
        serverSide: true,
        searchable:true,
        aaSorting: [
            // [3, 'desc']
        ],
         "ajax": {
            "url": "sites",
            "data": function(d) {
                 d.st_type = $('#st_type').val();
                d.created_by = $('#created_by').val();
                var start = "";
                var end = "";
                if ($('#projects_filter_range').val()) {
                    start = $('input#projects_filter_range')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#projects_filter_range')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');

                }
                // if ($('#projects_filter_range').val()) {
                //  $('#projects_filter_range').daterangepicker({
                //     start_date: start,
                //     endDate: end,
                //     ranges: {
                //    'Today': [moment(), moment()],
                //    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                //    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                //    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                //    'This Month': [moment().startOf('month'), moment().endOf('month')],
                //    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                //         }
                //     }

                // }
                
                // console.log(data(daterangepicker())
                d.start_date = start;
                d.end_date = end;
                // projects_table.ajax.reload();
            }
        },
        // columnDefs: [{
        //     "targets": [7, 8],
        //     // "orderable": false,
        //     // "searchable": false
        // }],
        
        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],
        
        //  buttons: [
        //     'excel', 'pdf', 'print'
        // ],
        
        columns: [
            { data: 'sitename', name: 'sites.name' },
            { data: 'name', name: 'name' },
            { data: 'owner', name: 'owner_name' },
            { data: 'action', name: 'action' },
            
           
          

        ],
       
    });

    //   $('#projects_filter_range').daterangepicker(
    //     dateRangeSettings,
    //     function (start, end) {
    //         $('#projects_filter_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
    //        projects_table.ajax.reload();
    //     }
    // );
    // $('#projects_filter_range').on('cancel.daterangepicker', function(ev, picker) {
    //     projects_table.ajax.reload();
    //     $('#projects_filter_range').val('');
    // });
  

</script>
@endsection