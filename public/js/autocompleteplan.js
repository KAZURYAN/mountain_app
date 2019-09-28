$(function() {
    // console.log("serach:",$( "#search" ));

    $( "#search" ).autocomplete({

      source: function(request, response) {
          $.ajax({
            url: "/mountain/event/autocomplete",
            type:'get',
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.planner;
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
