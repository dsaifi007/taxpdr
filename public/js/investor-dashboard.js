
$("#report_li").removeClass("current");
$("#profile_id").removeClass("current");
$("#checkout_li").removeClass("current");
$("#home_li").addClass("current");

 $('.report_view_status').on('click', function(){
         var id = $(this).attr("data-request-id");
         $('#sent_property'+id).hide();
          $.ajax({
             url: APP_URL+"/investor/update-report-view-status",
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
                console.log();
              }
          });
     });