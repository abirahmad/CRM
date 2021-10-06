@extends('backend.layouts.app')

@section('title')
Create Survey|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Survey</h4>
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
                    <form class="form-horizontal" action="{{route('admin.surveys.store')}}" method="POST" id="survey_form" >
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Create New Survey</h4>
                            <div class="form-group required row">
                                <label for="title" class="col-sm-3 text-right control-label col-form-label">Survey title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Survey title Here" required="">
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label for="link" class="col-sm-3 text-right control-label col-form-label">Survey link</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="link" name="link" placeholder="Enter Survey Link Here" required="">
                                </div>
                            </div>
                            <div class="form-group required row">
                                <label for="contact" class="col-sm-3 text-right control-label col-form-label">Created By</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="created_by" required="">
                                        <option value="">Please select a Name</option>
                                        
                                        @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                        @endforeach
                                    </select>
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

<script type="text/javascript">
    $(function () {
        $('#survey_form').parsley().on('field:validated', function() {
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