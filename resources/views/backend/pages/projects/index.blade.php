@extends('backend.layouts.app')

@section('title')
All Project Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row" style="display:block">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Project Entry Lists</h3>
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
                        {{-- {!! Form::open(['url' => action('ReportController@getStockReport'), 'method' => 'get', 'id' =>
                        'new_stock_report_form' ]) !!} --}}
                        {!! Form::open(['url' => action('Backend\ProjectsController@index'), 'method' => 'get', 'id' => 'projects_filter_form' ]) !!}
                     <div class="row">
                          {{-- {{ $sites }} --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('site_id',__('Site') . ':') !!}
                            {!! Form::select('site_id', $sites, null, ['placeholder' => __('All'), 'class' => 'form-control select2','id' => 'site_id', 'style' => 'width:100%']); !!}
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('created_by',__('Visitor') . ':') !!}
                            {!! Form::select('created_by', $contacts, null, ['placeholder' => __('All'), 'class' => 'form-control select2','id' => 'created_by', 'style' => 'width:100%']); !!}
                        </div>
                    </div>
                     <div class="col-md 3">
                         <div class="form-group">
                              <label>Status</label>
                                <select class="form-control" id="status" style="width:100%" >
                            
                                    <option value="0">All</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>

                                </select>
                         </div>
                     </div>

                      <div class="col-md-3">
                      <!--      <div class="form-group">-->
                      <!--          {!! Form::label('projects_filter_range', __('Date Range') . ':') !!}-->
                      <!--          {!! Form::text('projects_filter_range', null, ['placeholder' => __('Date Range'), 'class' => 'form-control', 'readonly']); !!}-->
                      <!--      </div>-->
                        </div>
                </div>   
                    
                        {!! Form::close() !!}
                    </div>
                </div>
                 <div class="text-right">
                   
                      <a  href="{{route('admin.projects.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add New Project</a>  
                    </div>
                    
                    <div style="margin-bottom: 10px;">
                      <a  href="{{route('admin.projects.bulk_approve')}}" style="background-color:#22af47 !important;border-color: #22af47  !important" class="btn btn-primary btn-sm"><i class="fa fa-check"></i>Bulk Approve</a>  
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
            <table class="display" id="projects_table">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Site Name</th>
                        <th>Owner Name</th>
                        <th>Owner Phone</th>
                        <th>Address</th>
                        {{-- <th>Structure Type</th> --}}
                        <th>Project Size</th>
                        <th>Product Usage</th>
                        <th>Comment</th>
                        <th>Visited By</th>
                        <th>Status</th>
                        <th>Visit Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')





<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />-->
<!--<script type="text/javascript">-->

<!--$(function() {-->

<!--    var start = moment().subtract(29, 'days');-->
<!--    var end = moment();-->

<!--    function cb(start, end) {-->
<!--        $('#projects_filter_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));-->
<!--            projects_table.ajax.reload();-->

<!--          $('#projects_filter_range').on('cancel.daterangepicker', function(ev, picker) {-->
<!--        projects_table.ajax.reload();-->
<!--        $('#projects_filter_range').val('');-->
<!--    });-->
<!--    }-->

<!--    $('#projects_filter_range').daterangepicker({-->
<!--        startDate: start,-->
<!--        endDate: end,-->
<!--        ranges: {-->
<!--           'Today': [moment(), moment()],-->
<!--           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],-->
<!--           'Last 7 Days': [moment().subtract(6, 'days'), moment()],-->
<!--           'Last 30 Days': [moment().subtract(29, 'days'), moment()],-->
<!--           'This Month': [moment().startOf('month'), moment().endOf('month')],-->
<!--           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]-->
<!--        }-->
<!--    }, cb);-->

<!--    cb(start, end);-->

<!--});-->
<script>

$('#projects_filter_form #site_id, #projects_filter_form #created_by, #projects_filter_form #status').change(function() {
        project_table.ajax.reload();
    });
    project_table = $('table#projects_table').DataTable({
        dom: 'Blfrtip',  
        processing: true,
        serverSide: true,
        bsearchable:true,
        aaSorting: [
            // [3, 'desc']
        ],
         "ajax": {
            "url": "projects",
            "data": function(d) {
                 d.site_id = $('#site_id').val();
                d.created_by = $('#created_by').val();
                d.status = $('#status').val();
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
                
                d.start_date = start;
                d.end_date = end;
            }
        },
        
        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],
        
        buttons: [
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [  ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [':visible' ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [':visible' ]
                }
            },'colvis'
        ],
        
        columns: [
            { data: 'sitename', name: 'name' },
            { data: 'owner', name: 'owner_name' },
            { data: 'phone', name: 'owner_phone_no' },
            { data: 'address', name: 'address' },
            { data: 'size', name: 'size' },
            { data: 'usage', name: 'product_usage_qty' },
            { data: 'comment', name: 'comment' },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'time', name: 'time' },
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
