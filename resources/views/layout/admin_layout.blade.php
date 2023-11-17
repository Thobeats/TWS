<!DOCTYPE html>
<html lang="en">

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
    @livewireStyles


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  @include('layout.admin_header')

  <!-- ======= Sidebar ======= -->
 @include('layout.admin_sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>@yield('pagetitle')</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/admin">Home</a></li>
          <li class="breadcrumb-item active">@yield('pagetitle')</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  @include('layout.admin_footer')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  @include('layout.filepond')
  @livewireScripts

  <script>
    tinymce.init({
        selector: "textarea#details",
        theme: "modern",
        height: 500,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
    });
  </script>
  <script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html,{size: 'small'});
    });


     // Get a file input reference
     const input = document.querySelector('#image');

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
        minFileSize: "10KB",
        imagePreviewHeight: 170,
        maxFiles : 3,
        files : [
        <?php
        if(isset($image)):
        ?>
            {
            source : "/storage/slides/{{$image}}"
            },
        <?php endif; ?>
        ],
        labelMaxFileSize: "Maximum file size is {filesize}",
        server : {
            process : "/api/saveSlide",
            revert : (fileName)=>{
                console.log(fileName)
                fetch(`/api/deleteImage/slides?fileName=${fileName}`, {
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

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    function selectPackage(e){

        let packageId = e.target.value;

        if (packageId != ""){
            $.get(`/api/package/${packageId}`, function(res){
                if (res.code == 0){
                  console.log(res.response.package_name);
                  document.getElementById("pack_name").innerHTML = res.response.package_name;
                  $('#package_price').text('$' + res.response.package_price);
                  $('#multiplier').val(res.response.package_price);
                  $('#total_price').text(res.response.package_price);


                  document.querySelector('.package_details').classList.remove('d-none');

                }else{
                  if(!document.querySelector('.package_details').classList.contain('d-none')){
                    document.querySelector('.package_details').classList.add('d-none');
                  }

                }
            }, 'json');
        }else{
          if(!document.querySelector('.package_details').classList.contains('d-none')){
            document.querySelector('.package_details').classList.add('d-none');
          }

        }
    }

  </script>


</body>

</html>
