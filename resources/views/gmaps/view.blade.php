<!DOCTYPE html>
<html>
  <head>
    <title>Gmaps.js テスト</title>
    <!-- <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/gmaps/gmaps.min.js"></script> -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfJlDc2ygNSSeISUtKeIBhIfKZrKiyAU0" async></script>
    <script type="text/javascript">

    function initMap() {

        var target = document.getElementById('map'); //マップを表示する要素を指定
        var address = "{!! $address !!}"; //住所を指定
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address: address }, function(results, status){
          if (status === 'OK' && results[0]){

            console.log(results[0].geometry.location);

             var map = new google.maps.Map(target, {
               center: results[0].geometry.location,
               zoom: 15
             });

             var marker = new google.maps.Marker({
               position: results[0].geometry.location,
               map: map,
               animation: google.maps.Animation.DROP
             });

          }else{
            //住所が存在しない場合の処理
            alert('住所が正しくないか存在しません。');
            target.style.display='none';
          }
        });
      }
    </script>

  </head>
  <body  onload="initMap()">
    <h1>Gmaps.js テスト</h1>
    <p>住所：{{ $address }}</p>
    <div id="map" style="width: 600px; height: 500px;"></div>
  </body>
</html>
