<?php

namespace App\View\Composers;

use Auth;
use App\Models\User;
use App\Models\Table;
use App\Models\Customer;
use Illuminate\View\View;

class OrderComposer
{
    //TODO: Make other composer
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $customers = Customer::pluck('name', 'id')->toArray();
        $status = [
            'Pending',
            'Recieved By Kitchen',
            'Cooking',
            'Ready',
            'Delivered',
            'Completed',
        ];
        $tables = Table::pluck('name', 'id')->toArray();

        if (Auth::user()->hasRole('Waiter')) {
            $isWaiter = true;
            $waiters = [Auth::user()->id => Auth::user()->name];
        } else {
            $isWaiter = false;
            $waiters = User::role('waiter')->pluck('name', 'id')->toArray();
        }
        $view
            ->with('customers', $customers)
            ->with('status', $status)
            ->with('tables', $tables)
            ->with('waiters', $waiters)
            ->with('isWaiter', $isWaiter);
    }
}
