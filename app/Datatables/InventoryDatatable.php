<?php

namespace App\Datatables;

class InventoryDatatable extends Datatable
{
    public function __construct($inventories)
    {
        $this->heads = [
            'ID',
            'Name',
            'Qty',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "inventories";

        $tableData = [];
        foreach ($inventories as $inventory) {
            $tableData[] = [
                $inventory->id,
                $inventory->name,
                floatval($inventory->qty) . ' ' . $inventory->unit,
                $this->buttonColumn($inventory->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
