<?php

namespace App\Datatables;

use Carbon\Carbon;

class AttendanceDatatable extends Datatable
{
    public function __construct($attendances)
    {
        $this->heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Clock In', 'width' => 3],
            ['label' => 'Clock Out', 'width' => 3],
            ['label' => 'User', 'width' => 1],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $this->route = "attendances";

        $tableData = [];
        foreach ($attendances as $attendance) {
            $tableData[] = [
                $attendance->id,
                Carbon::create($attendance->clock_in)->format('D, d M Y, H:i'),
                Carbon::create($attendance->clock_out)->format('D, d M Y, H:i'),
                $attendance->user->name,
                $this->buttonColumn($attendance->id),
            ];
        }
        $this->tableData = $tableData;

        parent::__construct(1, 'desc');
    }
}
