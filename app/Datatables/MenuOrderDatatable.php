<?php

namespace App\Datatables;

class MenuOrderDatatable extends Datatable
{
    public function __construct($orderMenus)
    {
        $this->heads = [
            'No',
            'Menu Name',
            'Quantity',
            'Price (per item)',
            ['label' => 'Actions', 'no-export' => true],
            'Created At'
        ];

        $this->route = "orders";

        $tableData = [];
        foreach ($orderMenus as $key => $orderMenu) {
            $tableData[] = [
                $key + 1,
                $orderMenu->name,
                $orderMenu->pivot->qty,
                $orderMenu->pivot->price,
                $this->relationButtonColumn($orderMenu->id),
                $orderMenu->pivot->created_at->format('Y-m-d H:i:s'),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(5);

        $this->config['columns'][5] = ['visible' => false];
    }
}
