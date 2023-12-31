<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
<!--===============================================================================================-->
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/linearicons-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/MagnificPopup/magnific-popup.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
<!--===============================================================================================-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>
<body class="animsition h-auto {{$data}}">

<section class="d-flex flex-column justify-content-center align-items-center py-5">
    <div>
        <a href="{{ route('home') }}">
            <img src="/images/logo.png" alt="" width="200px">
        </a>
    </div>
    @yield('form')

    {{-- Confirm Email Modal --}}
    <div class="modal" id="confirmEmail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Verify Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <label class="h4">Enter OTP</label>
                    <input type="number" name="otp" maxlength="6" class="p-2 text-center border" oninput="cofirmOtp(event)">
                    <div id="otp-action" class="text-center mt-2 h5"></div>

                    <div class="mt-3">
                        didn't get the otp? <a href="#" onclick="resendOTP()">Resend OTP</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

</section>


<!--===============================================================================================-->
	<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('js/slick-custom.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

	</script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                tags : true
            });
        });
    </script>
    <script>
        $('#certFile').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            fileName = fileName.replace("C:\\fakepath\\", "");
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        $('.custom-file-input').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            fileName = fileName.replace("C:\\fakepath\\", "");
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })
    </script>
    {{-- Handle Buyer SignUp --}}

    <script>

        var count = 5*60;
        var timer;

        function validationHandler(target, value){
            let input = document.getElementById(`${target}_error`);
            for (c in value){
                input.innerHTML +=  `<span class='text-danger'>${value[c]}</span> <br><br>`;
            }

            input.style.display = 'block';
        }

        function sendOtp(email){
            fetch(`/sendotp/${email}`)
            .then(res => res.json())
            .then(json => {
                console.log(json);
                if (json.code == 0){
                    // Send OTP to the email
                    toastr.success(json.message)
                    timer = setInterval(countTime, 1000);
                }
            });
        }


        function cofirmOtp(event){
            let otp = event.target.value;
            let email = document.getElementById('email').value;

            if (otp.length == 6){
                fetch(`/confirmOtp/${email}`,{
                    method : "POST",
                    body : JSON.stringify({ "token" : otp }),
                    headers : {
                        "X-CSRF-TOKEN" : "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(json => {
                    if (json.status == true){
                        //Submit the form
                        $('form').submit();
                    }
                });
            }
        }

        function countTime(){
          count--;

          let minute = Math.floor(count / 60);
          let seconds = Math.floor(count % 60);

          if(count == 0){
            clearInterval(timer);
          }

          let template = `
            <span>${minute} : ${seconds} </span>
          `;

          $("#otp-action").html(template)

        }

        function resendOTP(){
            clearInterval(timer);
            count = 5*60;
            let email = document.getElementById('email').value;
            sendOtp(email);

        }

        function showOtpModal(){
            let email = document.getElementById('email').value;
            sendOtp(email);
            $("#confirmEmail").modal('show');
        }

        function registerBuyer(){
            let buyerdata = $("#BuyerForm").serialize();

            //Validate the Buyer details
            fetch('/validate/buyer',{
                method : "POST",
                body : buyerdata,
                headers : {
                    "X-CSRF-TOKEN" : "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(json => {
                console.log(json);
                $(".invalid-feedback").html('');
                if (json.code == 1){
                    // Validation Error
                    for(x in json.data){
                        let inputError = x.split(".");
                        console.log(json.data);
                        validationHandler(inputError[0], json.data[x]);
                    }
                }

                if (json.code == 0){
                    // Send OTP to the email
                    showOtpModal();
                }
            });
        }

        function registerSeller(){
            let sellerdata = $("#sellerForm").serialize();

            //Validate the Seller details
            fetch('/validate/seller',{
                method : "POST",
                body : sellerdata,
                headers : {
                    "X-CSRF-TOKEN" : "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(json => {
                console.log(json);
                $(".invalid-feedback").html('');
                if (json.code == 1){
                    // Validation Error
                    for(x in json.data){
                        let inputError = x.split(".");
                        console.log(json.data);
                        validationHandler(inputError[0], json.data[x]);
                    }
                }

                if (json.code == 0){
                    // Send OTP to the email
                    showOtpModal();
                }
            });


        }
    </script>




<!--===============================================================================================-->
	<script src="{{ asset('js/main.js') }}"></script>
    <script src="{{asset('assets/js/apicalls.js')}}"></script>
</body>
</html>
