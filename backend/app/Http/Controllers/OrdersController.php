<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    // List all orders for the admin
    public function index()
    {
        $user = Auth::user();

        $this->authorize('viewAny', Orders::class); 

        $orders = Orders::orderBy('id', 'desc')->get();

        return view('pages.management.orders.all_orders', compact('orders'));
    }

    // List orders for the authenticated user
    public function userOrders()
    {
        $orders = Orders::where('user_id', Auth::id())->get();
        return response()->json($orders, 200);
    }

    // Create a new order
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'User not found!'], 404);
            }

            $validator = Validator::make($request->all(), [
                'pickup_location' => 'required|string|max:255',
                'delivery_location' => 'required|string|max:255',
                'truck_size' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0',
                'pickup_time' => 'required|date',
                'delivery_time' => 'required|date|after_or_equal:pickup_time',
                'order_reference' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create the order
            $order = Orders::create(array_merge($validator->validated(), ['user_id' => $user->id]));

            // Notify the admin about the new order
            $admin = User::where('is_admin', true)->first();
            if ($admin) {
                $admin->notify(new NewOrderNotification($order));
            }

            // Notify the user about the new order
            $notificationController = new EmailController();
            $notificationController->sendOrderEmail($request, $user->id);

            return response()->json(['message' => 'Order created successfully!', 'order' => $order, 'success' => true], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    // Update an order's status (Admin only)
    public function updateStatus(Request $request, $id)
    {   
        $user = Auth::user();

        $order = Orders::findOrFail($id);

        $this->authorize('update', $order); 

        $validatedData = $request->validate([
            'status' => 'required|in:pending,in progress,delivered',
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        $notificationController = new EmailController();
        $notificationController->sendOrderEmailUpdate($order, $order->status);

        return response()->json(['message' => 'Order status updated successfully!', 'order' => $order, 'success' => true], 200);
    }

    // View a single order
    public function show($id)
    {
        $order = Orders::findOrFail($id);

        $this->authorize('view', $order); 

        return response()->json($order, 200);
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);

        $this->authorize('delete', $order); 

        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully!');

    }
}
