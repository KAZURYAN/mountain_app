// $(function() {
//     // console.log("serach:",$( "#search" ));
//
//     $( "input.search_name" ).on("focus" , function(){
//       $(this).autocomplete({
//
//       source: function(request, response) {
//           $.ajax({
//             url: "/mountain/event/create/autocompletemember",
//             type:'get',
//             data: {
//                     term : request.term
//              },
//             dataType: "json",
//             success: function(data){
//                var resp = $.map(data,function(obj){
//                     return obj.name;
//                });
//
//                response(resp);
//             }
//           });
//       },
//       select: function (event, ui) {
//             $('#search').val(ui.item.label);
//             return false;
//       },
//       minLength: 1
//
//     });
//   });
// });


$(function() {
    // console.log("serach:",$( "#search" ));

    $( ".search_name" ).autocomplete({

      source: function(request, response) {
          $.ajax({
            url: "/mountain/event/create/autocompletemember",
            type:'get',
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.name;
               });

               response(resp);
            }
          });
      },
      select: function (event, ui) {
            $('#search').val(ui.item.label);
            return false;
      },
      minLength: 1
    });
});
