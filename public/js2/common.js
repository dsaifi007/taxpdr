$(document).ready(function(){
         //when the user clicks on the dropdown,
         $('#account_type').on('change', function() {
            var itemval = $(this).val();
            if(itemval == 3){
			    $('#licence_number').attr('type','text');
                $('#state_div').show();
               // $("input[name=hiddendisplay]").parsley().reset()
            }else{
				  $('#licence_number').attr('type','hidden');
                  $('#state_div').hide();
				  $('#licence_number').parsley().reset();
                  
			}
         //add the #dropdown's value to the #hiddendisplay value
        //$('#hiddendisplay').val($(this).val());
 
     });

    //password input space not allow
    $("input#password").on({
        keydown: function(e) {
            if (e.which === 32)
               return false;
            },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }

    });

    //password input space not allow
    $("#email").focus( function(e) {
        console.log('err');
           $('#emailerror').hide();
           $('#emailerror1').hide();
    });

       

});

        
        //submit update form 
function editproperty(){
       var construction_year = $("#construction_year").val();
       var purchase_year = $("#purchase_year").val();
       $('#construction_error').hide();
        if(construction_year > purchase_year){
          $('#construction_error').show();
           $('#construction_error').html("Construction year can not greater than purchase year.");
           return false;
       }
}

function commonvalidation1(){
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
}

