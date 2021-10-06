@extends('backend.layouts.app')

@section('title')
Trip List
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')

@endsection

@section('admin-content')

@php
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y').'-'.date('m').'-'.'01';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
@endphp

<div class="row">
    <div class="col-xl-12 xl-100">
        <h4 class="mb-3 mt-2">Trip List</h4>
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
                  <br>
                  Start Date: <input type="date" name="start_date" id="start_date" value={{ $start_date }} />
                  End Date: <input type="date" name="end_date" id="end_date" value={{ $end_date }} />
                  <button class="btn btn-success btn-sm ml-3" type="submit">Search</button>
                 </div>
               </div>
            </form>
        </div>
        @include('backend.layouts.partials.messages')
        
       <div class="mt-3">
          <div class="table-responsive card card-body ">
            <table class="table table-bordered table-hover table-striped display" id="tableTripList">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Trip Code</th>
                  <th>Vehicle Info</th>
                  <th>Driver Info</th>
                  <th>Customer Info</th>
                  <th>Trip More Info</th>
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
  
  const ajaxURL = "<?php echo 'trip-list'; ?>";
  report_table = $('table#tableTripList').DataTable({
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
                d.start_date = "<?php echo $start_date; ?>";
                d.end_date = "<?php echo $end_date; ?>";
            }
        },

        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'strTripCode', name: 'strTripCode' },
            { data: 'strVehicleRegNo', name: 'strVehicleRegNo' },
            { data: 'strDriver', name: 'strDriver' },
            { data: 'str3rdPartyName', name: 'str3rdPartyName' },
            { data: 'dteInsertionTime', name: 'dteInsertionTime' },
            { data: 'action', name: 'action' },
        ],

        "createdRow": function (row, data, index) {
              var info = report_table.page.info();
              $('td', row).eq(0).html(index + 1 + info.page * info.length);
        }
    });
  
</script>

@endsection
