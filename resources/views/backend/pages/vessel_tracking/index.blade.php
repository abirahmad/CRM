@extends('backend.layouts.app')

@section('title')
Vessel Tracking |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZ93ESe7to67gcQBwN9pX5QSn2dUz1LTQ"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
        <h4 class="mb-3 mt-2 float-left">Vessel Tracking</h4>
        @include('backend.layouts.partials.messages')
       <div class="mt-3">
            <div id="floating-panel"></div>
            <div id="map" style="width: 100%; height: 700px;"></div>
       </div>
   </div>
</div>
@endsection

@section('scripts')
<script>
    let api_key = "AIzaSyAZ93ESe7to67gcQBwN9pX5QSn2dUz1LTQ";
</script>

<script>
    // $("#mydiv").load(location.href + " #mydiv");
    
      const unitID = {{ $user->unit_id }};
      getMarkerData();
      
       function  getMarkerData(){
           let vessels = [];
           let locationsArray = [];
           
          axios.get(`http://api1.akij.net:8059/api/VesselTracking/VesselLocationsAll`)
              .then(function (response) {
                const items = response.data.data;
                
                // const items = [{"name":"AKIJ-GLOBE","detalis":"The current position of AKIJ GLOBE is\n     at South East Asia (coordinates 22.20462 N / 91.74475 E)     reported 5 mins ago  by AIS.\n\n    The vessel is en route to the port of Chittagong,  and expected to arrive there\n    on Jul 15, 04:00.","latitude":"22.1963447","longitude":"91.1716148","status":true,"message":"sucess"},{"name":"AKIJ-HERITAGE","detalis":"The current position of AKIJ HERITAGE is\n     at South East Asia (coordinates 22.15288 N / 91.73835 E)     reported 11 days ago  by AIS.\n\n    The vessel is en route to the port of As Suways / Suez Port,  sailing at a speed of 0.2 knots and expected to arrive there\n    on Jul 24, 02:00.","latitude":"22.15288","longitude":"91.73835","status":true,"message":"sucess"},{"name":"AKIJ-MOON","detalis":"The current position of AKIJ MOON is\n     at China Coast (coordinates 39.20275 N / 119.01043 E)     reported 2 mins ago  by AIS.\n\n    The vessel is en route to the port of Jintang,  and expected to arrive there\n    on Jul 20, 06:20.","latitude":"39.20275","longitude":"119.01043","status":true,"message":"sucess"},{"name":"AKIJ-NOBLE","detalis":"The current position of AKIJ NOBLE is\n     at Indian Coast (coordinates 12.70595 N / 80.55873 E)     reported 4 days ago  by AIS.\n\n    The vessel is en route to ARMGUARD ONBOARD,  sailing at a speed of 12.9 knots and expected to arrive there\n    on Aug 3, 20:00.","latitude":"12.70595","longitude":"80.55873","status":true,"message":"sucess"},{"name":"AKIJ-STAR","detalis":"The current position of AKIJ STAR is\n     at Indian Coast (coordinates 21.62538 N / 72.39961 E)     reported 5 days ago  by AIS.\n\n    The vessel is en route to ARM GUARD ONBOARD,  sailing at a speed of 11.8 knots and expected to arrive there\n    on Jul 28, 09:30.","latitude":"21.62538","longitude":"72.39961","status":true,"message":"sucess"},{"name":"AKIJ-WAVE","detalis":"The current position of AKIJ WAVE is\n     at South East Asia (coordinates 22.1434 N / 91.80754 E)     reported 2 mins ago  by AIS.\n\n    The vessel is en route to CTGM. BD,  sailing at a speed of 0.9 knots and expected to arrive there\n    on Jul 2, 09:00.","latitude":"22.1434","longitude":"91.80754","status":true,"message":"sucess"},{"name":"AKIJ-OCEAN","detalis":"The current position of AKIJ OCEAN is\n     at South East Asia (coordinates 20.92782 N / 107.28939 E)     reported 4 days ago  by AIS.","latitude":"20.92782","longitude":"107.28939","status":true,"message":"sucess"}];
                
                
                
               for(let i = 0; i < items.length; i++){
                   const item = items[i];
                   console.log('item:', item);
                   if(typeof item != 'undefined'){
                        let infoText = "<div class='trip-area'>"; 
                        
                        infoText += "<b style='color: #b8d7b4;font-weight: bold;'>Current Position:</b>" + item.detalis+"" + " \n\n<div style='margin-top: 10px!important;'><b style='color: #b8d7b4;font-weight: bold;'>Destination</b>: "+item.detalisTo+"</div>";
                        infoText += "</div>";
                        let singleVehicleItem = [];
                        singleVehicleItem[0] = infoText;
                        singleVehicleItem[1] = parseFloat(item.latitude);
                        singleVehicleItem[2] = parseFloat(item.longitude);
                        singleVehicleItem[3] = item.intZAxis == null ? 10 : item.intZAxis;
                        singleVehicleItem[4] = true;
                        locationsArray.push(singleVehicleItem);
                        
                        const FullString = item.detalis;
                        const findString = "coordinates";
                        // const destinationCoordinate = FullString.slice(FullString.indexOf(findString) + findString.length).trim();
                        
                        // let destinationLatitude = destinationCoordinate.split(' ')[0];
                        // let destinationLongitude = destinationCoordinate.split(' ')[3];
                        let destinationLatitude = parseFloat(item.latitudeTo);
                        let destinationLongitude = item.longitudeTo;
                        
                        let destinationVehicleItem = [];
                        destinationVehicleItem[0] = "<div class='trip-area'>Destination for Vessel: "+item.name+"</div>"+ " Destination: "+item.detalisTo;
                        destinationVehicleItem[1] = parseFloat(destinationLatitude);
                        destinationVehicleItem[2] = parseFloat(destinationLongitude);
                        destinationVehicleItem[3] = item.intZAxis == null ? 10 : item.intZAxis;
                        destinationVehicleItem[4] = false;
                        
                        
                        if(singleVehicleItem[1] != destinationVehicleItem[1]){
                            locationsArray.push(destinationVehicleItem);
                        }
                    }
               }
               initData(locationsArray);
          });
     }

    function initData(locations){
        
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3.84, // 7 => Bangladesh
          center: {lat: 26.7053988, lng: 90.987207}, 
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        // globe - 26.7053988, 90.987207,3.84
        // ocean - 21.8943608,90.8041456,9.25z
        // ocean 2 - zoom more - 22.0871798, 92.0158767
        // bangladesh - 23.4502735, lng: 90.802897
        
    
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
    
        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: locations[i][4] ? 'http://crm.akij.net/public/img/ship.png' : 'http://crm.akij.net/public/img/map-icon-red.png'
          });
          
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }
    }
    </script>
@endsection
