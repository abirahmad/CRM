@extends('backend.layouts.app')

@section('title')
All Contact Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection


@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Contact Lists</h3>
            </div>
            {{--  <div class="float-right">
                <a href="{{ route('admin.contacts.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Add New Contact
            </a>
        </div> --}}
        <div class="clearfix"></div>
    </div>
</div>
</div>
<div class="text-right">
                   
                      <a  href="{{route('admin.contacts.create')}}" class="btn btn-primary box-shadow shadow  "><i class="fa fa-plus"></i>Add New Contact</a>  
                    </div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="table-responsive product-table">
            <table class="display" id="contacts_table">
                <thead>
                    <tr>
                       
                        <th>Name</th>
                        <th>Information</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Engineer's Birthdate</th>
                        <th>Staus</th>
                        <th>Total Sites</th>
                        <th>Reward Point</th>
                        <th>Wife's Name</th>
                        <th>Wife's Birthdate</th>
                        <th>Marriage Date</th>
                        <th>Upazila</th>
                        <th>District</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
               

                <tfoot>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tfoot>

                
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $('#contacts_table').DataTable({
        dom: 'Blfrtip',
        processing: true,
        serverSide: true,
        aaSorting: [
            // [0, 'desc']
        ],
        ajax: 'contacts',
        columnDefs: [{
            "targets": [1,4], 
            "searchable": true,
            "orderable": true,
            
        }],
         aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],
         buttons: [
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [  ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [':visible' ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [':visible' ]
                }
            },'colvis'
        ],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'designation', name: 'designation' },
            { data: 'email', name: 'email' },
            { data: 'phone_no', name: 'phone_no' },
            { data: 'eng_birthdaate', name:'eng_birthdaate'},
            { data: 'status', name: 'status' },
            { data: 'sites', name: 'sites' },
            { data: 'reward', name: 'reward' },
            { data: 'wife_name', name: 'wife_name' },
            { data: 'birthdate', name: 'birthdate' },
            { data: 'marriage_date', name: 'marriage_date' },
            { data: 'upazila', name: 'upazila' },
            { data: 'district', name: 'district' },
            { data: 'action', name: 'action' },
        ],
        "fnDrawCallback": function(oSettings) {
            
        }
    });
</script>
@endsection