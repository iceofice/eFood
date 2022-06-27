<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can handle the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function handle(User $user, Order $order)
    {
        return $user->id === $order->user_id // assigned waiter
            || $order->user_id === null // no waiter assigned
            || ($user->hasRole('Kitchen Staff') && $order->status != 5) // kitchen staff
            || ($user->hasRole('Cashier') && $order->status == 4); // Cashier
    }

    /**
     * Determine whether the user can create a new model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('Waiter');
    }
}
