@extends('backend.layouts.app')

@section('title')
All Test Report Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Test Report Lists</h3>
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
                      
                        {!! Form::open(['url' => action('Backend\TestReportsController@index'), 'method' => 'get', 'id' => 'test_report_filter_form' ]) !!}
                         <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('year',__('Select Year') . ':') !!}
                                    
                                    <select name="year" class="form-control select2" id="year">
                                        <option value="">All</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('month',__('Select Month') . ':') !!}

                                    <select name="month" class="form-control select2" id="month">
                                        <option value="">All</option>
                                        @foreach($months as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                 <div class="text-right">
                   
                      <a  href="{{route('admin.reports.create')}}" class="btn btn-primary btn-sm-report"><i class="fa fa-plus"></i>Add New Report</a>  
                    </div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="table-responsive product-table">
            <table class="display" id="reports_table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Institution</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Product</th>
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
$(document).on('click', 'button.delete_category_button', function(){
        swal({
          title: LANG.sure,
          text: "LANG.confirm_delete_category",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var href = $(this).data('href');
                var data = $(this).serialize();

                $.ajax({
                    method: "DELETE",
                    url: href,
                    dataType: "json",
                    data: data,
                    success: function(result){
                        if(result.success === true){
                            toastr.success(result.msg);
                            report_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

$('#test_report_filter_form #year, #test_report_filter_form #month').change(function() {
    // alert('serching');
        report_table.ajax.reload();
    });
    report_table = $('table#reports_table').DataTable({
        dom: 'Blfrtip',  
        processing: true,
        serverSide: true,
        searchable:true,
        aaSorting: [
            // [3, 'desc']
        ],
         "ajax": {
            "url": "reports",
            "data": function(d) {
                 d.year = $('#year').val();
                d.month = $('#month').val();

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
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image' },
            { data: 'company', name: 'company' },
            { data: 'month', name: 'month' },
            { data: 'year', name: 'year' },
            { data: 'name', name: 'products.name' },
            { data: 'action', name: 'action' },
        ],
       
    });
  

</script>


@endsection