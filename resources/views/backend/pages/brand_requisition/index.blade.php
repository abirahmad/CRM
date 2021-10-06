@extends('backend.layouts.app')

@section('title')
All Brand Requisition Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Brand Requisition Lists</h3>
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
                                    {{-- {{ dd($item_type) }} --}}
                                    {!! Form::label('item_type',__('Item Type') . ':') !!}
                                    
                                    <select name="item_type" class="form-control select2" id="item_type">
                                        <option value="">All</option>
                                        @foreach($item_type as $item_type)
                                            <option value="{{ $item_type }}">{{ $item_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('item_requisition',__('Item') . ':') !!}

                                    <select name="items" class="form-control select2" id="item">
                                        <option value="">All</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                 <div class="text-right">
                   
                      <a  href="{{route('admin.brand_requisitions.create')}}" class="btn btn-primary btn-sm-report"><i class="fa fa-plus"></i>Add New Requisition</a>  
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
            <table class="table table-bordered table-striped ajax_view" id="brand_requisition">
                <thead>
                    <tr>
                        <th>Shop</th>
                        <th>Item</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Image</th>
                        <th>Comment</th>
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
$('#test_report_filter_form #item_type, #test_report_filter_form #item').change(function() {
    // alert('serching');
        brand_requisition.ajax.reload();
    });
    brand_requisition = $('table#brand_requisition').DataTable({
        dom: 'Blfrtip',  
        processing: true,
        serverSide: true,
        searchable:true,
        aaSorting: [
            // [3, 'desc']
        ],
         "ajax": {
            "url": "brand_requisitions",
            "data": function(d) {
                 d.item_type = $('#item_type').val();
                d.item = $('#item').val();

            }

           
        },
        columnDefs: [{
        //     "targets": [7, 8],
        //     // "orderable": false,
        //     // "searchable": false
        }],
        
        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],
        
        //  buttons: [
        //     'excel', 'pdf', 'print'
        // ],
        
        columns: [
            { data: 'shop_id', name: 'shop_id' },
            { data: 'item', name: 'item_requisitions.name' },
            { data: 'item_type', name: 'item_type' },
            { data: 'quantity', name: 'quantity' },
            { data: 'size', name: 'size' },
            { data: 'image', name: 'image' },
            { data: 'comment', name: 'comment' },
            { data: 'action', name: 'action' }
        ],
       
    });
  

</script>


@endsection