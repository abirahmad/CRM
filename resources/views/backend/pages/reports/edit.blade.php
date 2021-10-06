@extends('backend.layouts.app')

@section('title')
Edit Test Report|
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
                    <form class="form-horizontal" action="{{route('admin.reports.update',$reports->id)}}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update Test Report</h4>


                            <div class="form-group row">
                                <label for="product_id" class="col-sm-3 text-right ">Product</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="product_id" required="">
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id==$reports->product_id ? 'selected' :'' }}>{{ $product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="year" class="col-sm-3 text-right ">Year</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="year" required="">
                                        <option value="{{$reports->year }}"}} >{{ $reports->year}}</option>
                                        @foreach ($years as $year)
                                        <option value="{{$year }}"}} >{{ $year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="month" class="col-sm-3 text-right control-label col-form-label">Month</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="month" required="">
                                        <option value="{{$reports->month }}"}} >{{ $reports->month}}</option>
                                        @foreach ($months as $month)
                                        <option value="{{$month }}" >{{ $month}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_id" class="col-sm-3 text-right control-label col-form-label">Title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $reports->title }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_id" class="col-sm-3 text-right control-label col-form-label">Institution</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="company" name="company" value="{{ $reports->company }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 text-right control-label">Old Image</label>
                                <div class="col-sm-3 ">
                                    <a class="dropdown-item" href="#showModal{{ $reports->id }}" data-toggle="modal"><img class="report-min-img" src="{{ url('public/img/reports/'.$reports->image) }}"></a>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-3 text-right control-label">Image</label>
                                <div class="col-sm-3">
                                 <input type="file" id="image" name="image" >
                             </div>
                         </div>

                             <div class="modal fade delete-modal" id="showModal{{ $reports->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Test Report-{{ $reports->month }}-{{ $reports->year }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="modal-max-img" src="{{ url('public/img/reports/'.$reports->image) }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                   <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>&nbsp;&nbsp;&nbsp;
                                    <div class="col-sm-3 row">
                                     <textarea name="description" id="description" cols="50" rows="5" placeholder="Enter Description Here">{{$reports->description}}</textarea>
                                 </div>&nbsp;&nbsp;&nbsp;
                                 <div><p style="color:#0B61B7; font-weight: bold">(Optional)</p></div>
                             </div>

                               <div class="form-group row">
                                <label for="priority" class="col-sm-3 text-right control-label col-form-label">Priority</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="priority" name="priority" placeholder="Enter Priority Number Here" value="{{ $reports->priority }}">
                                </div><span style="color:#0B61B7; font-weight: bold">(Priority should be serially .<br>1-24 number per year(ex:PC-January=1,PCC-January=2 <br> PC-February=3, PCC-February=4)).</span>
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