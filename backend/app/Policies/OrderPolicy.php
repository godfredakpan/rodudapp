<?php

namespace App\Policies;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any orders.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        // Allow only admins to view all orders
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view a specific order.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Orders $order
     * @return bool
     */
    public function view(User $user, Orders $order)
    {
        // Allow users to view their own orders or admins to view any order
        return $user->is_admin || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can update an order.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Orders $order
     * @return bool
     */
    public function update(User $user, Orders $order)
    {
        // Allow only admins to update orders
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete an order.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Orders $order
     * @return bool
     */
    public function delete(User $user, Orders $order)
    {
        // Allow only admins to delete orders
        return $user->is_admin;
    }
}
