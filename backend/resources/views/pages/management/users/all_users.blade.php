@include('layouts.header')
<body class="light white-content">
  <div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
      <!-- Navbar -->
      @include('layouts.nav')

    <div class="content">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
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
                    <div class="tools float-right">
                        <a href="{{ route('create.user') }}" class="btn btn-sm btn-default"style="font-weight: 100">Create User</a>

                    </div>
                    <h5 class="card-title">Manage Users</h5>
                  </div>
                  <div class="card-body">
                    @if($users->count() == 0)
                    <h5 class="card-title">No data available</h5>
                    @else
                    <div class="table-responsive">
                      <table class="table-light table" style="color: white" id="myTable">
                        <thead class="text-primary">
                          <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>
                            <th class="text-right">
                                Action
                            </th>
                          </tr>
                        </thead>
                        <tbody class="text-default">
                        @foreach ($users as $user)
                          <tr>
                            <td class="">
                             {{ $user->name }}
                            </td>
                            <td class="">
                            {{ $user->email }}
                            </td>

                            <td class="">
                              @if ($user->is_admin)
                              <p class="text-primary">Admin</p>
                              @elseif ($user->is_admin == false)
                              <p class="text-warning">Customer</p>
                              @endif
                          </td>

                            <td class="text-right">

                                <a rel="tooltip" data-original-title="View" href="/dashboard/users/view/{{ $user->id  }}" class="btn btn-sm btn-default"> <i class="tim-icons text-warning icon-double-right"> </i></a>

                                <a rel="tooltip" onclick="return deleteConfirmation({{ $user->id  }})" data-original-title="Delete" href="/dashboard/users/delete/{{ $user->id  }}" class="btn btn-sm btn-default"> <i class="tim-icons text-danger icon-trash-simple"> </i></a>

                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div>

                    </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

        </div>
      </div>

    </div>
  </div>
  @include('layouts.footer')

  <script>
      function confirmation(id){

        var id = id;
        

      if (confirm('Are you sure you want to disapprove user?:')) {

    } else {

        return false
    }
    }

    function deleteConfirmation(id){

    var id = id;


    if (confirm('Are you sure you want to delete user?:')) {

    } else {

    return false
    }
}

 </script>

