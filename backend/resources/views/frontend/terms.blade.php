@include('layouts.app')
<body>

  @include('frontend.navbar')

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <div style="color: #ffffff" class="col-md-6 mx-auto">
          <h2 >Terms and Conditions</h2>
          <p>Last updated: 9th, December 2024</p>
      </div>
    </div>
  </section>

<!-- Services Section -->
<section  class="terms">
    <div class="container">
        <p>Terms and Conditions Content here</p>
    </div>
  </section>



<script>
  document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>