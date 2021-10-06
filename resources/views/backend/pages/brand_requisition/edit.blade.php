@extends('backend.layouts.app')

@section('title')
Update Brand Requisition|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title ">Brand Requisition</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row" >
            <div class="col-md-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <form class="form-horizontal" action="{{route('admin.brand_requisitions.update',$brand_requisition->id)}}" id="requisition_form" method="POST" enctype="multipart/form-data" >
                        @csrf
                        @method('put')
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update New Requisition</h4>
                           
                        
                            @include('backend.layouts.partials.messages')
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                        <label for="district" class="text-right control-label ">Shop</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="shop_id" required="">
                                                <option >Shop 1</option>
                                                <option >Shop 2</option>
                                                <option>Shop 3</option>
                                               {{--  @foreach ($district as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="district" class="text-right control-label ">Item</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="item_id" required="">
                                                @foreach ($items as $item)
                                        <option value="{{ $item->id }}" {{ $item->id==$brand_requisition->item_requisition_id ? 'selected' :'' }}>{{ $item->name}}</option>
                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group required">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Quantity</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="quantity" value="{{ $brand_requisition->quantity }}" name="quantity" placeholder="Enter Quantity Here" required="">
                                    </div>
                                </div>

                                <div class="form-group required">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Size</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="size" value="{{ $brand_requisition->size }}" name="size" placeholder="Enter Size in Inches" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                        <label for="district" class="text-right ">Employee<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="employee_id">
                                                <option value="1">Abir</option>
                                                <option value="1">Akash</option>
                                                <option value="1">Farid</option>
                                                <option value="1">Rafiul</option>
                                                {{-- @foreach ($district as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="district" class="text-right ">Item Type</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="item_type">
                                                <option >POSM</option>
                                                <option >Others</option>
                                                {{--@foreach ($district as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach--}}
                                            </select>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                    <label for="image" class="text-right control-label col-form-label">Old Image</label>
                                    <div class="col-sm-8 ">
                                        <a class="dropdown-item" href="#showModal{{ $brand_requisition->id }}" data-toggle="modal"><img class="report-min-img" src="{{ url('public/img/brand_requisition/'.$brand_requisition->image) }}"></a>
                                    </div>
                                 </div>

                                    <div class="form-group">
                                    
                                    <label for="image" class="text-right control-label col-form-label">Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Comment<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                    <div class="col-sm-8">
                                        <textarea  class="form-control" id="comment" value="" name="comment">{{ $brand_requisition->comment }}</textarea>
                                    </div>
                                    </div>

                                    <div class="modal fade delete-modal" id="showModal{{ $brand_requisition->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Brand Requisition Information-{{ $brand_requisition->item_type }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="modal-max-img" src="{{ url('public/img/brand_requisition/'.$brand_requisition->image) }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    
                                   
                                </div>
                            </div>
                                    <div class="border-top">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                     </div>
                                </div>
                             </form>
                         </div> 
                    </div>
                </div>
            </div>

        @endsection


@section('scripts')
<script type="text/javascript">
$(function () {
  $('#requisition_form').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    return true; 
  });
});
</script> 
@endsection