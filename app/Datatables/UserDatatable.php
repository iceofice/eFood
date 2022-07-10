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
                $user->getRoleNames(),
                $this->btnDetails($user->id) . $this->buttonColumn($user->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct();
    }

    /**
     * Prepare the edit button.
     * 
     * @param integer $id The id of the model.
     * @return string HTML of the edit button
     */
    private function btnDetails(int $id)
    {
        $link = route('attendances.details', $id);
        return "
            <a class='btn btn-xs btn-default text-dark mx-1 shadow' title='Attendance' href=$link>
                <i class='fa fa-lg fa-fw fa-eye'></i>
            </a>
        ";
    }
}
