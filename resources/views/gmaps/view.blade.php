<!DOCTYPE html>
<html>
  <head>
    <title>Gmaps.js テスト</title>
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/gmaps/gmaps.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzezqlEfLkes3BKDhdBIAOP-zXDv4Pi9U" async></script>
    <script type="text/javascript">
      // コントローラから渡された住所を取得
      var addressStr = "{!! $address !!}";

      $(document).ready(function(){
          // Gmapsを利用してマップを生成
          var map = new GMaps({
              div: '#map',
              lat: -12.043333,
              lng: -77.028333
          });

          // 住所からマップを表示
          GMaps.geocode({
              address: addressStr.trim(),
              callback: function(results, status) {
                  if (status == 'OK') {
                      var latlng = results[0].geometry.location;
                      map.setCenter(latlng.lat(), latlng.lng());
                      map.addMarker({
                          lat: latlng.lat(),
                          lng: latlng.lng()
                      });
                  }
              }
          });
      });
    </script>

    <style>
      @charset "utf-8";
      #map {
        height: 400px;
      }
    </style>
  </head>
  <body>
    <h1>Gmaps.js テスト</h1>
    <p>住所：{{ $address }}</p>
    <div id="map"></div>
  </body>
</html>
