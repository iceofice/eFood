<?php

namespace App\Datatables;

class OrderDatatable extends Datatable
{
    public function __construct($orders)
    {
        $this->heads = [
            'ID',
            'Total',
            'Status',
            'Customer',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "orders";

        $tableData = [];
        foreach ($orders as $order) {
            $tableData[] = [
                $order->id,
                $order->total ?: 'No Items', //TODO: format price
                $order->statusName,
                $order->customerName,
                $this->buttonColumn($order->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(0);
    }
}
