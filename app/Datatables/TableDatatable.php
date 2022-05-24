<?php

namespace App\Datatables;

class TableDatatable extends Datatable
{
    public function __construct($tables)
    {
        $this->heads = [
            'ID',
            'Name',
            'Qty',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "tables";

        $tableData = [];
        foreach ($tables as $table) {
            $tableData[] = [
                $table->id,
                $table->name,
                $table->qty,
                $this->buttonColumn($table->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
