<?php

namespace App\Datatables;

class CategoryDatatable extends Datatable
{
    public function __construct($categories)
    {
        $this->heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Image', 'width' => 1],
            ['label' => 'Name', 'width' => 5],
            ['label' => 'Type', 'width' => 1],
            ['label' => 'Description', 'width' => 15],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "categories";

        $tableData = [];
        foreach ($categories as $category) {
            //TODO: Make css style
            $image = (isset($category->image))
                ? '<img src=" ' . url('storage/' . $category->image) . '" style="height: 50px; width: 50px; object-fit: contain;">'
                : 'No image';

            $tableData[] = [
                $category->id,
                $image,
                $category->name,
                ($category->type == 0) ? 'Category' : 'Filter',
                $category->description,
                $this->buttonColumn($category->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(2);
    }
}
