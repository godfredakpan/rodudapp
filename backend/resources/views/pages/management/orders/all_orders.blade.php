@include('layouts.header')
<body class="light white-content">
  <div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
      @include('layouts.nav')

      <div class="content">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                @if (session('success'))
                <div class="alert alert-success alert-with-icon">
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="tim-icons icon-simple-remove"></i>
                  </button>
                  <span class="tim-icons icon-bell-55"></span>
                  <span>{{ session('success') }}</span>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-with-icon">
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="tim-icons icon-simple-remove"></i>
                  </button>
                  <span class="tim-icons icon-bell-55"></span>
                  <span>{{ session('error') }}</span>
                </div>
                @endif

                <h5 class="card-title">Manage Orders</h5>
              </div>
              <div class="card-body">
                @if($orders->isEmpty())
                <h5 class="card-title">No orders available</h5>
                @else
                <div class="table-responsive">
                  <table class="table table-striped table-hover" id="myTable">
                    <thead class="text-primary">
                      <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-right">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)
                      <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                          @if ($order->status === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($order->status === 'in progress')
                          <span class="badge badge-info">In Progress</span>
                          @else
                          <span class="badge badge-success">Delivered</span>
                          @endif
                        </td>
                        
                        <td>{{ Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}</td>
                        <td class="text-right">
                          <a href="#" class="btn btn-sm btn-outline-warning" title="Edit" 
                             onclick="editOrder({{ $order }})" data-toggle="modal" data-target="#editOrderModal">
                            <i class="tim-icons icon-pencil"></i>
                          </a>
                          <button class="btn btn-sm btn-outline-primary" title="Send Email"
                                onclick="prepareEmailModal({{ $order->user->id }}, '{{ $order->user->name }}')" 
                                data-toggle="modal" data-target="#sendEmailModal">
                          <i class="tim-icons icon-email-85"></i>
                        </button>
                          <form action="{{ route('orders.destroy', $order->id) }}" method="POST" 
                                style="display:inline-block;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                              <i class="tim-icons icon-trash-simple"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      <!-- Modal for Sending Emails -->
                      <div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="sendEmailModalLabel">Send Email</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form id="sendEmailForm">
                                <input type="hidden" id="emailUserId" name="user_id">
                                <div class="form-group">
                                  <label for="emailSubject">Subject</label>
                                  <input type="text" class="form-control" id="emailSubject" name="subject" placeholder="Enter email subject" required>
                                </div>
                                <div class="form-group">
                                  <label for="emailBody">Message</label>
                                  <textarea class="form-control" id="emailBody" name="body" placeholder="Enter your message" rows="4" required></textarea>
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" onclick="sendEmail()">Send Email</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      @endforeach
                    </tbody>
                  </table>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('layouts.footer')

      <!-- Modal for Editing Orders -->
      <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="editOrderForm">
                <input type="hidden" id="orderId" name="order_id">
                <div class="form-group">
                  <label for="pickupLocation">Pickup Location</label>
                  <input type="text" class="form-control" id="pickupLocation" name="pickup_location" readonly>
                </div>
                <div class="form-group">
                  <label for="deliveryLocation">Delivery Location</label>
                  <input type="text" class="form-control" id="deliveryLocation" name="delivery_location" readonly>
                </div>
                <div class="form-group">
                  <label for="truckSize">Truck Size</label>
                  <input type="text" class="form-control" id="truckSize" name="truck_size" readonly>
                </div>
                <div class="form-group">
                  <label for="weight">Weight</label>
                  <input type="number" class="form-control" id="weight" name="weight" readonly>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status">
                    <option value="pending">Pending</option>
                    <option value="in progress">In Progress</option>
                    <option value="delivered">Delivered</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="updateOrder()">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        function prepareEmailModal(userId, userName) {
          document.getElementById('emailUserId').value = userId;
          document.getElementById('sendEmailModalLabel').textContent = `Send Email to ${userName}`;
        }

        function sendEmail() {
          const userId = document.getElementById('emailUserId').value;
          const subject = document.getElementById('emailSubject').value;
          const body = document.getElementById('emailBody').value;

          fetch(`/dashboard/send-email`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ user_id: userId, subject, body }),
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Email sent successfully!');
                $('#sendEmailModal').modal('hide');
              } else {
                alert('Failed to send email!');
              }
            })
            .catch(error => console.error('Error:', error));
        }

        function confirmDelete() {
          return confirm('Are you sure you want to delete this order?');
        }

        function editOrder(order) {
          document.getElementById('orderId').value = order.id;
          document.getElementById('pickupLocation').value = order.pickup_location;
          document.getElementById('deliveryLocation').value = order.delivery_location;
          document.getElementById('truckSize').value = order.truck_size;
          document.getElementById('weight').value = order.weight;
          document.getElementById('status').value = order.status;
        }

        function updateOrder() {
          const orderId = document.getElementById('orderId').value;
          const status = document.getElementById('status').value;

          fetch(`/dashboard/orders/update/${orderId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Order updated successfully!');
              location.reload();
            } else {
              alert('Failed to update order!');
            }
          })
          .catch(error => console.error('Error:', error));
        }
      </script>

    </div>
  </div>
</body>
