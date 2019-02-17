$(document).ready(function() {

    $('#investor-table').DataTable();

    $('#exa').DataTable( {
       initComplete: function () {
     this.api().columns(4).every(function () {
         var column = this;
 
         if (column.index() !== 0) {  //skip if column 0
           $('#exa_filter').append("<label style='padding-left:15px;'>Show:</label> ")
           var select = $('<select class="form-control input-sm" ><option value="">All</option></select>')
                               .appendTo($('#exa_filter'))
                               .on('change', function () {
                 var val = $.fn.dataTable.util.escapeRegex(
                     $(this).val()
                 );
 
                 column
                     .search(val ? '^' + val + '$' : '', true, false)
                     .draw();
             });
           column.data().unique().sort().each(function (d, j) {
             select.append('<option value="' + d + '">' + d + '</option>')
          } );
       }   //end of if
 
    } );
}
    } );

    } );
function blockUnblock(id){
	var current_status = $('#user_block'+id).attr('current-status');
	var status_value = $('#user_block'+id).val();
 
  console.log(current_status);
		if(current_status == 1){
			$('#user_block'+id).attr('current-status',0);
    	    $('#user_block'+id).val(0);
    	    var new_status = 0; 
        }else{
        	$('#user_block'+id).attr('current-status',1);
    	    $('#user_block'+id).val(1);
    	    var new_status = 1; 
        }

        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
       url: APP_URL+"/Admin/update-investor-status",
      cache: false,
      type: "POST",
      processData :true,
      data: {id : id,status:new_status},
      success : function(data) {
        console.log(data);
        if (data) {
        } 
        else {

        }
      }
  });
	    
}

