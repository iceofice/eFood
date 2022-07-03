<?php

namespace App\Datatables;

class InventoryMenuDatatable extends Datatable
{
    public function __construct($menuInventories)
    {
        $this->heads = [
            'Inventory Item Name',
            'Quantity',
            ['label' => 'Actions', 'no-export' => true],
            'Created At'
        ];

        $this->route = "orders";

        $tableData = [];
        foreach ($menuInventories as $key => $menuInventory) {
            $tableData[] = [
                $menuInventory->name,
                $menuInventory->pivot->qty,
                $this->relationButtonColumn($menuInventory->id),
                $menuInventory->pivot->created_at->format('Y-m-d H:i:s'),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(3);

        $this->config['columns'][3] = ['visible' => false];
    }
}
