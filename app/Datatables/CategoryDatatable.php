<?php

namespace App\Datatables;

class CategoryDatatable extends Datatable
{
    public function __construct($categories)
    {
        $this->heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Image', 'width' => 1],
            ['label' => 'Name', 'width' => 3],
            ['label' => 'Type', 'width' => 1],
            ['label' => 'Description', 'width' => 15],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "categories";

        $tableData = [];
        foreach ($categories as $category) {
            $imagePath = (isset($category->image))
                ? 'storage/images/' . $category->image
                : 'images/placeholder-image.png';

            $tableData[] = [
                $category->id,
                '<img class="table-image" src=" ' . url($imagePath) . '">',
                $category->name,
                ($category->type == 0) ? 'Category' : 'Filter',
                $category->description,
                $this->buttonColumn($category->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(2);

        // Add class name of the image column
        $this->config['columns'][1] = ['className' => 'image'];
    }
}
