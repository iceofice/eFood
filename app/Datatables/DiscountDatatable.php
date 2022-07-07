<?php

namespace App\Datatables;

use Carbon\Carbon;

class DiscountDatatable extends Datatable
{
    public function __construct($discounts)
    {
        $this->heads = [
            'ID',
            'Title',
            'Subtitle',
            'Start Date',
            'End Date',
            'Amount',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "discounts";

        $tableData = [];
        foreach ($discounts as $discount) {
            $tableData[] = [
                $discount->id,
                $discount->title,
                $discount->subtitle,
                Carbon::create($discount->start_date)->format('D, d M Y, H:i'),
                Carbon::create($discount->end_date)->format('D, d M Y, H:i'),
                $discount->amount . "%",
                $this->buttonColumn($discount->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
