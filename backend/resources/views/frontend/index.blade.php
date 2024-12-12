@include('layouts.app')

@include('frontend.navbar')

<!-- Header Section -->
<section class="header-section">
    <div class="container">
      <div class="row">
        <div class="col-md-6 left-col">
            <span class="badge badge-primary">Signup Free</span>
            <span class="badge badge-warning">Fast</span>
            <span class="badge badge-success">Secure</span>
            <span class="badge badge-info">User friendly</span>
          <h2>Redefining Freight
            Operations</h2>
          <p>Manage your carriers, shippers, and drivers efficiently with our platform. Get real-time tracking of trucks, and track the progress and status of your shipments.</p>
          <div>
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
          </div>
        </div>
        <div class="col-md-6 app-screenshot">
          <img src="https://cdn.prod.website-files.com/662c95fd6e0e4feedf85ad95/6694dc67e131a57219592ef5_DAssign-p-1080.png" alt="App Screenshot" class="app-image d-none d-md-block">
        </div>
      </div>
    </div>
  </section>

  @include('layouts.footer')
<script>
  document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
