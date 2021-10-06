@extends('backend.layouts.app')

@section('title')
Edit Contact|
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
                    <form class="form-horizontal" action="{{route('admin.contacts.update',$contacts->id)}}" method="POST" >
                        @csrf
                        @method('put')
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">Update Contact</h4>
                           
                        
                            @include('backend.layouts.partials.messages')
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">

                                <label for="name" class="text-right control-label ">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $contacts->name }}" placeholder="Enter Name Here" required="">
                            </div>
                                
                              </div>
                                <div class="form-group">
                                        
                                    <label for="name" class="text-right control-label col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit" name="username" value="{{ $contacts->username }}" placeholder="Enter Username Here">
                                    </div>
                                </div>
                                <div class="form-group">
                                        
                                    <label for="email" class="text-right control-label col-form-label">Email</label>
                                   <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $contacts->email }}" placeholder="Enter Email Here">
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                    <label for="phone_no" class="text-right control-label col-form-label">Phone No.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit" name="phone_no" value="{{ $contacts->phone_no }}" placeholder="Enter Phone Here">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    
                                    <label for="fb-address" class=" text-right control-label col-form-label">Face Book Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit" name="fb_address" value="{{ $contacts->fb_address }}" placeholder="Enter Facebook Address Here">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    
                                    <label for="designation" class=" text-right control-label col-form-label">Designation</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="designation" value="{{ $contacts->designation }}" name="designation" placeholder="Enter Designation Here">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    
                                    <label for="office_name" class="text-right control-label col-form-label">Office Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="office_name" value="{{ $contacts->office_name }}" name="office_name" placeholder="Enter Office Name Here">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    
                                    <label for="office_address" class=" text-right control-label col-form-label">Office Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="office_address" value="{{ $contacts->office_address }}" name="office_address" placeholder="Enter Office Address Here">
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
                                    
                                    <label for="birthdate" class="text-right control-label col-form-label">Birth Date.</label>
                                   <div class="col-sm-8">
                                        <input id="datepicker1" value="{{ $contacts->birthdate }}" name="birthdate" width="400" />
                                    </div>
                                  </div>

                                    <div class="form-group">
                                        <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-sm-8">
                                            <input id="password" type="password" class="form-control" value="" name="password" autocomplete="new-password" placeholder="Enter Password">

                                                <span class="invalid-feedback" role="alert">
                                                    >
                                                </span>
                                        </div>
                                    </div>
                                 
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                        <label for="district" class="text-right ">District</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="district_id" required="">
                                                @foreach ($district as $district)
                                                <option value="{{ $district->id }}" {{ $district->id == $contacts->district_id ? 'selected' : '' }}>{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upazila" class=" text-right ">Upazila</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="upazilla_id" required="">
                                               @foreach ($upazilla as $upazilla)
                                                <option value="{{ $upazilla->id }}" {{ $upazilla->id == $contacts->upazilla_id ? 'selected' : '' }}>{{ $upazilla->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact" class=" text-right control-label col-form-label">Contact Type</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="contact_type_id" required="">
                                                @foreach ($contact_type as $contact_type)
                                                <option value="{{ $contact_type->id }}" {{ $contact_type->id == $contacts->contact_type_id ? 'selected' : '' }}>{{ $contact_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="marital_status" class="col-form-label text-md-right">Married</label>
                                        <div class="col-sm-8">
                                            <select name="marital_status" id="marital_status" class="form-control">
                                                <option value="1" {{ $contacts->marital_status == 1 ? 'selected' : '' }}>Married</option>
                                                <option value="0" {{ $contacts->marital_status == 0 ? 'selected' : '' }}>Unmarried</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                            <div id="marital-div">
                                
                                    <div class="form-group">
                                        <label for="wife_name" class="col-form-label text-md-right">Wife Name</label>

                                        <div class="col-sm-8">
                                            @if($contactReferenceWife != null)
                                            <input id="wife_name" value="{{ $contactReferenceWife->name }}" type="text" class="form-control" name="wife_name"placeholder="Enter Wife's Name">
                                            @else
                                            <input id="wife_name" value="" type="text" class="form-control" name="wife_name"placeholder="Enter Wife's Name">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="wife_marriage_date" class=" col-form-label text-md-right">Enter Marriage Date</label>

                                        <div class="col-sm-8">
                                             @if($contactReferenceWife != null)
                                            <input id="datepicker4" value="{{$contactReferenceWife->marriage_date  }}" name="wife_marriage_date" width="400" />
                                            @else
                                            <input id="datepicker4" value="" name="wife_marriage_date" width="400" />
                                            @endif
                                        </div>
                                    </div>
                                    
                                <div class="form-group">
                                        <label for="child1_name" class="col-form-label text-md-right">Child Name 1</label>
                                   
                                        <div class="col-sm-8">
                                            @if($contactReferencesChild1 != null)
                                            <input id="child1_name-confirm" type="text" class="form-control" value="{{ $contactReferencesChild1->name }}" name="child1_name" placeholder="Enter Child Name ">
                                            @else
                                            <input id="child1_name-confirm" type="text" class="form-control" value="" name="child1_name" placeholder="Enter Child Name ">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="child1_birthdate" class=" col-form-label text-md-right">Child1 Birthdate</label>

                                        <div class="col-sm-8">
                                            @if($contactReferencesChild1 != null)
                                            <input id="datepicker2" value="{{ $contactReferencesChild1->birthdate }}" name="child1_birthdate" width="400" />
                                            @else
                                            <input id="datepicker2" value="" name="child1_birthdate" width="400" />
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="col-form-label text-md-right">Child Name 2</label>

                                       <div class="col-sm-8">
                                        @if($contactReferencesChild2Data != null)
                                            <input id="child2_name" value="{{ $contactReferencesChild2Data->name }}" type="text" class="form-control" name="child2_name"placeholder="Enter Child Name">
                                            @else
                                            <input id="child2_name" value="" type="text" class="form-control" name="child2_name"placeholder="Enter Child Name">
                                            @endif
                                        </div>
                                    </div>
                                        
                                    <div class="form-group">
                                        <label for="child2_birthdate" class="col-form-label text-md-right">Child2 Birthdate</label>

                                        <div class="col-sm-8">
                                            @if($contactReferencesChild2Data != null)
                                            <input id="datepicker3" value="{{ $contactReferencesChild2Data->birthdate }}" name="child2_birthdate" width="400" />
                                            @else
                                            <input id="datepicker3" value="" name="child2_birthdate" width="400" />
                                            @endif
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<script>
    let old_marrital_status = {{ $contacts->marital_status }};
    
    if(old_marrital_status == 0){
        $("#marital-div").hide();
    }
    
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
@endsection