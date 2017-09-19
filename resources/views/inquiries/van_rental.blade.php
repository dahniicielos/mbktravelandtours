@extends('master')

@section('meta-description', 'Van Rental with MBK, Madya Byahe kita. A Travel and Tour Agency based in Naga City, Camarines Sur, Philippines')
@section('meta-keywords', 'van, rental, vans, inquiry, travel, travels, tour, tours, naga, camarines, sur, mbk, madya, biyahe, kita')

@section('modified-style')

	<style type="text/css">
		#header{
			position: relative;
			float: left;
			width: 100%;
			background: url('{!! url('/') !!}/assets/images/van_header.jpg') center no-repeat;
			background-size: cover;
			background-attachment: fixed;
		}

		#header-content{
			position: relative;
			float: left;
			width: 66.66666667%;
			height: 100%;
			margin: 120px 16.66666667%;
		}

		.title{
			margin-bottom: 5px;
		}

		.media .text-blue{
			margin: 5px 0px 0px 0px;
		}

		#payment-swiper{
			width: 100%;
			height: 70px;
			margin-top: 20px;
		}

		#payment-swiper img{
			height: 100%;
		}

		#logo-swiper{
			width: 100%;
			height: 125px;
			margin-top: 30px;
		}

		#logo-swiper img{
			height: 100%;
		}

		.dropdown-flight {
			margin: 50px auto;
			max-width: 300px;
		}

		.dropdown-flight-menu {
		  li {
		    &+ li {
		    	margin-top: 10px;
		    }
		    a {
				padding: 5px 0 5px 55px;
				min-height: 50px;
				position: relative;
				white-space: normal;

		    }
		  }
		  .typeahead-inner {
		    .item-img {
				width: 40px;
				height: 40px;
				position: absolute;
				left: 5px;
				top: 5px;
				background-size: cover;
				background-position: center;
				background-repeat: no-repeat;
				border-radius: 5px;
		    }
		    
		    .item-heading {
				display: inline-block;
				vertical-align: middle;
				line-height: 18px;
		    }
		  }
		}

		.cc-selector input{
		    margin:0;
		    padding:0;
		    -webkit-appearance:none;
		    -moz-appearance:none;
		    appearance:none;
		    display: none;
		}

		.cc-selector input:active +.van-cc{opacity: .9;}
		.cc-selector input:checked +.van-cc{
		    -webkit-filter: none;
		       -moz-filter: none;
		            filter: none;
		}

		.van-cc{
		    cursor:pointer;
		    background-size:contain;
		    background-repeat:no-repeat;
		    display:inline-block;
		    width: 100%;
		    height: 150px;
		    -webkit-transition: all 100ms ease-in;
		       -moz-transition: all 100ms ease-in;
		            transition: all 100ms ease-in;
		    -webkit-filter: brightness(0.5) grayscale(1) opacity(0.7);
		       -moz-filter: brightness(0.5) grayscale(1) opacity(0.7);
		            filter: brightness(0.5) grayscale(1) opacity(0.7);
		}

		.van-cc:hover{
		    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
		       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
		            filter: brightness(1.2) grayscale(.5) opacity(.9);
		}

		.van-desc{
			font-size: 12px;
		}

		.ad_image{
			content: url('{!! url('/') !!}/assets/images/ads/ad_landscape.jpg');
		}


		/* tablet */
		@media (max-width: 768px) and (min-width: 426px){
			#header,
			#header-content{
				height: auto;
			}

			.swiper-container{
				width: 90%;
			}
		}

		/* mobile */
		@media (max-width: 425px){
			#header,
			#header-content{
				height: auto;
			}

			#header-content{
				width: 90%;
				margin: 0px 5%;
				padding-bottom: 50px;
			}

			#header-content .card{
				position: relative;
				top: 0px;
				margin-top: 25%;
			}

			.swiper-container{
				width: 95%;
			}

			.ad_image{
				content: url('{!! url('/') !!}/assets/images/ads/ad_landscape_two.jpg');
			}
		}
	</style>
@endsection

@section('title', 'MBK - Van Rental Inquiry')

@section('content')
    <!-- Main content -->
	<div id="header">
		<div class="fill">
			<div id="header-content">
				<div class="card gardient-blue">
					{!! Form::open(['id' => 'flight-form', 'data-toggle' => 'validator', 'role' => 'form']) !!}
						<div class="row">
							<div class="head">
								<h4 class="title text-blue text-uppercase"><b>Van Rental Inquiry Form</b></h4>
								<small class="desc">Please fill out the form completely and we'll get right back to you through your email address</small>
							</div>
							<div class="body">
								<div class="row">
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											{!! Form::label('location_from', 'FROM', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('location_from', '', ['class' => 'form-control', 'id' => 'location_from', 'required' => 'required', 'placeholder' => 'Enter location']) !!}
												</div>
											</div>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											{!! Form::label('location_to', 'TO', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('location_to', '', ['class' => 'form-control', 'id' => 'location_to', 'required' => 'required', 'placeholder' => 'Enter location']) !!}
												</div>
											</div>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											{!! Form::label('rental_day_start', 'RENTAL DATE', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('rental_day_start', old('rental_day_start', date('Y-m-d')), ['class' => 'form-control', 'id' => 'van-rental_day_start', 'placeholder' => 'MM/DD/YYYY', 'onkeydown' => 'return false', 'required' => 'required']) !!}
												</div>
											</div>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="date_return_container">
										<div class="form-group">
											{!! Form::label('rental_day_end', 'RETURN DATE', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('rental_day_end', old('rental_day_end', date('Y-m-d')), ['class' => 'form-control', 'id' => 'van-rental_day_end', 'placeholder' => 'MM/DD/YYYY', 'onkeydown' => 'return false', 'required' => 'required']) !!}
												</div>
											</div>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label class="form-label">DESIRED VAN</label>
										</div>
									</div>
								</div>
								<div class="row cc-selector">
									<?php $counter = 0; ?>
									@foreach ($vans as $van)
										<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
											<div class="form-group">
												<input type="radio" id="van_{!! $van->id !!}" name="van_id" value="{!! $van->id !!}" 
												@if (old('van_id') != '' || old('van_id') != null)
													@if (old('van_id') == $van->id)
														checked="checked"
													@endif
												@else
													@if ($counter == 0)
														checked="checked"
													@endif
												@endif
												>
												<label class="van-cc van_{!! $van->id !!}" for="van_{!! $van->id !!}" style="background: url('{!! url('/') !!}/{!! $van->van_image !!}') center no-repeat; background-size: cover;"></label>
												<p class="van-desc">
												{!! $van->description !!}<br>
												<b>No. of Seats: {!! $van->no_of_seats !!}</b>
												</p>
											</div>
										</div>
									<?php $counter++; ?>
									@endforeach
								</div>
							</div>
							<div class="footer">
								<?php
									$full_name = "";
									$birthday  = "";
									$phone_number  = "";
									$email  = "";
									if (Auth::check()) {
										//------------ OLD VARIABLES ------------//
										$old_full_name = old('full_name');
										$old_birthday = old('birthday');
										$old_phone_number = old('phone_number');
										$old_email = old('email_address');

										//FULL NAME
										if (!empty($old_full_name)) {
											$full_name = $old_full_name;
										}
										else {
											$full_name = Auth::user()->first_name." ".Auth::user()->last_name;
										}
										
										
										//BIRTHDAY
										if (!empty($old_birthday)) {
											$birthday = date("m/d/Y", strtotime($old_birthday));
										}
										else if (!empty(Auth::user()->birthday)) {
											$birthday = date("m/d/Y", strtotime(Auth::user()->birthday));
										}
										else {
											$birthday = "";
										}
										//PHONE NUMBER
										if (!empty($old_phone_number)) {
											$phone_number = $old_phone_number;
										}
										else if (!empty(Auth::user()->phone_number)) {
											$phone_number = Auth::user()->phone_number;
										}
										else {
											$phone_number = "";
										}


										//E-MAIL ADDRESS
										if (!empty($old_email)) {
											$email = $old_email;
										}
										else {
											$email = Auth::user()->email;
										}
									}
								?>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											{!! Form::label('name', 'FULL NAME', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('name', $full_name, ['class' => 'form-control number-only', 'id' => 'name', 'placeholder' => 'Enter Full Name', 'required' => 'required']) !!}
												</div>
											</div>
    										<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											{!! Form::label('birthday', 'BIRTHDAY', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('birthday', $birthday, ['class' => 'form-control', 'id' => 'birthday', 'placeholder' => 'MM/DD/YYYY', 'required' => 'required', 'onkeydown' => 'return false']) !!}
												</div>
											</div>
    										<div class="help-block with-errors"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											{!! Form::label('phone_number', 'PHONE NUMBER', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::text('phone_number', $phone_number, ['class' => 'form-control number-only', 'id' => 'phone_number', 'placeholder' => 'Enter Phone No', 'required' => 'required', 'pattern' => '^([0-9+]{1,2})?\(?[0-9]{3}\)?[.-]?[0-9]{3}[.-]?[0-9]{4,5}$']) !!}
												</div>
											</div>
    										<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											{!! Form::label('email_address', 'EMAIL ADDRESS', ['class' => 'form-label']) !!}
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
													{!! Form::email('email_address', $email, ['class' => 'form-control', 'id' => 'email_address', 'placeholder' => 'Enter Email Address', 'required' => 'required']) !!}
												</div>
											</div>
    										<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right" style="padding-top: 10px">
										{!! Form::button('RESET', $attributes = array('type' => 'reset', 'id' => 'reset_btn', 'class' => 'btn btn-default text-uppercase')) !!}
                            			{!! Form::button('Submit', $attributes = array('type' => 'submit', 'class' => 'btn btn-primary text-uppercase')) !!}
									</div>
								</div>
							</div>
						</div>
					
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		@include('shared.steps', ['step_title' => 'VAN RENTAL', 'service_name' => 'van rental'])
		@include('shared.faqs', ['service_name' => 'van rental'])
	</div>


	@include('shared.ad_space')
	
@endsection

@section('modified-script')
	<script type="text/javascript">
		

		$(document).ready(function() {
			$("#location").select2();

			<?php 
				$rental_day_start = "";
				$rental_day_end = "";

				$old_rds = old('rental_day_start');
				$old_rde = old('rental_day_end');

				if (!empty($old_rds)) {
					$rental_day_start = date("m/d/Y", strtotime($old_rds));
				}
				else {
					$rental_day_start = "";
				}

				if (!empty($old_rde)) {
					$rental_day_end = date("m/d/Y", strtotime($old_rde));
				}
				else {
					$rental_day_end = "";
				}
			?>
			$("#van-rental_day_start").datetimepicker({
				minDate: moment(),
				date: '{!! $rental_day_start !!}',
				format: 'MM/DD/YYYY',
				icons: {
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right'
				}
			});

			$("#van-rental_day_end").datetimepicker({
				minDate: moment(),
				date: '{!! $rental_day_end !!}',
				format: 'MM/DD/YYYY',
				icons: {
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right'
				}
			});

			$("#van-rental_day_start").on("dp.change", function(e){
				$("#van-rental_day_end").data("DateTimePicker").minDate(e.date);
			});

			$("#birthday").datetimepicker({
				maxDate: moment(),
				date: '{!! $birthday !!}',
				format: 'MM/DD/YYYY',
				icons: {
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right'
				}
			});
		});
	</script>
@endsection
