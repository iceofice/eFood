<?php

namespace App\Datatables;

use Carbon\Carbon;

class OrderDatatable extends Datatable
{
    public function __construct($orders, $userNotifications)
    {
        $this->heads = [
            'ID',
            'Total',
            'Customer',
            'Table',
            'Reservation Time',
            'Status',
            'Staff',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "orders";

        $tableData = [];
        foreach ($orders as $order) {
            $notificationMessage = $userNotifications->has($order->id) ? $userNotifications->get($order->id) : null;
            $tableData[] = [
                $order->id,
                $order->total ?: 'No Items', //TODO: format price
                $order->customerName,
                $order->table->name,
                Carbon::create($order->reserved_at)->format('D, d M Y, H:i'),
                $order->statusName,
                $order->user ? $order->waiterName : 'Not Assigned',
                $this->buttonColumn($order->id) . $this->notificationIndicator($notificationMessage),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(0);
    }
}
