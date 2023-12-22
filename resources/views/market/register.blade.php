@extends('layout.register_layout')

@section('title', 'Register')

@section('content')
<div class="container text-dark mb-4">
		<section class="my-3 p-3">
				<div class="row">
						<div class="col-lg-12">
								<h1 class="text-center p-3">
										The Wholesale Lounge
			</h1>
			<p class="text-center mtext-115 text-secondary">
				 Your Gateway to Unbeatable Bulk Deals and Business Success
			</p>
						</div>
				</div>
		</section>


		<section class="my-3 p-3">
				<div class="row">
						<div class="col">
								<div class="buyer-card">

								</div>
						</div>
				</div>
		</section>

		<section class="p-3">
				<div class="register-cards mx-auto text-light">
						<div class="card flex-even mt-4">
								<div class="card-body card-buyer">
										<h5 class="card_title"> Join as a Buyer <i class="fa fa-shopping-bag ml-2" aria-hidden="true"></i> </h5>
										<p class="mt-2">Elevate Your Lifestyle with Our Exceptional Products and Unmatched Service!</p>

										<div class="mt-3" style="border: 1px solid #ccc">
										</div>

										<div class="mt-5 p-2 text-light">
											<ul class="register-points">
												<li>
													Shop across the best and verified brands
												</li>
												<li>
													Manage your orders by using our dashboard
												</li>
												<li>
													Subscribe to your favourite vendor and get updates on their recent products
												</li>
												<li>
													Get access to various styles
												</li>
												<li>
														Membership is Free
												</li>
											</ul>
										</div>

										<div class="card_action">
												<a href="{{ route('buyerSignup') }}" class="card_action_text text-light">Register now</a>
										</div>
								</div>
						</div>

						<div class="card flex-even mt-4 ">
								<div class="card-body card-seller">
									<h5 class="card_title">Sell on TheWholeSaleLounge <i class="fa fa-money" aria-hidden="true"></i> </h5>
									<p class="mt-2">Ignite Sale Success and Penetrate Untapped Markets!</p>

									<div class="mt-3" style="border: 1px solid #ccc">
									</div>

									<div class="mt-5 p-2 text-light">
										<ul class="register-points">
											<li>
												Get access to thousands of verified customers daily
											</li>
											<li>
												Get paid and process orders seamlessly and faster
											</li>
											<li>
												100% control on payments
											</li>
											<li>
												Expand your customer base
											</li>
										</ul>
									</div>

										<div class="card_action">
												<a href="{{ route('sellerSignup') }}" class="card_action_text text-light">Register now</a>
										</div>
								</div>
						</div>
				</div>
		</section>
</div>

@endsection
