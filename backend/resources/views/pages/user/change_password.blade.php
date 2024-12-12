@include('layouts.header')
@include('layouts.app')

<body class="dark">

    <!-- end::horizontall scroll table -->

    <!-- begin::page loader-->
    <div class="page-loader">
        <div class="spinner-border"></div>
        <span>Loading</span>
    </div>
    <!-- end::page loader -->

    @include('layouts.sidebar')

    @include('layouts.nav')

    <!-- begin::main content -->
    <main class="main-content">

        <div class="mt-3 container">

            <!-- begin::page header -->
            <div class="page-header d-md-flex align-items-center justify-content-between">
                <div>
                    <h3>Change Password</h3>
                </div>
            </div>
            <!-- end::page header -->


            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                    {{ session('error')}}
                </div>
                @endif
                @if (session('status'))
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                    {{ session('status')}}
                </div>
                @endif

            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title"></h6>
                                    <h6 class="card-subtitle"></h6>
                                </div>
                            </div>
                            <div>
                                <form class="" action="{{ route('change_user_password') }}" method="post">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Old Password</label>
                                                <input type="password" name="old_password" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" name="new_password" minlength="5" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Confirm New Password</label>
                                                <input type="password" name="confirm_new_password" minlength="5" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" name="button" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>
    <!-- end::main content -->

    <!-- begin::global scripts -->
    <script src="../assets/vendors/bundle.js"></script>
    <!-- end::global scripts -->

    <!-- begin::vamp -->
    <script src="../assets/vendors/vmap/jquery.vmap.min.js"></script>
    <script src="../assets/vendors/vmap/maps/jquery.vmap.usa.js"></script>
    <script src="../assets/js/examples/vmap.js"></script>
    <!-- end::vamp -->

    <!-- begin::custom scripts -->
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/borderless.min.js"></script>
    <!-- end::custom scripts -->


</body>

</html>