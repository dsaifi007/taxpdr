 <div class="title">
                                <h3>Charges</h3>
                            </div>

                            <div class="summary">
                                <ul>
                                    <li>Date: <strong class="pull-right">{{ date('d/m/Y') }}</strong></li>
                                </ul>
                            </div>
                             <ul class="treatments checkout clearfix">
                                <?php $i = 1;$j=0; 
                                       $totalcount = 0;
                               // $charge = getChargeHelper();
                               foreach($all_properties as $property2){
                                $charge = getChargeHelper($property2['construction_year'],$property2['property_new_status']);
                                     $j++;
                                    if($totalcount == 0){
                                        $totalcount = $charge; 
                                    }
                                    else {
                                       
                                        $totalcount =  $totalcount+$charge;
                                    }
                                   ?>
                                <li>
                                    Request {{ $i++ }} <strong class="pull-right">${{ $charge }}(AUD)</strong>
                                </li>

                                <?php
                                     }
                                ?>
                                <!--<li>-->
                                <!--    Refferal Amount <strong class="pull-right">$55</strong>-->
                                <!--</li>-->
                                <li class="total">
                                    Total  <strong class="pull-right">${{ $totalcount }}(AUD)</strong>
                                </li>
                            </ul>
                            <input type="hidden" name="total_amount"  id="total_amount" value="{{ $totalcount }}"/>
                            <hr>
                            @if($j==0)
                            <a href="#" class="btn_1">Checkout</a>
                            @else
                            <a href="{{ route('investor.checkout') }}" class="btn_1">Checkout</a>
                            @endif
                            