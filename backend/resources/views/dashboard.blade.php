@include('layouts.header')

<body class="light white-content">
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            @include('layouts.nav')

            <div class="content">

                @if (session('success'))
                    <div class="alert alert-success alert-with-icon" data-notify="container">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <i class="fa fa-window-close icon-simple-remove"></i>
                        </button>
                        <span data-notify="icon" class="fa fa-window-close icon-bell-55"></span>
                        <span data-notify="message">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <i class="fa fa-window-close icon-simple-remove"></i>
                        </button>
                        <span data-notify="icon" class="fa fa-window-close icon-bell-55"></span>
                        <span data-notify="message">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-body">
                            <h4> Welcome, {{ Auth::user()->name }} </h4>
                        </div>
                    </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card text-center p-3 shadow-sm border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="status-dot bg-success"></div>
                                        <h5 class="card-category ml-2">Total Customers</h5>
                                    </div>
                                    <h1 class="card-title mt-3">{{ $total_users ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card text-center p-3 shadow-sm border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="status-dot bg-success"></div>
                                        <h5 class="card-category ml-2">Active Orders</h5>
                                    </div>
                                    <h1 class="card-title mt-3">{{ $active_orders ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card text-center p-3 shadow-sm border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="tim-icons icon-box-3 text-primary"></i>
                                        <h5 class="card-category ml-2">Searching</h5>
                                    </div>
                                    <h1 class="card-title mt-3">{{ $searching_orders ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card text-center p-3 shadow-sm border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="tim-icons icon-delivery-fast text-primary"></i>
                                        <h5 class="card-category ml-2">On-Transit</h5>
                                    </div>
                                    <h1 class="card-title mt-3">{{ $on_transit_orders ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card text-center p-3 shadow-sm border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="tim-icons icon-check-2 text-primary"></i>
                                        <h5 class="card-category ml-2">Delivered</h5>
                                    </div>
                                    <h1 class="card-title mt-3">{{ $delivered_orders ?? 0 }}</h1>
                                </div>
                            </div>
                        </div>

                   

                </div>


            </div>

        </div>
    </div>
    @include('layouts.footer')
    </div>
    </div>
    <script src="{{ asset('assets/vendors/charts/morsis/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/charts/morsis/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/examples/charts/morsis.js') }}"></script>
    <script src="{{ asset('assets/vendors/charts/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/examples/charts/chartjs.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs.min.js') }}"></script>
    <script>
        function copyText(element) {
            var range, selection, worked;

            if (document.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }

            try {
                document.execCommand('copy');
                document.getElementById("copied").innerHTML = "Referral link Copied !";

                // alert('text copied');
            } catch (err) {
                // alert('unable to copy text');
            }
        }
    </script>
