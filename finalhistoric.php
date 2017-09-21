<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>

    <title></title>
  </head>
 
<div >
  <?php
  $servername = "designlocations.cl8waza61otc.us-east-2.rds.amazonaws.com";
  $username = "abcr";
  $password = "abcr1234";

  // Create connection
  $conn = new mysqli($servername, $username, $password);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  #echo "Connected successfully";
  mysqli_select_db($conn, "desinglocations");
  $query = "SELECT * FROM locations WHERE 1 ";
  $result = mysqli_query($conn, $query);
  $finfo = mysqli_fetch_field($result);
  mysqli_data_seek($result, 1);
  $row = mysqli_fetch_row($result);
  $hist=[];
  while ($row = mysqli_fetch_array($result)) {
      $Id = $row['ID'];
      $Lat = $row['Latitude'];
      $Long = $row['Longitude'];
    $hist[]=$row;
    }
            ?>
</div>
  <body>

        <style>
      #map2 {
        height: 80%;
      }
      html, body {
        height: 80%;
        margin: 20;
        padding: 20;
      }
    </style>
  </head>
  <body>
    <div id="map2"></div>
    <script>
    var id = "<?php echo $Id; ?>";
    var lat = "<?php echo $Lat; ?>";
    var lon = "<?php echo $Long; ?>";
    var myPath2 = [];
    var image = 'https://cdn0.iconfinder.com/data/icons/isometric-city-basic-transport/48/truck-front-01-48.png';
    function initMap2() {
            var myLatLng = {lat: parseFloat(lat), lng: parseFloat(lon)};
             var myOptions = {
                 zoom: 16,
                 center: myLatLng,
                 panControl: true,
                 zoomControl: true,
                 scaleControl: true,
                 mapTypeId: google.maps.MapTypeId.ROADMAP
             }
          map2 = new google.maps.Map(document.getElementById("map"), myOptions);
  //  setInterval(function mapload(){
       $(document).ready(function() {
          $.ajax({
                url: "finalquery.php",
                 // data: form_data,
                success: function(hist)
                {
                    var json_hist = jQuery.parseJSON(JSON.stringify(hist));
                    INIT_LAT = parseFloat(json_hist[json_hist.length - 1].Latitude);
                    INIT_LON = parseFloat(json_hist[json_hist.length - 1].Longitude);
                    $(json_hist).each(function() {
                      var ID = this.ID;
                      var LATITUDE = this.Latitude;
                      var LONGITUDE = this.Longitude;
                      myCoord2 = new google.maps.LatLng(parseFloat(LATITUDE), parseFloat(LONGITUDE));
                      myPath2.push(myCoord2);
                      var myPathTotal2 = new google.maps.Polyline({
                        path: myPath2,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 5
                      });
                      myPathTotal2.setPath(myPath2)
                      myPathTotal2.setMap(map2);
                      addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map2);
                    });
                },
                dataType: "json"//set to JSON
              })
    }, 1 * 1000);
  }
        function addMarker(latLng, map2) {
                   var marker = new google.maps.Marker({
                       position: latLng,
                       map: map2,
                       icon: image
                   });
                   return marker;
              }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp2b5o90_5K1NbK5qZj86P6Hn61xhUFII&callback=initMap2">
    </script>

  </body>
</html>

