@extends('backend.layouts.app')

@section('title')
Create Contact|
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('admin-content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title ">Contact</h4>
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
                    <form class="form-horizontal" action="{{route('admin.contacts.store')}}" method="POST" id="contacts_form" >
                        @csrf
                        @method('post')
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Create New Contact</h4>
                           
                        
                            @include('backend.layouts.partials.messages')
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required ">

                                <label for="name" class="text-right control-label ">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Enter Name Here" required="">
                            </div>
                                
                              </div>
                                
                                <div class="form-group required">
                                        
                                    <label for="email" class="text-right control-label col-form-label">Email</label>
                                   <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" value="" placeholder="Enter Email Here" required>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    
                                    <label for="phone_no" class="text-right control-label col-form-label">Phone No.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit" name="phone_no" value="" placeholder="Enter Phone Here" required="">
                                    </div>
                                 </div>
                                 <div class="form-group required">
                                    
                                    <label for="designation" class=" text-right control-label col-form-label">Designation</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="designation" value="Engineer" name="designation" placeholder="Enter Designation Here" required="">
                                    </div>
                                 </div>
                                 
                                 <div class="form-group required">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Office Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="office_name" value="" name="office_name" placeholder="Enter Office Name Here" required="">
                                    </div>
                                 </div>
                                 <div class="form-group required">
                                    
                                    <label for="office_address" class=" text-right control-label col-form-label">Office Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="office_address" value="" name="office_address" placeholder="Enter Office Address Here" required="">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                 <label for="language" class="text-right ">Language</label><br>
                                       <div class="col-sm-8">
                                            <select class="form-control " name="language" required="">
                                                <option value="en">English</option>
                                                <option value="bn">Bangla</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    
                                    <label for="fb-address" class=" text-right control-label col-form-label">Face Book Address<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit" name="fb_address" value="" placeholder="Enter Facebook Address Here">
                                    </div>
                                 </div>
                                 
                                    <div class="form-group">
                                    
                                    <label for="birthdate" class="text-right control-label col-form-label">Birth Date<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                   <div class="col-sm-8">
                                        <input id="datepicker1" value="" name="birthdate" width="400" />
                                    </div>
                                  </div>

                                    <div class="form-group required">
                                        <label for="password" class=" col-form-label text-md-right control-label">{{ __('Password') }}</label>

                                        <div class="col-sm-8">
                                            <input id="password" type="password" class="form-control" name="password" value="akijcement" required autocomplete="new-password" placeholder="Enter Password">
                                            <label>akijcement</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="form-group required">
                                        <label class="control-label" >Confirm Password</label>
                                        <input class="form-control btn-square" name="password_confirmation"id="password_confirmation" value="akijcement" type="password" placeholder="Type Confirm Password" required>
                                    </div>
                                </div>
                                 
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                        <label for="district" class="text-right ">District<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="district_id">
                                                <option value="">Please Select</option>
                                                @foreach ($district as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upazilla" class=" text-right ">Upazilla (thana)<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="upazila">
                                                <option value="">Please Select</option>
                                               @foreach ($upazilla as $upazilla)
                                                <option value="{{ $upazilla->id }}">{{ $upazilla->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group required">
                                        <label for="contact" class=" text-right control-label col-form-label">Contact Type</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="contact_type_id" required="" >
                                                @foreach ($contact_type as $contact_type)
                                                <option value="{{ $contact_type->id }}">{{ $contact_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   
                                   <div class="form-group">
                                        <label for="marital_status" class="col-form-label text-md-right">Married</label>
                                        <div class="col-sm-8">
                                            <select name="marital_status" id="marital_status" class="form-control">
                                                <option value="1">Married</option>
                                                <option value="0">Unmarried</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="marital-div">
                                        <div class="form-group">
                                            <label for="wife_name" class="col-form-label text-md-right">Wife Name<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
    
                                            <div class="col-sm-8">
                                                <input id="wife_name" value="" type="text" class="form-control" name="wife_name"placeholder="Enter Wife's Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="wife_marriage_date" class=" col-form-label text-md-right">Enter Marriage Date<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
    
                                            <div class="col-sm-8">
                                                <input id="datepicker4" value="" name="wife_marriage_date" width="400" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="child1_name" class="col-form-label text-md-right">Child Name 1<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                            <div class="col-sm-8">
                                                <input id="child1_name-confirm" type="text" class="form-control" value="" name="child1_name" placeholder="Enter Child Name ">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="child1_birthdate" class=" col-form-label text-md-right">Child1 Birthdate<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                            <div class="col-sm-8">
                                                <input id="datepicker2" value="" name="child1_birthdate" width="400" />
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="password-confirm" class="col-form-label text-md-right">Child Name 2<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>
                                           <div class="col-sm-8">
                                                <input id="child2_name" value="" type="text" class="form-control" name="child2_name"placeholder="Enter Child Name">
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="child2_birthdate" class="col-form-label text-md-right">Child2 Birthdate<span style="color:#0B61B7; font-weight: bold">(Optional)</span></label>

                                            <div class="col-sm-8">
                                                <input id="datepicker3" value="" name="child2_birthdate" width="400" />
                                            </div>
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script>

    $("#marital_status").change(function(){
        let marital_status = $(this).val();
        if(marital_status == 0){
            $("#marital-div").hide();
        }else{
            $("#marital-div").show();
        }
    });
    
</script>

    <script>
         $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });
         $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'
        });
         $('#datepicker3').datepicker({
            uiLibrary: 'bootstrap4'
        });
         $('#datepicker4').datepicker({
            uiLibrary: 'bootstrap4'
        });
         $('#datepicker5').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
<script type="text/javascript">
$(function () {
  $('#contacts_form').parsley().on('field:validated', function() {
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