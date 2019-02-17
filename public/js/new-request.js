$(document).ready(function(){
        
        $("#profile_id").removeClass("current");
        $("#valuer_job_history_li").removeClass("current");
        $("#valuer_home_li").addClass("current");

        $('input[type=file]').change(function () {
          $('#errormessage').hide();
        });
       //show popup content for reject job
       $('.open_confirm_reject').on('click', function(){
         var id = $(this).attr("data-id");
         $('#popup_title_id').html('Reject Job');
         $('#message_id').html('Are you sure you want to reject this job?');
         $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one" id="reject-new-job" data-dismiss="modal">Reject</a>');
     });

     
      //ok click reload page
       $('#ok_buuton').on('click', function(){
         window.location.href= APP_URL+'/valuer/job-history';
     });

        //ok click reload page
      $('#ok_cancel').on('click', function(){
         location.reload(true);
      });


     //show upload report popup set current job id
      $('.open_upload_report').on('click', function(){
         $('#uploaddiamond')[0].reset();
         $("#uploaddiamond").show();
         $("#loader_div").hide();
         $("#ok_div").hide();
         $("#cancel_div").hide();
         $('#file_name_id').html('Choose a file&hellip;');
         //$('.checkmark').toggle();
         var id = $(this).attr("data-id");
         $('#job_id').val(id); 
     });  

       $('.showstatusupdate').on('click', function(){
          var id = $(this).attr("data-id");
          $.ajax({
             url: APP_URL+"/valuer/show-job-status",
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
                 if(response.status == true){
                     $('#show_status').html(response.html);
                     $('#editform').parsley().on('field:validated', function() {
                        var ok = $('.parsley-error').length === 0;
                        $('.bs-callout-info').toggleClass('hidden', !ok);
                        $('.bs-callout-warning').toggleClass('hidden', ok);
                        });
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

    $("#uploaddiamond").on("submit", function(e) {
    e.preventDefault();
    var extension = $('#result_file').val().split('.').pop().toLowerCase();
     $('#errormessage').hide();
    if ($.inArray(extension, ['pdf']) == -1) {
        $('#errormessage').css("display", "block");
    } else {
        var file_data = $('#result_file').prop('files')[0];
        var job_id = $('#job_id').val();
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('job_id', job_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".close").hide();
        $("#uploaddiamond").hide();
        $("#loader_div").show();
        $("#uploading").show();
        $("#ok_div").hide();
        $("#cancel_div").hide();
        $.ajax({
            url: APP_URL+"/valuer/upload-report", // point to server-side PHP script
            data: form_data,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function(data) {
                if(data.status == true){
                  $(".close").hide(); 
                  $("#uploaddiamond").hide();
                  $("#loader_div").hide();
                  $("#uploading").hide();
                  $("#loader_div").show();
                  $('.circle-loader').toggleClass('load-complete');
                  $('.circle-loader').toggleClass('load-complete');
                  $('#payment-succ-mess').show();
                  $('.circle-loader').addClass('load-complete');
                  //$('.checkmark').toggle();
                  $('.checkmark').show();
                  $("#ok_div").show();
                }else{
                  $(".close").hide(); 
                  $("#uploaddiamond").hide();
                  $("#loader_div").hide();
                  $("#uploading").hide();
                  $("#loader_div").show();
                  $('.circle-loader').toggleClass('load-ulcomplete');
                  $('#payment-error-mess').show();
                  $('#continue').show();
                  $('#paybystrip').hide();
                  $('.circle-loader').addClass('load-ulcomplete');
                  //$('.checkmark').toggle();
                  $('.checkmark').show();
                  $("#cancel_div").show();

                }
               

               
            }
        });
    }
  });   


});

 function checkstatuschecked(){
        
       if($("#checkstatusid").prop('checked') == true){
            $('#parsley-id-multiple-new_status').removeClass('filled');
            $('.has-error').addClass('has-success');
            $('.has-success').removeAttr('aria-describedby', 'parsley-id-multiple-new_status');
            $('.has-success').removeClass('has-error');
            setTimeout(function(){ $('.parsley-required').css("display","none"); }, 1);
        }else{
            $('#parsley-id-multiple-new_status').addClass('filled');
            $('.has-success').addClass('has-error');
            $('.has-success').attr('aria-describedby', 'parsley-id-multiple-new_status');
            $('.has-error').removeClass('has-success');
            setTimeout(function(){ $('.parsley-required').css("display","block"); }, 1);
            
        }
      }
