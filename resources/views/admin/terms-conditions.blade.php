@extends('layouts.admin_app')
@section('content')
    <!-- page BODY -->
   
    <div class="page-body">
       @include('includes.admin_side_bar');
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
                        <li><a href="#">CMS</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="cms">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="section-subtitle"><b>Content Management System</b></h4>
                             <div class="tabs">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#demo1" data-toggle="tab">Terms &amp; Conditions</a></li>
                                    <li><a href="#demo2" data-toggle="tab">Policy</a></li>
                                </ul> <form  method="POST" action="{{ route('admin.update.content') }}" id="lform" autocomplete="off">
                                                 {{ csrf_field() }}
                                <div class="tab-content">
                                     
                                    <div class="tab-pane fade in active" id="demo1">
                                        <div class="panel">
                                            <div class="panel-header panel-success">
                                                <h3 class="panel-title">Terms &amp; Conditions</h3>
                                                
                                            </div>
                                            <div class="panel-content">
                                                
                                                <textarea name="terms_conditions"><p><?php echo $terms_conditions->content ;?></textarea>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in " id="demo2">
                                        <div class="panel">
                                            <div class="panel-header panel-success">
                                                <h3 class="panel-title">Policy</h3>
                                                
                                            </div>
                                            <div class="panel-content">
                                                
                                                <textarea name="policy"><p><?php echo $policy->content ;?></textarea>
                                                
                                            </div>
                                        </div>
                                    </div>
                                 <div class="text-right">
                                    <input class="btn btn-wide btn-success" type="submit" id="updatecontent" value="SAVE" />
                                </div>
                                </div>

                                </form>
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
<script src="{{ asset('js/admin-investor.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
 <script src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>
 <script type="text/javascript">
   
 $('textarea').ckeditor();
        function insertIntoCkeditor(){
            var str = $('#tags').val();
        CKEDITOR.instances['emailcontent'].insertText(str);
        
        }

    $('#manage_investor_li').removeClass('active-item');
    $('#manage_valuer_li').removeClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');
    $('#manage_content_li').addClass('active-item');
</script>  
@endsection
