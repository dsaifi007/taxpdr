@if(count($allsaved_addresses) > 0)
               @foreach($allsaved_addresses as $saved_address)
               
                                                    {{ csrf_field() }}
                 <span id="error_li{{$saved_address['id'] }}"></span>
                    <li class="nopad" style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" id="remove_li{{ $saved_address['id']}}">
                        <div class="over-lay"></div>    
                            <ol>
                                <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $saved_address['created_at']) }}</div></li>
                                <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['property_address'] }} </div></li>
                                <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['property_type_name']}}</div></li>
                                 <li><div class="icon"><i class="fa fa-usd" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['purchase_price']}} <strong>(AUD)</strong></div></li>
                            </ol>
                        <div class="image-checkbox">
                            <input type="checkbox" name="saved_id[]" value="{{ $saved_address['id'] }}" />
                            <i class="fa fa-square-o"></i>
                            <i class="fa fa-check-square-o hidden"></i>
                        </div>
                        <div class="tow-icon-btn">
                            <a href="#edit-proper-ty" data-toggle="modal" class="edit-property" data-edit-id="{{ $saved_address['id']}}"><i class="fa fa-edit"></i></a>
                            <a href="#delete-proper-ty" class="open_confirm" data-edit-id="{{ $saved_address['id']}}" data-toggle="modal"><i class="fa fa-trash"></i></a>
                        </div> 
                    </li>
                @endforeach

                <div class="tow-btn text-center">
                        
                         <button class="theme-btn btn-style-one" id="send_saved_request" type="button" >Send Request</button>
                        
                    </div>
                   
            @else
                <span style="color:#0fad00">{{trans('messages.no_saved_requests')}}</span>
            
            @endif 