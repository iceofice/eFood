<?php

namespace App\Datatables;

class CategoryDatatable extends Datatable
{
    public function __construct($categories)
    {
        $this->heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Name', 'width' => 3],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "categories";

        $tableData = [];
        foreach ($categories as $category) {

            $tableData[] = [
                $category->id,
                $category->name,
                $this->buttonColumn($category->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(1);
    }
}
