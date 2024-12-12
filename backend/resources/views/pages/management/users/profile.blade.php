@include('layouts.header')

<body class="light white-content">
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            @include('layouts.nav')

            <div class="content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                @if (session('success'))
                                    <div class="alert alert-success alert-with-icon" data-notify="container">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                        <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                                        <span data-notify="message">{{ session('success') }}</span>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-with-icon" data-notify="container">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                        <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                                        <span data-notify="message">{{ session('error') }}</span>
                                    </div>
                                @endif
                                <h5 class="title">UPDATE YOUR PROFILE</h5>
                            </div>
                            <div class="card-body">
                                <form class="" action="{{ route('update.user') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 pr-md-1">
                                            <div class="form-group">
                                                <label>Full name</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Name" value="{{ $user->name }}">
                                                <input type="text" class="form-control" name="id" hidden
                                                    value="{{ $user->id }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 pl-md-1">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input readonly type="email" name="email" class="form-control"
                                                    placeholder="{{ $user->email }}">
                                            </div>
                                        </div>
                                    </div>
                                  

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-primary">Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                <div class="author">
                                    <div class="block block-one"></div>
                                    <div class="block block-two"></div>
                                    <div class="block block-three"></div>
                                    <div class="block block-four"></div>
                                    <a href="#">
                                        @if (Auth::user()->profile)
                                            <img src="{{ Auth::user()->profile }}" width="250px"
                                                alt="{{ Auth::user()->name }}">
                                        @else
                                            @if (Auth::user()->gender == 'Female')
                                                <img src="{{ asset('assets/img/default_profile_female.png') }}"
                                                    width="250px" alt="{{ Auth::user()->name }}">
                                            @else
                                                <img src="{{ asset('assets/img/default-avatar.png') }}"
                                                    width="250px" alt="{{ Auth::user()->name }}">
                                            @endif
                                        @endif
                                        <h3 class="title">{{ $user->name }}</h3>
                                        <small>{{ $user->email }}</small>
                                    </a>

                                </div>
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="button-container">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal-search fade" id="codeModal" tabindex="-1" role="dialog"
                        aria-labelledby="codeModal" aria-hidden="true">
                        <form action="{{ route('confirmPassword') }}" method="POST" id="checkPassword"
                            class="request-form ">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span style="color: red; font-size:10px" class="text-error" id='error-text'></span>
                                        <span style="color: green; font-size:10px" class="text-success" id='show-password'></span>
                                        <input type="password" name="password" class="form-control" id="inlineFormInputGroup"
                                            placeholder="Input password">
                                        <button type="submit" class="close">
                                            <i class="tim-icons icon-check-2"></i>
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
            @include('layouts.footer')
        </div>
    </div>
    <script>
        $("#checkPassword").submit(function(e) {
            e.preventDefault();
            var all = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: all,
                beforeSend: function() {
                    $(document).find('span.text-error').text('');
                },
                success: function(data) {
                   
                    if (data.status === 'success') {
                        $("#transferCode").show();
                        var newSpan = document.createElement('span');
                        newSpan.innerHTML = data.code;
                        $("#transferCode").replaceWith(newSpan);
                        $("#show-password").text('Password is correct');
                    } else {
                        $(".text-error").show().html("Invalid password");
                    }

                }
            })

        });
    </script>
    <script>
        var clipboard = new ClipboardJS('#copy-btn');
        clipboard.on('success', function(e) {
            console.log(e);
        });
        clipboard.on('error', function(e) {
            console.log(e);
        });
