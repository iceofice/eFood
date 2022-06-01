<?php

namespace App\Datatables;

class TableDatatable extends Datatable
{
    public function __construct($tables)
    {
        $this->heads = [
            'ID',
            'Name',
            'Number Of People',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "tables";

        $tableData = [];
        foreach ($tables as $table) {
            $tableData[] = [
                $table->id,
                $table->name,
                $table->min . ' - ' . $table->max,
                $this->buttonColumn($table->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
