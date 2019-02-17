@extends('layouts.investor_app')
@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}} );">
                        <div class="container"><h2 style="letter-spacing: 0.2em; font-size: 36px;"><strong>Calculate</strong> <span style="text-transform: none;">depreciation deductions for your investment property.</span></h2></div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="my-request create-request prop-cal">
        <div class="auto-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-body" style="padding: 0;">
                        <div class="body-inner">
                            <div class="card bg-white">

                                <form id="lform" name="calculator_form" action="{{ url('api/v1/calculate-depreciation')}}" method="POST">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Property Type</label>
                                                <select class="form-contro" name="property_type">
                                                    <?php $property_types = getAllPropertytypes(); ?>
                                                    @foreach($property_types as $property_type)
                                                    <option value="{{ $property_type->id}}">{{ $property_type->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Property Purchase Price</label>
                                                <div class="icon-doller">
                                                    <input type="text" id="purchaseprice" name="purchase_price" class="form-contro numberallow" required data-required-message="{!! trans('messages.reqired_field') !!}">
                                                    <span id="purchaseprice_error" class="alert alert-danger parsley parsley-required"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <label style="display: block;">Was the property purchased new?</label>
                                                    <div class="form-group" style="padding-top: 15px;">
                                                        <label class="radio-inline"><input name="property_new_status" value="yes" type="radio" checked="checked">Yes</label>
                                                        <label class="radio-inline"><input name="property_new_status" value="no" type="radio" />No</label>
                                                    </div>        
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label>Floor Area</label>
                                                        <input type="text" placeholder="Optional" name="floor_area" class="form-contro numberallow">
                                                    </div>
                                                </div>
                                                <div class="col-md-5" style="padding-left: 0;">
                                                    <div class="form-group">
                                                        <label>Floor Area Unit</label>
                                                        <select class="form-contro" name="floor_area_unite" >
                                                            
                                                            <option value="sqmt">Sq. Metres</option>
                                                            <option value="squares">Squares</option>
                                                        </select>

                                                    </div>        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Year of Construction</label>

                                                 <select class="form-contro" id="construction_year" name="construction_year" >
                                                        <?php 
                                                        $current_year = date('Y');
                                                        for ($year=2000; $year <=  $current_year; $year++){ ?>
                                                          <option  @if($year==$current_year) selected @endif value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
                                                        <?php } ?>
                                                </select>

                                                <!--input type="text" id="construction_year" name="construction_year" class="form-contro numberallow" maxlength="4" -->
                                                 <span id="construction_year_error" class="alert alert-danger parsley parsley-required"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Year of Purchase </label>
                                                 <select class="form-contro" id="purchase_year" name="purchase_year" >
                                                        <?php
                                                         
                                                        for ($year=2000; $year <= $current_year; $year++){ ?>
                                                          <option @if($year==$current_year) selected @endif value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
                                                        <?php } ?>
                                                </select>

                                                <!--input type="text" id="purchase_year" name="purchase_year" class="form-contro numberallow" maxlength="4"-->
                                                 <span id="purchase_year_error" class="alert alert-danger parsley parsley-required" ></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tow-btn text-center">
                                        <a href="javascript:void(0)" id="calculate" class="theme-btn btn-style-one">Calculate</a>
                                    </div>
                              
                              <div class="row" >
                                <div class="col-md-12 col-sm-12 col-sx-12" id="success_result" style="display:none"> <!--  response div start -->
                                    <div class="minimum-c">
                                        <h3>Estimate of Depreciation Claimable:</h3>
                                        <div class="">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="33.333%">Purchase price</th>
                                                        <th width="33.333%">Depreciation amount</th>
                                                        <th width="33.333%">After Depreciation price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  width="33.333%" style="font-weight: bold;" >$<span id="purchase_price_resp" >0</span></td>
                                                        <td  width="33.333%" style="font-weight: bold;" >$<span id="depreciation_price">0</span></td>
                                                        <td  width="33.333%" style="font-weight: bold;" >$<span id="after_depreciation_price">0</span></td>
                                                    </tr>
                                                </tbody>   
                                            </table>
                                        </div> 
                                    </div>
                                </div><!--  response div end -->
                                <div class="col-md-12 col-sm-12 col-sx-12" id="error_div" style="display:none;margin-top: 23px;"> <!--  response div start -->
                                          <div class="alert alert-danger">
                                                  <span id="error_message"> Indicates a dangerous or potentially negative action.</span>
                                                  <a class="theme-btn btn-style-one pull-right" href="#">Create New Request</a>
                                                </div>
                                </div>     
                
                            </div>


  

                                   
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('java-script')
<script type="text/javascript" src="{{ asset('js/calculator.js') }}"></script>
@endsection