window.onload = function() {

    // show.blade.phpのid:mapを指す
    var target = document.getElementById('map'); //マップを表示する要素を指定
    // var address = "{!! $event->mountain_name !!}"; //住所を指定

    // show.blade.phpのid:mountain_nameを指す
    var address_input = document.getElementById('mountain_name');

    // 住所が取得できているかデバッグ
    console.log('address_input',address_input.value);
    
    var address = address_input.value;
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
