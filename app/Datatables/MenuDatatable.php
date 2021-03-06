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
            ['label' => 'Description', 'width' => 10],
            ['label' => 'Featured', 'width' => 1],
            ['label' => 'Active', 'width' => 1],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "menus";

        $tableData = [];
        foreach ($menus as $menu) {
            $imagePath = (isset($menu->image))
                ? 'storage/images/' . $menu->image
                : 'images/placeholder-image.png';

            $tableData[] = [
                $menu->id,
                '<img class="table-image" src=" ' . url($imagePath) . '">',
                $menu->name . $this->soldOutIndicator($menu),
                number_format($menu->price, 2),
                $menu->category_name_list ?: 'No categories',
                $menu->description,
                $menu->featured ? "Yes" : "No",
                $menu->is_active ? "Yes" : "No",
                $this->buttonColumn($menu->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(2);

        // Add class name of the image column
        $this->config['columns'][1] = ['className' => 'image'];
    }

    public function soldOutIndicator($menu)
    {
        if ($menu->out_of_stock)
            return "<img class='sold-button' src=' " .  asset('images/sold-out.png') . "'>";
    }
}
