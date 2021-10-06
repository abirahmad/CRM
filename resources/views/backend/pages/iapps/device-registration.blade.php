@extends('backend.layouts.app')

@section('title')
Device Registration List
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')

@endsection

@section('admin-content')

@php
// $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y').'-'.date('m').'-'.'01';
// $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
@endphp

<div class="row">
    <div class="col-xl-12 xl-100">
        <h4 class="mb-3 mt-2">Device Registration List</h4>
        <div class="">
            <form action="" class="border p-2 m-2">
               <div class="row">
                 <div class="col-md-4">
                    Select Unit: 
                    <select name="unit_id" class="form-control" id="unit_id">
                      @foreach ($units as $unt)
                          <option value="{{ $unt->id }}" {{ $unt->id == $unit_id ? 'selected' : '' }}>
                            {{ $unt->code }} - 
                            ({{ $unt->name }})
                          </option>
                      @endforeach
                    </select>
                 </div>
                 <div class="col-md-8">
                  <button class="btn btn-success btn-sm ml-3" type="submit">Search</button>
                 </div>
               </div>
            </form>
        </div>
        @include('backend.layouts.partials.messages')
        
       <div class="mt-3">
          <div class="table-responsive card card-body ">
            <table class="table table-bordered table-hover table-striped display" id="tableDeviceRegistrationList">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>ID/Email</th>
                  <th>Username</th>
                  <th style="width: 100px!important; white-space: nowrap;">Device</th>
                  <th>User Type</th>
                  <th>App Installed Version</th>
                  <th>First Entry</th>
                  <th>Last Update</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
       </div>
   </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  
  const ajaxURL = "<?php echo 'iapp-device-registration'; ?>";
  report_table = $('table#tableDeviceRegistrationList').DataTable({
        dom: 'Blfrtip',  
        language: {processing: "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading Data..."},
        processing: true,
        serverSide: true,
        searchable:true,
        aaSorting: [
            // [3, 'desc']
        ],
         "ajax": {
            "url": ajaxURL,
            "data": function(d) {
                d.unit_id = "<?php echo $unit_id; ?>";
            }
        },

        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],

        // columnDefs: [
        //   { "width": "100px!important; white-space: nowrap;", "targets": 3 },
        //   { "width": "100px!important; white-space: nowrap;", "targets": 4 },
        // ],

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'strUserEmail', name: 'strUserEmail' },
            { data: 'strUserName', name: 'strUserName' },
            { data: 'strDeviceToken', name: 'strDeviceToken' },
            { data: 'strUserType', name: 'strUserType' },
            { data: 'app_version', name: 'app_version' },
            { data: 'dteCreatedAt', name: 'dteCreatedAt' },
            { data: 'dteUpdatedAt', name: 'dteUpdatedAt' },
            { data: 'action', name: 'action' },
        ],

        // "createdRow": function (row, data, index) {
        //       var info = report_table.page.info();
        //       $('td', row).eq(0).html(index + 1 + info.page * info.length);
        // }
    });
  
</script>

@endsection
