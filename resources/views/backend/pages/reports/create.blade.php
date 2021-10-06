@extends('backend.layouts.app')

@section('title')
Create Test Report|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Test Report</h4>
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
                    <form class="form-horizontal" action="{{route('admin.reports.store')}}" method="POST" enctype="multipart/form-data" id="report_form" data-parsley-validate>
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Create New Report</h4>


                            <div class="form-group row  required">
                                <label for="product_id" class="col-sm-3 text-right control-label">Product</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="product_id" data-parsley-required-message="Please select a product" required>
                                        <option value="">Please select Product</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group required row">
                                <label for="year" class="col-sm-3 text-right control-label ">Year</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="year" required="">
                                        <option value="">Please select a Year</option>
                                        @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label for="month" class="col-sm-3 text-right control-label col-form-label">Month</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="month" required="">
                                        <option value="">Please select a Month</option>

                                        @foreach ($months as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="image" class="col-sm-3 text-right control-label">Image</label>
                                <div class="col-sm-3">
                                 <input type="file" id="image" name="image" required="" >
                             </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_id" class="col-sm-3 text-right control-label col-form-label">Title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Here">
                                </div>
                                <div><p style="color:#0B61B7; font-weight: bold">(Optional)-(Title is auto GENERATED.<br>You can also give your own  title).</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_id" class="col-sm-3 text-right control-label col-form-label">Company</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="company" name="company" placeholder="Enter Company Here"><span></span>
                                </div>
                                <div><p style="color:#0B61B7; font-weight: bold">(Optional)</p></div>
                            </div>



                                  <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>&nbsp;&nbsp;&nbsp;
                                    <div class="col-sm-3 row">
                                     <textarea name="description" id="description" cols="50" rows="5" placeholder="Enter Description Here"></textarea>
                                 </div>&nbsp;&nbsp;&nbsp;
                                 <div><p style="color:#0B61B7; font-weight: bold">(Optional)</p></div>
                             </div>

                              <div class="form-group row">
                                <label for="priority" class="col-sm-3 text-right control-label col-form-label">Priority</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="priority" name="priority" placeholder="Enter Priority Number Here" data-parsley-required-message="Please give a priority number" required="">
                                </div><span style="color:#0B61B7; font-weight: bold">(Priority should be serially .<br>1-24 number per year(ex:PC-January=1,PCC-January=2 <br> PC-February=3, PCC-February=4)).</span>
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
        
        </script> 

        @endsection