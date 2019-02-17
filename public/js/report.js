
$("#profile_id").removeClass("current");
$("#checkout_li").removeClass("current");
$("#home_li").removeClass("current");
$("#report_li").addClass("current");
$(function () {
  $("#rateYo").rateYo({
    fullStar: true,
    normalFill: "#A0A0A0",
    starWidth: "40px",
     onSet: function (rating, rateYoInstance) {
        var rate_val = $('#rate').val();  
        if(rate_val == rating ){
             $("#rateYo").rateYo("rating", 0);
             $('#rate').val('');
        }else{
            $('#rate').val(rating);
            $('#lform').parsley().reset();
            $('.parsley-required').hide();
        }
       
    }

  });

 
});
 $('.review_rate_popup').on('click', function(){
 	     $('#lform').parsley({
            excluded: 'input[type=button], input[type=submit], input[type=reset]',
    inputs: 'input,textarea, select, input[type=hidden], :hidden',
         });
        
         var id = $(this).attr("data-id");
         if($('#rate').val()){
             $("#rateYo").rateYo("rating", 0);
         }
         $("#lform").show();
         $('#succes-review').hide();
         $('#error-review').hide();
         $("#ok_div").hide();
         $('#sent_request_id').val(id);
         $('#review_description').val('');
         $('#lform').parsley().reset();
         $('.parsley-required').hide();
         $('#rate').val('');
     });

  $('#review_submit').on('click', function(e){
    e.preventDefault();
         var rate = $('#rate').val();
         if(rate == ''){
            $('#select_star-error').show();
           return false;
         }else{
             $('#select_star-error').hide();
         }
         var sent_request_id = $('#sent_request_id').val();
         var form = $("#lform");
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
          $.ajax({
             url: APP_URL+'/investor/saved-review',
             type:'POST',
             data: form.serialize(),
             success: function(response){
                 console.log(response);

                if(response.status == true){
                    if(response.data.property.review_description !=null){
                        var review_description =  '<span class="ellipsis">'+response.data.property.review_description+'</span>' ;
                    }else{
                         var review_description = '';
                    }

                   $("#lform").hide();
                   $("#review_btn"+sent_request_id).hide();
                   $('#succes-review').show();
                   $('#succes-review').html('<h4>'+response.message+'</h4>');
                   $("#ok_div").show();
                   $("#rating"+sent_request_id).html('<p><i class="fa fa-star" aria-hidden="true"></i><span>'+response.data.property.rate+'.0</span></p>');
                   $("#rating"+sent_request_id).show();
                   
                }else{
                   $("#lform").hide();
                   $('#error-review').show();
                   $('#error-review').html('<h4>'+response.error_message+'</h4>');
                   $("#ok_div").show();

                }
            }
          });
      
     });
   //ok click reload page
       $('#ok_buuton').on('click', function(){
         location.reload(true);
     });