@extends('backend.layouts.app')

@section('title')
Edit Site|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Site</h4>
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
    <div class="container-fluid">
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <form class="form-horizontal" action="{{route('admin.sites.update',$sites->id)}}" method="POST" >
                    	@method('put')
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update Site</h4>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Site Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $sites->name }}" placeholder="Enter Site Name Here" required="">
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="name" class=" text-right control-label col-form-label">Unit Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="unit" name="unit" placeholder="Enter Site Name Here">
                                </div>
                                
                            </div>
                            
                     
                                    </div>
                                    <div class="form-group row">
                                        <label for="email1" class="col-sm-3 text-right ">Structure Type</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="st_type" required="">
                                               <option value="{{ $sites->structure->id }}">{{ $sites->structure->name }}</option> 
                                                @foreach ($st_type as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{-- </div>
                                    <div class="form-group row"> --}}
                                        <label for="contact" class=" text-right control-label col-form-label">Created By</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="created_by" required="">
                                                <option value="{{ $sites->createdBy->id }}">{{ $sites->createdBy->name }}</option>
                                                
                                                @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Owner Name</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="width" name="owner_name" value="{{ $sites->owner_name }}" placeholder="Enter Owner Name Here" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Owner Phone No.</label>
                                        <div class="col-sm-3">
                                          <input type="text" class="form-control" id="height" value="{{ $sites->owner_phone_no }}" name="owner_phone_no" placeholder="Enter Owner Phone No Here" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="column" value="{{ $sites->address }}" name="address" placeholder="Enter Address Here" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right ">Status</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="status" required="">
                                                <option value="1">Approved</option>
                                                <option value="0">Pending</option>
                                            </select>
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

        @endsection


        @section('scripts') 



        <script type="text/javascript">
                $('#addform').on('submit',function(e){
                    e.preventDefault();

                    $.ajax({
                        type:"POST",
                        url:"/admin/products/imagesize/store",
                        data: $('#addform').serialize(),
                        success: function(response){
                            console.log(response)
                            jQuery.noConflict();
                            $('#studentaddmodal').modal('hide')
                            alert("Data Saved");
                        },
                        error: function(error){
                            console.log(error)
                            alert("Data Not Saved");
                        }
                    });
                });
        </script>

        @endsection