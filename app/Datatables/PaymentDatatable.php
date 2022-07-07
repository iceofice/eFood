<?php

namespace App\Datatables;

use Carbon\Carbon;

class PaymentDatatable extends Datatable
{
    public function __construct($payments)
    {
        $this->heads = [
            'ID',
            'Method',
            'Paid At',
            'Order',
            'Total',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "payments";

        $tableData = [];
        foreach ($payments as $payment) {
            $tableData[] = [
                $payment->id,
                $payment->method_name,
                Carbon::create($payment->paid_at)->format('D, d M Y, H:i'),
                $payment->order->customer_name . ' - ' . $payment->order->table->name,
                $payment->discount_total,
                $this->buttonColumn($payment->id),

            ];
        }
        $this->tableData = $tableData;

        parent::__construct(0);
    }
}
