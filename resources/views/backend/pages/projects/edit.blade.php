@extends('backend.layouts.app')

@section('title')
Edit Project|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Project</h4>
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
                <form class="form-horizontal" action="{{route('admin.projects.update',$project->id)}}"  method="post">
                        @method('put')
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update Project</h4>
                            <div class="form-group row">
                                 <label for="site" class="col-sm-3 text-right ">Site</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="site" required>
                                                
                                                @foreach ($sites as $site)
                                                <option value="{{ $site->id }}" {{ $site->id == $project->site_id ? 'selected' : '' }}>{{ $site->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group row">

                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Responsible Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="responsible_name" name="responsible_name" placeholder="Enter Name Here" required="" value="{{ $project->responsible_name }}">
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="responsible_phone_no" class=" text-right control-label col-form-label">Responsible Phone No.</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="responsible_phone_no" name="responsible_phone_no" placeholder="Enter Phone Here" value="{{ $project->responsible_phone_no }}">
                                </div>
                                
                            </div>
                            
                     
                                    </div>
                                    <div class="form-group row">
                                        <label for="email1" class="col-sm-3 text-right ">Structure Type</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="st_type" required="">
                                                @foreach ($st_type as $type)
                                                <option value="{{ $type->id }}"{{ $type->id == $project->structure_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{-- </div>
                                    <div class="form-group row"> --}}
                                        <label for="contact" class=" text-right control-label col-form-label">Created By</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="created_by" required>
                                                
                                                @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}" {{ $contact->id == $project->created_by ? 'selected' : '' }}>{{ $contact->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Type</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="width" name="type" placeholder="Old/New" required="" value="{{ $project->type }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Size</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="width" name="size" placeholder="Enter Size Here" required="" value="{{ $project->size }}">
                                        </div>
                                        &nbsp;<p style="color:#143FEF;font-weight: bold ">sqr feet</p>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product Usage Quantity</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="height" name="product_usage_qty" placeholder="Enter Product Quantity" required="" value="{{ $project->product_usage_qty }}">
                                        </div>
                                        &nbsp;<p style="color:#143FEF;font-weight: bold ">Sack</p>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Comment</label>
                                        <div class="col-sm-3">
                                           <textarea name="comment" id="" cols="50" rows="5" placeholder="Comment Hear" >{{ $project->comment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right ">Status</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="status" required="" >
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



      {{--   <script type="text/javascript">
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
        </script> --}}

        @endsection