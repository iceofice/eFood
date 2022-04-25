<?php

namespace App\View\Composers;

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
        $view
            ->with('customers', $customers)
            ->with('status', $status);
    }
}
