@extends('backend.layouts.app')

@section('title')
Edit Video|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Video</h4>
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
                    <form class="form-horizontal" action="{{route('admin.videos.update',$videos->id)}}" method="POST" >
                    	@method('put')
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update video</h4>
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 text-right control-label col-form-label">Video title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $videos->title }}" placeholder="Enter video title here" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-sm-3 text-right control-label col-form-label">Video link</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="link" name="link" value="{{ $videos->link }}" placeholder="Enter video link here" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration" class="col-sm-3 text-right control-label col-form-label">Video duration</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{ $videos->duration }}" placeholder="Enter Video duration here" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-3 text-right control-label col-form-label">Video Thumbnail Image</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="image" name="image" value="{{ $videos->image }}" placeholder="Enter video thumbnail image link here" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="contact" class="col-sm-3 text-right control-label col-form-label">Created By</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="created_by" required="">
                                        <option value="{{ $videos->createdBy->id }}">{{ $videos->createdBy->name }}</option>
                                        @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                        @endforeach
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