@include('layouts.app')


@include('frontend.navbar')

<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <div style="color: #ffffff" class="col-md-6 mx-auto">
          <h2 >Privacy Policy</h2>
          <p>Last updated: 9th, December 2024</p>
      </div>
    </div>
</section>

<!-- Privacy Section -->
<section class="privacy">
    <div class="container">
        <p>Privacy Policy Content here</p>
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