$(document).ready(function(){
  
       //show popup content for reject job
       $('.open_confirm_reject').on('click', function(){
         var id = $(this).attr("data-id");
         $('#popup_title_id').html('Reject Job');
         $('#message_id').html('Are you sure you want to reject this job?');
         $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one" id="reject-new-job" data-dismiss="modal">Reject</a>');
     });

       $('.showstatusupdate').on('click', function(){
          var id = $(this).attr("data-id");
          $.ajax({
             url: APP_URL+"/valuer/show-job-status",
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
                 console.log(response);
                 if(response.status == true){
                     $('#show_status').html(response.html);
                 }else{
                       //console.log('error');
                 }
              }
          });
     });


   $(document).delegate('#reject-new-job','click', function(){
         var id = $(this).attr("data-id");
         $('.open_confirm_reject').attr('disabled', true);
         $.ajax({
             url: APP_URL+"/valuer/reject-new-job",        
             async: true,
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
              if(response.status == true){
                 $('.open_confirm_reject').attr('disabled', false);
                  location.reload(true);

              }else{
                  $('.open_confirm_reject').attr('disabled', false);
                  location.reload(true);
                }
            }
        });
         
         
     }); 

    $(document).delegate('#accept-new-job','click', function(){
         var id = $(this).attr("data-id");
         $('.open_confirm_reject').attr('disabled', true);
         $.ajax({
             url: APP_URL+"/valuer/accept-new-job",        
             async: true,
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
              if(response.status == true){
                 $('.open_confirm_reject').attr('disabled', false);
                  location.reload(true);

              }else{
                  $('.open_confirm_reject').attr('disabled', false);
                  location.reload(true);
                }
            }
        });
         
         
     });  


});
