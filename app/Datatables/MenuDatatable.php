<?php

namespace App\Datatables;

class MenuDatatable extends Datatable
{
    public function __construct($menus)
    {
        $this->heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Image', 'width' => 1],
            ['label' => 'Name', 'width' => 3],
            ['label' => 'Price', 'width' => 3],
            ['label' => 'Categories', 'width' => 3],
            ['label' => 'Description', 'width' => 15],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "menus";

        $tableData = [];
        foreach ($menus as $menu) {
            $image = (isset($menu->image))
                ? '<img class="table-image" src=" ' . url('storage/images/' . $menu->image) . '">'
                : 'No image';

            $tableData[] = [
                $menu->id,
                $image,
                $menu->name,
                number_format($menu->price, 2),
                $menu->category_name_list ?: 'No categories',
                $menu->description,
                $this->buttonColumn($menu->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(2);

        // Add class name of the image column
        $this->config['columns'][1] = ['className' => 'image'];
    }
}
