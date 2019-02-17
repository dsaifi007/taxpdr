@extends('layouts.admin_app')
@section('style')
<link rel="stylesheet" href="{{asset('admin/stylesheets/bootstrap-datepicker.css')}}">
@endsection
@section('content')
    <!-- page BODY -->
    <div class="page-body">
       @include('includes.admin_side_bar');
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
                        <li><a href="#">Manage Transaction</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="manage-schools manage-user">
                    <div class="col-sm-12">
                        <h4 class="section-subtitle"><b>Manage Transaction</b></h4>
                        @if(Session::has('message'))
                        <div class="{{ Session::has('message') ? ' alert alert-success' : '' }}">
                            <span class="help-block">
                                <strong>{{ Session::get('message') }}</strong>
                            </span>
                        </div>
                    @endif
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                       
                                       <div class="row" style="margin-right: 0px;margin-left: 0px;">
                                            
                                           <div class="col-md-4 pull-left" style="top:30px;">
                                                <div class="input-group input-daterange">

                                                  <input type="text" id="min-date" class="form-control input-sm date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

                                                  <div class="input-group-addon">to</div>

                                                  <input type="text" id="max-date" class="form-control input-sm date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

                                                </div>
                                              </div>
                                          
                                        </div>
                                      
                             <table class="table table-striped table-hover table-bordered text-center" id="transaction-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Date</th>
                                                <th>Transaction ID</th>
                                                <th>Investor Name</th>
                                                <th>Investor Email</th>
                                                 <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        @foreach($all_requests as $single_requests)    
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{date('d-M-Y',strtotime($single_requests->created_at)) }}</td>
                                            <td>{{$single_requests->charge_id}}</td>
                                            <td>{{$single_requests->investor_name}}</td>
                                            <td>{{$single_requests->investor_email}}</td>
                                             <td>${{$single_requests->amount}}(AUD)</td>
                                            <td>{{$single_requests->transaction_status}}</td>  
                                                                                  
                                        
                                        </tr>

                                @endforeach
                                      
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>

@endsection
@section('java-script')
<script src="{{ asset('admin/javascripts/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admin/javascripts/moment.min.js') }}"></script>
<script src="{{ asset('js/admin-investor.js') }}"></script>
<script type="text/javascript">

    $('#manage_investor_li').removeClass('active-item');
    $('#manage_valuer_li').removeClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').addClass('active-item');
    $('#manage_content_li').removeClass('active-item');

   // Bootstrap datepicker
$('.input-daterange input').each(function() {
  $(this).datepicker('clearDates');
});

// Set up your table
table = $('#transaction-table').DataTable({"bLengthChange": false});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[1] || 0; // Our date column in the table

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#my-table_filter').hide();

    $(document.body).click(function() {
         $('.alert-success').hide();     
   });
      

</script>   
@endsection
