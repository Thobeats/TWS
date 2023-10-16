<!DOCTYPE html>
<html lang="en">
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha512-uyGg6dZr3cE1PxtKOCGqKGTiZybe5iSq3LsqOolABqAWlIRLo/HKyrMMD8drX+gls3twJdpYX0gDKEdtf2dpmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  {{-- FilePond --}}
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />
    <link
        href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha512-uyGg6dZr3cE1PxtKOCGqKGTiZybe5iSq3LsqOolABqAWlIRLo/HKyrMMD8drX+gls3twJdpYX0gDKEdtf2dpmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput-rtl.min.css">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('css/main.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/bs5-intro-tour.css')}}" rel="stylesheet" />


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>

 <script>

    tinymce.init({
        selector: "textarea#product_description",
        theme: "modern",
        height: 500,
        plugins: [
            "advlist autolink link lists charmap preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
            "table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink| preview fullpage | forecolor backcolor emoticons",
    });

    const socket = new WebSocket("ws://localhost:8080?userID={{ $user->id }}");

    socket.onmessage = (event) => {
        let data = JSON.parse(event.data);
        Livewire.emit('incoming-message', event.data);
    };
  </script>

@livewireStyles
</head>

<body>
  <!-- ======= Header ======= -->
  @include('layout.vendor_header')

  <!-- ======= Sidebar ======= -->
 @include('layout.vendor_sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>@yield('pagetitle')</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/vendor/dashboard">Home</a></li>
          <li class="breadcrumb-item active">@yield('pagetitle')</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  @include('layout.vendor_footer')
  <script src="{{ asset('js/crs.min.js') }}"></script>
  <script src="{{ asset('js/bs5-intro-tour.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  @include('layout.filepond')
@livewireScripts


     <script>
 $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        var steps = [
            {
                title: "Hello",
                content: "<p> Welcome to The Wholesale Lounge, Let's show you around</p>"
            }, {
                id: "first",
                title: "Products",
                content: "<p>Add new products and view all added products</p>"
            },{
                id: "second",
                title: "Orders",
                content: "<p>View all orders from customers</p>"
            }
        ];

        var tour = new Tour(steps);

        document.getElementById('take-a-tour').addEventListener('click', function(){
            tour.show();
        });



        function setShipCharge(e){
            let value = e.target.value;
            let shipCharge = e.target.dataset.ref;

            if(value == 3){
                //set the shipping charge to zero and make it readonly
                $("#"+ shipCharge).val("0.0").attr("readonly",true);
            }else{
                $("#"+ shipCharge).val("").attr("readonly",false);
            }
        }
        // Get a file input reference
        const input = document.querySelector('#pics');
        const business = document.querySelector('#business');

        //Register FilePond functions
        FilePond.registerPlugin(
          FilePondPluginImagePreview,
          FilePondPluginFileValidateSize,
          FilePondPluginFileValidateType
        );

        // Create a FilePond instance
        FilePond.create(input, {
            storeAsFile: true,
            acceptedFileTypes: ['image/png','image/jpg','image/jpeg'],
            allowImageValidateSize: true,
            maxFileSize: "1MB",
            minFileSize: "100KB",
            imagePreviewHeight: 170,
            maxFiles : 3,
            files : [
            <?php
            if(isset($images)):
                foreach($images as $image){
            ?>
                {
                    source : "/storage/products/{{$image}}"
                },
            <?php } endif; ?>
            ],
            labelMaxFileSize: "Maximum file size is {filesize}",
            server : {
                process : "/api/saveImage/products",
                revert : (fileName)=>{
                    console.log(fileName)
                    fetch(`/api/deleteImage/products?fileName=${fileName}`, {
                          method: "DELETE"
                        }).then(res => res.text())
                          .then(text => {
                              console.log(text)
                          });
                },
                headers:{
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                }
            }
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('input[type="checkbox"]'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html,{size: 'small'});
        });

    </script>



</body>

</html>
