 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
				 Add Property </h4>
                 
            </div>
            <div class="modal-body">
                <div class="card-content">
                    <!--  div class="form-group">
                        <label>Your Property</label>
                        <div class="input-group custom-search-form">
                            <input class="form-contro" placeholder="Search for on address" type="serach">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="divider">
                        Or Enter Manually
                    </div - - - - - - - -->

                     <form id="editform" name="lform" method="POST" action="{{ route('investor.updateSavedRequest') }}" onsubmit="return editproperty();">
                                                    {{ csrf_field() }}
                    <div class="form-group">
                            <label>Property Address</label>
                            <input class="form-contro" name="property_address" id="property_address" value="{{ $saved_address->property_address }}" required data-required-message="{!! trans('messages.reqired_field') !!}" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">        
                                <div class="form-group">
                                    <label>Suburb</label> 
                                    <input class="form-contro" name= "suburb"  required data-required-message="{!! trans('messages.reqired_field') !!}" id="suburb" value="{{ $saved_address->suburb }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">        
                                <div class="form-group">
                                    <label>Select State</label>
                                    <select class="form-contro" name="state" required data-required-message="{!! trans('messages.reqired_field') !!}">
                                        <?php $all_states = getAllStates(); ?>
                                        <option value="" >Select State</option>
                                        @foreach($all_states as $state)
                                        <option @if($saved_address->state == $state->id) selected @endif value="{{ $state->id}}" >{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Year of Construction</label>

                                    <select class="form-contro" id="construction_year" name="construction_year" onchange="return editproperty();" required data-required-message="{!! trans('messages.reqired_field') !!}">
                                         <option value="">Select Construction Year</option>
                                        <?php 
                                            $current_year = date('Y');
                                             for ($year=2000; $year <=  $current_year; $year++){ ?>
                                                 <option   value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
                                             <?php } ?>
                                    </select>

                                        <span id="construction_error" class="alert alert-danger parsley parsley-required" style="display: none;"></span>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Year of Purchase </label>
                                    <select class="form-contro" id="purchase_year" name="purchase_year" onchange="return editproperty();" required data-required-message="{!! trans('messages.reqired_field') !!}">
                                        <option value="">Select Purchase Year</option>
                                       <?php 
                                            $current_year = date('Y');
                                             for ($year=2000; $year <=  $current_year; $year++){ ?>
                                                 <option   value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
                                             <?php } ?>
                                    </select>


                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Property Purchase Price(AUD)</label>
                                        <div class="icon-doller">
                                            <input type="number"  name="purchase_price" value="{{ $saved_address->purchase_price }}" class="form-contro numberallow" required data-required-message="{!! trans('messages.reqired_field') !!}" data-parsley-type="digits" data-pattern-message="{!! trans('messages.valid_price') !!}" data-parsley-trigger="keyup" min="100000" data-parsley-min="100000" data-parsley-min-message="{!! trans('messages.min_property_price') !!}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Floor Area</label>
                                            <input type="text" placeholder="Optional" value="{{ $saved_address->floor_area }}" name="floor_area" class="form-contro numberallow" maxlength="10" data-parsley-type="number" data-type-message="{!! trans('messages.valid_area') !!}"  >
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="padding-left: 0;">
                                        <div class="form-group">
                                            <label>Floor Area Unit</label>
                                            <select class="form-contro" name="floor_area_unite" >

                                                <option @if($saved_address->floor_area_unite == 'sqmt') selected @endif value="sqmt">Sq. Metres</option>
                                                <option @if($saved_address->floor_area_unite == 'squares') selected @endif value="squares">Squares</option>
                                            </select>

                                        </div>        
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label style="display: block;"> Property type</label>
                                <div class="form-group rel-position">
                                     <label class="radio-inline" style="margin-bottom: 7px;">
                                           
                                    <?php $property_types = getAllPropertytypes(); $i=1; ?>
                                    @foreach($property_types as $property_type)
                                    
                                        <input type="radio" required data-required-message="{!! trans('messages.reqired_field') !!}"  @if($saved_address->property_type == $property_type->id) checked @endif value="{{ $property_type->id }}" name="property_type" id="property_type{{ $property_type->id }}" /><span style="padding-right: 23px;"> {{ ucfirst($property_type->name) }}</span>
                                  
                                    <?php $i++; ?>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        
                                        <div class="form-group" >
                                            <label style="display: block;">Was the property purchased new?</label>
                                           <label class="radio-inline" style="margin-bottom: -9px;"><input @if($saved_address->property_new_status == 'yes') checked @endif  name="property_new_status" value="yes" type="radio"  required data-required-message="{!! trans('messages.reqired_field') !!}"><span style="padding-right: 23px;">Yes</span>
                                            <input @if($saved_address->property_new_status == 'no') checked @endif   
                                                name="property_new_status" value="no" type="radio" /><span style="padding-right: 23px;">No</span></label>
                                            </div>        
                                        </div>
                                    </div>
                                </div>

                            </div>

                    <div class="tow-btn text-center">
                        <input type="hidden" name="id" value="{{ $saved_address->id }}" />
                         <button class="theme-btn btn-style-one" type="submit" >Submit </button>
                        
                    </div>
                </div>

            </form>
            </div>
           
       