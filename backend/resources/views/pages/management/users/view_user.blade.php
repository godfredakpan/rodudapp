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
                <a href="{{ route('all.users') }}">Back</a>
                @if (session('success'))
                <div class="alert alert-success alert-with-icon" data-notify="container">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                    <span data-notify="message">{{session('success')}}</span>
                  </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-with-icon" data-notify="container">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                    <span data-notify="message">{{session('error')}}</span>
                  </div>
                @endif
                <h5 class="title">Update user</h5>
              </div>
              <div class="card-body">
                <form class="" action="{{ route('update.user') }}" method="post">
                    @csrf
                  <div class="row">
                    <div class="col-md-5 pr-md-1">
                      <div class="form-group">
                        <label>Full name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}">
                        <input type="text" class="form-control" name="id" hidden value="{{ $user->id }}">
                      </div>
                    </div>

                    
                    <div class="col-md-4 pl-md-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" readonly name="email" class="form-control" placeholder="{{ $user->email }}">
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
                      <h3 class="title">{{ $user->name }}</h3>
                    </a>

                  </div>
                </p>
                <div class="card-description">

                    <p class="description">
                        Role: {{ $user->is_admin ? 'Admin' : 'User' }}
                    </p>

                    <p class="description">

                        Email: <a href="#">{{ $user->email }}</a>
                    </p>

                    <p class="description">
                        Date Joined: {{ $user->created_at }}
                    </p>


                </div>
              </div>
              <div class="card-footer">
                <div class="button-container">

                </div>
              </div>
            </div>
          </div>
        </div>
      @include('layouts.footer')
    </div>
  </div>
