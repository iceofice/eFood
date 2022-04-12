<?php

namespace App\Datatables;

class UserDatatable extends Datatable
{
    public function __construct($users)
    {
        $this->heads = [
            'ID',
            'Name',
            'Email',
            'Role',
            ['label' => 'Actions', 'no-export' => true],
        ];

        $this->route = "users";

        $tableData = [];
        foreach ($users as $user) {
            $tableData[] = [
                $user->id,
                $user->name,
                $user->email,
                'a',
                $this->buttonColumn($user->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }
}
