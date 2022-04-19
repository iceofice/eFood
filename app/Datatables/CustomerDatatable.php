<?php

namespace App\Datatables;

class CustomerDatatable extends Datatable
{
    public function __construct($customers)
    {
        $this->heads = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Logged In',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "customers";

        $tableData = [];
        foreach ($customers as $customer) {
            $tableData[] = [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->password ? 'Yes' : 'No',
                $this->buttonColumn($customer->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
