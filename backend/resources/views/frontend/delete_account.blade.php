<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rodudapp</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Rodudapp">
  <link rel="icon" href="/favicon.ico">
  
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  {{-- font awesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  
  <!-- Social Media Meta Tags -->
  <meta property="og:title" content="Rodudapp">
  <meta name="twitter:card" content="summary_large_image">
  
  <!-- Additional Meta Tags for SEO -->
  <meta name="robots" content="index, follow">
  <meta name="theme-color" content="#0051ba">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .navbar {
      background-color: #ffffff;
    }
    .navbar-brand, .nav-link {
      color: #0051ba !important;
    }
    .navbar-brand {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .nav-link {
      font-size: 1.1rem;
      margin-left: 15px;
    }
    .nav-link:hover {
      color: #ff5722 !important;
    }
    .navbar-toggler {
      border-color: rgba(255, 255, 255, 0.1);
    }
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28155, 155, 155, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
    .header-section {
      background-color: #0051ba;
      background-image: url("{{ asset('/images/bg.png') }}");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      padding: 100px 0;
      text-align: left;
    }
    .header-section h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .header-section p {
      font-size: 1.25rem;
      margin-bottom: 20px;
    }
    .left-col{
      text-align: left;
      /* background-color: #0051ba; */
      color: white;
      margin-top: 100px;
    }
    .app-image {
      max-width: 700px;
      margin: 0 auto;
      display: block;
    }
    .download-buttons {
      margin-top: 30px;
      display: flex;
      justify-content: left;
    }
    .download-buttons-footer {
      margin-top: 30px;
      display: flex;
      justify-content: center;
    }
    .download{
      background-color: #0051ba;
      padding: 100px 0;
      color: white;
      text-align: center;
    }
    .download-buttons img {
      width: 150px;
    }
    .download-buttons a {
      background-color: #ffffff;
      font-size: 1.25rem;
      border: none;
      border-radius: 5px;
      text-transform: uppercase;
      text-decoration: none;
      margin-right: 10px;
    }
    .download-buttons a:hover {
      background-color: #ffffff;
    }
    .app-screenshot {
      text-align: center;
    }
    section{
      padding: 50px 0;
    }
    .services {
      background-color: #F3F6FF;
      padding: 50px 0;
      text-align: center;
    }
    .services h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .remita-service-card {
       height: 250px; 
      border: none;
      border-radius: 10px;
      margin: 10px 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .service-card {
      height: 300px;
      background-color: #fff;
      border: none;
      border-radius: 10px;
      padding: 20px;
      margin: 10px 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .service-card img {
      width: 50px;
      margin-bottom: 15px;
    }
    .service-card h4 {
      font-size: 1.25rem;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .service-card p {
      font-size: 1rem;
      color: #666;
    }

    .footer {
      background-color: #0051ba;
      color: white;
      padding: 20px 0;
      /* text-align: center; */
    }
    /* Responsive Styles */
    @media (max-width: 768px) {
      .header-section {
        padding: 60px 0;
        text-align: center;
      }
      .header-section h2 {
        font-size: 2rem;
      }
      .header-section p {
        font-size: 1rem;
      }
      .left-col {
        margin-top: 50px;
        text-align: center;
      }
      .app-image {
        max-width: 100%;
      }
      .download-buttons {
        flex-direction: column;
        align-items: center;
      }
      .download-buttons a {
        margin: 10px 0;
      }
      .service-card {
        height: auto;
        padding: 15px;
      }
    }
  
    @media (max-width: 576px) {
      .navbar-brand {
        font-size: 1.2rem;
      }
      .nav-link {
        font-size: 1rem;
        margin-left: 5px;
      }
      .header-section h2 {
        font-size: 1.75rem;
      }
      .header-section p {
        font-size: 0.9rem;
      }
      .service-card h4 {
        font-size: 1rem;
      }
      .service-card p {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>

@include('frontend.navbar')

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <div style="color: #ffffff" class="col-md-6 mx-auto">
          <h2 >We’re Sad to Let You Go</h2>
          <p>If you wish to delete your account, please enter your email address below.</p>
      </div>
    </div>
</section>

<!-- Privacy Section -->
<section class="privacy">
    <div class="container">
    <form action="{{ route('submit.deletion') }}" method="POST">
        @csrf
        <div class="form mb-4">
          <div class="form-group col-md-12">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
              @error('email') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="form-group col-md-12">
            <button class="btn btn-danger" type="submit">Request Account Deletion</button>
          </div>
      </div>

    </form>
        
    </div>
</section>

{{-- @include('frontend.download') --}}

@include('frontend.footer')


<script>
  document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>