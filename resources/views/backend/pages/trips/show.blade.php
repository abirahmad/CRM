@extends('backend.layouts.app')

@section('title')
Trip Details
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')

@endsection

@section('admin-content')


<div class="row">
    <div class="col-xl-12 xl-100">
        <h4 class="mb-3 mt-2">Trip Details</h4>
        @include('backend.layouts.partials.messages')
        <div class="card card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered table-striped">
                <tr>
                  <th>Trip Code</th>
                  <td>#1212</td>
                </tr>
                <tr>
                  <th>Trip Gate In Time</th>
                  <td>12 September 2020, 10AM</td>
                </tr>
                <tr>
                  <th>Trip Unload Weight</th>
                  <td>12 September 2020, 10AM</td>
                </tr>
                <tr>
                  <th>Trip Load Weight</th>
                  <td>-</td>
                </tr>
                <tr>
                  <th>Trip Gate Out Time</th>
                  <td>-</td>
                </tr>
                <tr>
                  <th>Confirmation Delivery Time</th>
                  <td>-</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-bordered table-striped">
                <tr>
                  <th>Vehicle No</th>
                  <td>DHA-129012</td>
                </tr>
                <tr>
                  <th>Driver Name</th>
                  <td>Polash Rana</td>
                </tr>
                <tr>
                  <th>Driver Phone</th>
                  <td>
                    01711287848
                    <a href="#" class="btn btn-rounded btn-danger" title="Call Driver"><i class="fa fa-phone"></i></a>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

       <div class="mt-3">
         <h3>Delivery Challan Information</h3>
          <div class="table-responsive card card-body ">
            <table class="table table-bordered table-hover table-striped" id="tableTripList">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Challan No</th>
                  <th>Product Name</th>
                  <th>Product Qty</th>
                  <th>Product Amount</th>
                  <th>Challan Date</th>
                  <th>Challan Address</th>
                  <th>Retailer Information</th>
                  <th>Dealar Information</th>
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
  // Demo API Call system
  const intUnitId = 4;

  $('#tableTripList tbody').DataTable( {
        ajax: {
           url: `http://iapps.akij.net/api/v1/logistic/trips/getTripListByUnitId?intUnitId=${intUnitId}`,
           method: "GET",
           xhrFields: {
               withCredentials: true
           }
        },
        columns: [
            { data: "b.strCode" },
            { data: "b.strVehicleRegNo" },
            { data: "b.strDriver" },
            { data: "b.strContact" },
            { data: "b.strHelperName" },
            { data: "b.strShippingPointName" }
            /*and so on, keep adding data elements here for all your columns.*/
        ]
    } );
</script>

@endsection
