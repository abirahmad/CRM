@extends('backend.layouts.app')

@section('title')
Vehicle Tracking |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLj-Mx1_PCXsvJnL9COV14XsKDbLyouWQ"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<style>

    .trip-area {
        border: 1px solid green;
        background: #303e54;
        padding: 15px;
        font-size: 16px;
        font-family: sans-serif;
        letter-spacing: 1px;
        line-height: 25px;
        color: #FFF;
        transition: width 2s;
    }
    
    .trip-no {
        color: #ff6e6e;
        font-size: 20px;
        font-family: cursive;
        font-weight: bold;
        border-bottom: 1px solid #FFF;
        padding-bottom: 15px;
        display: inline-block;
        margin-bottom: 10px;
    }
    .gm-style-iw-a button {
        background: #303e546e!important;
    }
    .trip-area a {
        color: #00ff4c;
        font-size: 34px;
        display: inline-block;
        margin-top: 10px;
        border: 1px solid white;
        border-radius: 20px;
        padding: 8px;
        width: 50px;
        height: 50px;
    }
    
    .gm-style .gm-style-iw-c {
        background-color: transparent!important;
        box-shadow: none!important;
    }
</style>
@endsection

@section('admin-content')

@php
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y').'-'.date('m').'-'.'01';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
@endphp

<div class="row">
    <div class="col-xl-12 xl-100">
        <h4 class="mb-3 mt-2 float-left">Vehicle Tracking</h4>
        <div class="float-right">
            <form action="" class="border p-2 m-2">
                Start Date: <input type="date" name="start_date" value={{ $start_date }} />
                End Date: <input type="date" name="end_date" value={{ $end_date }} />
                <button class="btn btn-success btn-sm ml-3" type="submit">Refresh</button>
            </form>
        </div>
        @include('backend.layouts.partials.messages')
        
       <div class="mt-3">
            <div id="map" style="width: 100%; height: 600px;"></div>
       </div>
   </div>
</div>
@endsection

@section('scripts')
<script>
    let api_key = "AIzaSyDLj-Mx1_PCXsvJnL9COV14XsKDbLyouWQ";
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // $("#mydiv").load(location.href + " #mydiv");
    
      const unitID = 4; //{{ $user->unit_id }};
      getMarkerData();
      
       function  getMarkerData(){
           const url = `http://api2.akij.net:8066/api/DataForVehicleTrackingByLatitudeNLongitude/GetDataForVehicleTrackingByVehicle?intPartid=1&intUnitid=${unitID}&dteFromdate=<?php echo $start_date; ?>&dteTodate=<?php echo $end_date; ?>&intvhcleid=2318&intEnrol=0`;

           let locationsArray = [];
           axios.get(url)
              .then(function (response) {
                const data = response.data;
                for(let i = 1; i <= data.length; i++){
                    let singleVehicleItem = [];
                    const item = data[i];
                    if(typeof item != 'undefined'){
                        let infoText = "<div class='trip-area'>"; 
                        infoText += "<strong class='trip-no'> " + item.strRegNo+"</strong>";
                        infoText += " <br>Trip No - " + item.tripcode+"";
                        infoText += "<br> Driver - " + item.strDriver;
                        infoText += "<br> Contact - " + item.strContact;
                        infoText += "<div class='text-center'> <a href='tel:"+item.strContact+"'><i class='fa fa-phone call-icon'></i></a></div>";
                        infoText += "</div>";
                        
                        singleVehicleItem[0] = infoText;
                        singleVehicleItem[1] = item.decLatitude;
                        singleVehicleItem[2] = item.decLongitude;
                        singleVehicleItem[3] = item.intZAxis == null ? 0 : item.intZAxis;
                        
                        locationsArray.push(singleVehicleItem);
                    }
                }
                initData(locationsArray);
          });
       }
</script>

<script>
    function initData(locations){
        
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: 23.4502735, lng: 90.802897},
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        console.log('locations', locations);
    
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
    
        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
          });
          
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
          
          google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
            }
          })(marker, i));
          
          
          
        }
    }
    </script>
@endsection
