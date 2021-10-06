@extends('backend.layouts.app')

@section('title')
Create Brand Requisition|
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
                    <form class="form-horizontal" action="{{route('admin.brand_requisitions.store')}}" method="POST" id="requisition_form" enctype="multipart/form-data" >
                        @csrf
                        @method('post')
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Create New Requisition</h4>
                           
                        
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group required">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Quantity</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="quantity" value="" name="quantity" placeholder="Enter Quantity Here" required="">
                                    </div>
                                </div>

                                <div class="form-group required">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Size</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="size" value="" name="size" placeholder="Enter Size in Inches" required="">
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

                                    <div class="form-group required">
                                    
                                    <label for="image" class="text-right control-label col-form-label">Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" id="image" name="image" required="">
                                    </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Comment<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                    <div class="col-sm-8">
                                        <textarea  class="form-control" id="comment" value="" name="comment"></textarea>
                                    </div>
                                    </div>

                                    
                                   
                                </div>
                            </div>
                                    <div class="border-top">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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