<footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Crea8ifHub</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  {{-- <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script> --}}
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" integrity="sha512-lC8vSUSlXWqh7A/F+EUS3l77bdlj+rGMN4NB5XFAHnTR3jQtg4ibZccWpuSSIdPoPUlUxtnGktLyrWcDhG8RvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="https://js.stripe.com/v3/"></script>

  <script>
    var stripe = Stripe("{{ env('STRIPE_PUBLIC') }}");
    const elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
      const style = {
        base: {
            // Add your base input styles here. For example:
            fontSize: '16px',
            color: '#32325d',
        },
      };

      // Create an instance of the card Element.
      const card = elements.create('card', {style});
      // Add an instance of the card Element into the `card-element` <div>.
      card.mount('#card-element');

      $("#payment-form").submit(function(e){
        e.preventDefault();

        stripe.createToken(card,{'currency':'USD'}).then(function(result) {
            // Handle result.error or result.token
            let token = JSON.stringify(result);
            let data = {
                "_token": "{{ csrf_token() }}",
                "card" : token
            };
            $.post('/vendor/account/saveCard',data,function(response){
                if(response.code == 1){
                    alert('Card not saved, please try again');
                }else{
                    location.href = '/vendor/get_started';
                }
            });


        });

        stripe.createPaymentMethod({
                    type: 'card',
                    card: card
                })
                .then(function(result) {
                    // Handle result.error or result.paymentMethod
                    // console.log(result);
                    let token = JSON.stringify(result);

                    let data = {
                        "_token": "{{ csrf_token() }}",
                        "card" : token
                    };

                    $.post('/vendor/account/createPaymentMethod',data,function(response){
                        if(response.code == 1){
                            alert("Payment Method not set");
                        }
                    });
                });


     });

</script>
