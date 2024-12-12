@include('layouts.header')
@include('layouts.app')
@auth
@include('layouts.sidebar')
@endauth

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

@include('layouts.nav')
<body class="dark">

<div class="p-b-50 d-block d-lg-none"></div>

<div class="container">
    <div class="row align-items-md-center">

         <!--start of:update put before form-->

        <div class="col-lg-6 offset-lg-3">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h4 class="m-b-20"></h4>
            <div class="card">
            <div class="card-body">
            <p class="m-b-20">Set Password</p>
            <form method="POST" action="{{ route('setPassword') }}">
                @csrf
            <!--end of:update put before form-->

                <div class="form-group mb-4">
                    <input type="text" name="email" class="form-control form-control-lg" value="{{$email}}" readonly>
                </div>
                <div class="form-group mb-4">
                     <label for="">Password</label>
                    <input type="password" name="password" minlength="5" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required> 
                </div>
                 <div class="form-group mb-4">
                     <label for="">Confirm Password</label>
                    <input type="password" name="password_confirmation" minlength="5" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">Submit</button>
                <div class="d-flex justify-content-between align-items-center mb-4">

                </div>
            </div>
        </div>
            </form>
        </div>
    </div>
</div>


</body>


<script src="{{ asset('vendors/bundle.js') }}"></script>

<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="{{ asset('js/borderless.min.js') }}"></script>

<!-- end::custom scripts -->
  <script src="{{ asset('js/toastr.min.js') }}"></script>
  <script type="text/javascript">

    toastr.options.preventDuplicates = true;
    @if (session('success'))
    toastr.success("{{session('success')}}");
    @endif

    @if (session('error'))
    toastr.error("{{session('error')}}");
    @endif

    @if (session('info'))
    toastr.info("{{session('info')}}");
    @endif

  </script>

</body>
</html>
