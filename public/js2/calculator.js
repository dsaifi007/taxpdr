$(document).ready( function() {

$("#home_li").removeClass("current");
$("#profile_id").removeClass("current");
$("#report_li").removeClass("current");
$("#calculator_li").addClass("current");

  $('#calculate').on('click', function(){
  var form = $('#lform');
  // $("#error_div").hide("slide", { direction: "down" }, 300);
   //$("#success_result").hide("slide", { direction: "down" }, 300);
   $('#purchaseprice_error').html("");
   $('#construction_year_error').html("");
   $('#purchase_year_error').html("");
     var current_year = (new Date()).getFullYear();
     var purchase_price = $('#purchaseprice').val();
     var construction_year = $('#construction_year').val();
     var purchase_year = $('#purchase_year').val();
     if(purchase_price ==''){
        $('#purchaseprice_error').html("Purchase price is required.");
        return false;
     }
      if(purchase_price == 0){
        $('#purchaseprice_error').html("Purchase price should be greater than 0.");
        return false;
     }
     if(construction_year ==''){
      console.log('construction_year required');
        $('#construction_year_error').html("Construction year is required.");
        return false;
     }
     if(construction_year < 1900 || construction_year >current_year){
              $('#construction_year_error').html("Please enter a valid year.");
              return false;
     }

     if(purchase_year ==''){
      console.log('purchase_year required');
       $('#purchase_year_error').html("Purchase year is required.");
       return false;

     }else if(purchase_year < 1900 || purchase_year > current_year ){
              $('#purchase_year_error').html("Please enter a valid year.");
              return false;
     }else if(purchase_year < construction_year){
              $('#purchase_year_error').html("Purchase year can not be less than construction year.");
              return false;
     }
      $('#lform').addClass('height524');

        $.ajax( {
          type: "POST",
          url: form.attr( 'action' ),
          data: form.serialize(),
          success: function( response ) {
            if(response.status == true){
               $("#success_result").show();
               $("#error_div").hide();
               $("#purchase_price_resp").html(response.data.calculate_info.purchase_price);
               $("#depreciation_price").html(response.data.calculate_info.calculate_price);
               $("#after_depreciation_price").html(response.data.calculate_info.price_after_dep);
            }else{
                 $("#success_result").hide();
                 $("#error_div").show();

                 $("#error_message").html(response.error_message);
              
            }
           
          }
        });
     });




   $('.numberallow').keypress(function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      
});

$('.numberallow').bind("paste", function(e) {
var text = e.originalEvent.clipboardData.getData('Text');
if ($.isNumeric(text)) {
    if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
        e.preventDefault();
        $(this).val(text.substring(0, text.indexOf('.') + 3));
   }
}
else {
        e.preventDefault();
     }
});
  

} );