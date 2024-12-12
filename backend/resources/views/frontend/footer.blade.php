
<!-- Footer -->
<footer class="footer" id="footer" style="background-color: #1a1a1a; color: #fff; padding: 40px 0; position: relative;">
    <div class="container">

      <!-- Legal Links and Copyright -->
      <div class="row mt-4">
        <div class="col-md-12 text-center">
          <ul class="list-inline">
            <li class="list-inline-item"><a href="/privacy" class="text-light" style="text-decoration: underline;">Privacy Policy</a></li>
            <li class="list-inline-item"><a href="/terms" class="text-light" style="text-decoration: underline;">Terms of Service</a></li>
          </ul>
          <p>&copy; <span id="currentYear"></span> Rodudapp. All rights reserved.</p>
        </div>
      </div>
    </div>
  
    <!-- Add subtle animations -->
    <style>
      .footer {
        background: #1a1a1a;
      }
      .footer h5 {
        color: #ffffff;
        border-bottom: 2px solid #ffbb00;
        padding-bottom: 10px;
      }
      .footer p, .footer a {
        color: #ddd;
      }
      .footer .social-links a {
        transition: color 0.3s ease, transform 0.3s ease;
      }
      .footer .social-links a:hover {
        color: #ffbb00;
        transform: translateY(-3px);
      }
      .footer ul li a:hover {
        color: #ffbb00;
      }
      .footer ul {
        padding-left: 0;
        list-style-type: none;
      }
      .footer p {
        margin-bottom: 0;
      }
    </style>
  
    <script>
      document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
  </footer>
  
