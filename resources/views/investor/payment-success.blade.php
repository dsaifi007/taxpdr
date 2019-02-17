@extends('layouts.investor_app')
@section('content')
		<section class="my-request payment-success section-min-h">
		        <div class="auto-container">
		            <div class="order-success">
		                <i class="fa fa-check"></i>
		                <h6>{{ trans('messages.thank_you_payment') }}</h6>
		                <a href="{{ route('home-new') }}" class="btn-round">Return to Home</a>
		            </div>
		        </div>
		    </section>

 @endsection
<!-- include page js script - - - -->
@section('java-script')

@endsection