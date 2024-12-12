<footer class="footer mx-auto" style="position: fixed; right: 0; left: 0; bottom: 0;">
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
      <div id="google_translate_element"></div>
    </footer>
</div>
</div>

<!--   Core JS Files   -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],

        });
    });
    $(".buttons-html5").addClass("btn");
    $(".buttons-html5").addClass("btn-success");

    $(document).ready(function() {
        $('#myTable2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });


    $(document).ready(function() {
        $('#myTable3').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>

<!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/js/black-dashboard.min.js') }}"></script>
<!-- Black Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets/demo/demo.js') }}"></script>
<script>
    function loadPreview(input, id) {
        console.log("fibjfi")
        id = id || '#preview_img';
        if (input.files && input.files[]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
            };

            reader.readAsDataURL(input.files[]);
        }
    }
</script>

</body>

</html>
