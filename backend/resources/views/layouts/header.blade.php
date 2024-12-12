
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="https://cdn.prod.website-files.com/662c95fd6e0e4feedf85ad95/6641b0ea5a0e51161080324b_3%20(1)-p-500.png">

  <title>
  Rodudapp Admin
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" />

  <meta name="csrf-token" content="{{ csrf_token() }}">


  <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/css/black-dashboard.css') }}" rel="stylesheet" />

  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <style>
      .content{
        padding-bottom: 50px !important;
      }

      .buttons-html5{
        border-width: 2px !important;
        border: none !important;
        position: relative !important;
        overflow: hidden !important;
        margin: 4px 1px !important;
        border-radius: 0.4285rem !important;
        cursor: pointer !important;
        background: #344675 !important;
        background-image: -webkit-linear-gradient(to bottom left, #344675, #263148, #344675) !important;
        background-image: -o-linear-gradient(to bottom left, #344675, #263148, #344675) !important;
        background-image: -moz-linear-gradient(to bottom left, #344675, #263148, #344675) !important;
        background-image: linear-gradient(to bottom left, #344675, #263148, #344675) !important;
        background-size: 210% 210% !important;
        background-position: top right !important;
        background-color: #344675 !important;
        transition: all 0.15s ease !important;
        box-shadow: none !important;
        color: #ffffff !important;
        margin-bottom: 20px
      }
    </style>
<script>
  tinymce.init({
    selector: 'textarea#editor',
    menubar: false
  });
</script>

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
  }
  </script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>
