<?php

namespace App\Datatables;

class Datatable
{
    /** 
     * @var array $heads The header of the table.
     */
    public $heads = [];

    /** 
     * @var array $tableData The data of the table.
     */
    protected $tableData = [];

    /** 
     * @var array $config The configuration of the table.
     */
    public $config = [];

    /**
     * Datatable constructor.
     *
     * @param integer $orderColumn (optional) The column the table is sorted. Defaults to 1
     * @param string $orderDirection (optional) The direction the table is sorted. Defaults to 'asc'
     */
    public function __construct($orderColumn = 1, $orderDirection = 'asc')
    {
        $this->prepareTableData();
        $this->prepareConfig($orderColumn, $orderDirection);
    }

    /**
     * Combine edit and delete buttons.
     *
     * @return string
     */
    protected function buttonColumn()
    {
        return '<nobr>' . $this->btnEdit . $this->btnDelete . '</nobr>';
    }

    /**
     * Add buttons to the every rows.
     *
     * @return void
     */
    protected function prepareTableData()
    {
        foreach ($this->tableData as $key => $row) {
            $row[] = $this->buttonColumn();
            $this->tableData[$key] = $row;
        }
    }

    /**
     * Prepare the configuration of the table.
     *
     * @return void
     */
    protected function prepareConfig($orderColumn, $orderDirection)
    {
        $columnsCount = count($this->tableData[0]);
        foreach (array_keys($this->tableData[0]) as $key) {
            $columns[] = $columnsCount == $key - 1
                ? ['orderable' => false]
                : null;
        }

        $this->config = [
            'data' => $this->tableData,
            'order' => [[$orderColumn, $orderDirection]],
            'columns' => $columns,
        ];
    }

    /**
     * @var string $btnEdit The edit button on the table.
     */
    private $btnEdit = '
        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            <i class="fa fa-lg fa-fw fa-pen"></i>
        </button>
    ';

    /**
     * @var string $btnDelete The delete button on the table.
     */
    private $btnDelete = '
        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </button>
    ';
}
