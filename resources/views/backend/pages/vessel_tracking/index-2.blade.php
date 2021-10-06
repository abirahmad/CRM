@extends('backend.layouts.app')

@section('title')
Vessel Tracking |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('styles')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLj-Mx1_PCXsvJnL9COV14XsKDbLyouWQ"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->

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
        <!--<div class="float-right">-->
        <!--    <form action="" class="border p-2 m-2">-->
        <!--        Start Date: <input type="date" name="start_date" value={{ $start_date }} />-->
        <!--        Start Date: <input type="date" name="end_date" value={{ $end_date }} />-->
        <!--        <button class="btn btn-success btn-sm ml-3" type="submit">Refresh</button>-->
        <!--    </form>-->
        <!--</div>-->
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

<script>
    // $("#mydiv").load(location.href + " #mydiv");
    
      const unitID = {{ $user->unit_id }};
      getMarkerData();
      
       async function  getMarkerData(){
           let vessels = [];
           let locationsArray = [];
           
           vessels = [
                    {name: "AKIJ-GLOBE", vesselId: "AKIJ-GLOBE-IMO-9293105-MMSI-405000232"},
                    {name: "AKIJ-HERITAGE", vesselId: "AKIJ-HERITAGE-IMO-9339454-MMSI-405000200"},
                    {name: "AKIJ-MOON", vesselId: "AKIJ-MOON-IMO-9300506-MMSI-405000262"},
                    {name: "AKIJ-NOBLE", vesselId: "AKIJ-NOBLE-IMO-9340491-MMSI-405000254"},
                    {name: "AKIJ-STAR", vesselId: "AKIJ-STAR-IMO-9403097-MMSI-405000261"},
                    {name: "AKIJ-WAVE", vesselId: "AKIJ-WAVE-IMO-9109366-MMSI-405000090"},
                    {name: "AKIJ-OCEAN", vesselId: "AKIJ-OCEAN-IMO-9138862-MMSI-405000231"}
                ];
            
        //   await axios.get(`http://api1.akij.net:8059/api/VesselTracking/VesselList`)
        //       .then(async function (response) {
        //         const items = response.data.data;
        //         vessels = items;
                
                console.log('vessels:', vessels);
               let requests = [];
               
               for(let i = 0; i < vessels.length; i++){
                   const vesselID = vessels[i].vesselId;
                //   if(i === 0){
                    //   const singleItem = await getLocationSingle(vesselID).then((result) => {
                    //         locationsArray.push(result);
                    //   });
                //   }
                    const url = `http://api1.akij.net:8059/api/VesselTracking/VesselLocations`+'?VesselId='+vesselID;
                    const requestSingle = axios.get(url);
                    requests.push(requestSingle);
               }
               
                axios
                  .all(requests)
                  .then(
                    axios.spread((...responses) => {
                      const responseOne = responses[0];
                      const responseTwo = responses[1];
                      const responesThree = responses[2];
                
                      // use/access the results
                      console.log(responseOne, responseTwo, responesThree);
                    })
                  )
                  .catch(errors => {
                    // react on errors.
                    console.error(errors);
                  });
        //   });
           
           console.log('location outside', locationsArray);
        initData(locationsArray);
     }

     function getLocationSingle (vesselID){
      const url = `http://api1.akij.net:8059/api/VesselTracking/VesselLocations`+'?VesselId='+vesselID;
       console.log('url', url)

       return new Promise((resolve, reject) => {
          axios.get(url)
              .then(function (response) {
                const item = response.data;
                
                if(typeof item != 'undefined'){
                    let infoText = "<div class='trip-area'>"; 
                    infoText += item.detalis+"";
                    infoText += "</div>";
                    const singleVehicleItem = [];
                    singleVehicleItem[0] = infoText;
                    singleVehicleItem[1] = parseFloat(item.latitude);
                    singleVehicleItem[2] = parseFloat(item.longitude);
                    singleVehicleItem[3] = item.intZAxis == null ? 0 : item.intZAxis;
                    resolve(singleVehicleItem);
                }
          });  
       });
    }
    function initData(locations){
        
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 9.29, // 7 => Bangladesh
          center: {lat: 22.0871798, lng: 92.0158767}, 
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        //ocean - 21.8943608,90.8041456,9.25z
        // ocean 2 - zoom more - 22.0184613,90.8707361
        // bangladesh - 23.4502735, lng: 90.802897
        
    
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
    
        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: 'http://crm.akij.net/public/img/ship.png'
          });
          
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
          
        //   google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
        //     return function() {
        //       infowindow.setContent(locations[i][0]);
        //     }
        //   })(marker, i));
        }
    }
    </script>
@endsection
