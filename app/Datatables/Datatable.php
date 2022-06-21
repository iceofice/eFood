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
    public $tableData = [];

    /** 
     * @var array $config The configuration of the table.
     */
    public $config = [];

    /**
     * Route of the model.
     *
     * @var string
     */
    public $route = "";

    /**
     * Datatable constructor.
     *
     * @param integer $orderColumn (optional) The column the table is sorted. Defaults to 1
     * @param string $orderDirection (optional) The direction the table is sorted. Defaults to 'asc'
     * @return void
     */
    public function __construct(int $orderColumn = 1, String $orderDirection = 'asc')
    {
        $this->prepareConfig($orderColumn, $orderDirection);
    }

    /**
     * Combine edit and delete buttons into a single column.
     *
     * @param integer $id
     * @return void
     */
    public function buttonColumn(int $id)
    {
        return  $this->btnEdit($id) . $this->btnDelete($id);
    }

    /**
     * Combine edit and remove relation buttons into a single column.
     *
     * @param integer $id
     * @return void
     */
    public function relationButtonColumn(int $id)
    {
        return  $this->btnEditRelation($id) . $this->btnRemoveRelation($id);
    }

    /**
     * Prepare the configuration of the table.
     *
     * @param integer $orderColumn The column the table is sorted.
     * @param string $orderDirection The direction the table is sorted.
     * @return void
     */
    private function prepareConfig(int $orderColumn, String $orderDirection)
    {
        $columnsCount = count($this->heads);
        foreach (array_keys($this->heads) as $key) {
            $this->config['columns'][] = $columnsCount - 1 == $key
                ? ['orderable' => false, 'searchable' => false]
                : null;
        }

        $this->config['data'] = $this->tableData;
        $this->config['order'] = [[$orderColumn, $orderDirection]];
    }

    /**
     * Prepare the edit button.
     * 
     * @param integer $id The id of the model.
     * @return string HTML of the edit button
     */
    private function btnEdit(int $id)
    {
        $link = route($this->route . '.edit', $id);
        return "
            <a class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit' href=$link>
                <i class='fa fa-lg fa-fw fa-pen'></i>
            </a>
        ";
    }

    /**
     * Prepare the delete button.
     * 
     * @param integer $id The id of the model.
     * @return string HTML of the delete button
     */
    private function btnDelete(int $id)
    {
        $link = route($this->route . '.destroy', $id);
        return "
            <a class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete' href='$link'
                data-toggle='modal' data-target='#delete-modal' onclick='onDeleteButtonPressed(event, this)'>
                <i class='fa fa-lg fa-fw fa-trash'></i>
            </a>
        ";
    }

    /**
     * Prepare the edit relation button.
     * 
     * @param integer $id The id of the model.
     * @return string HTML of the edit relation button
     */
    private function btnEditRelation(int $id)
    {
        return "
            <a class='btn btn-xs btn-default text-primary mx-1 shadow' title='Delete' 
                data-toggle='modal' data-target='#edit-modal' data-id='$id'
                onclick='onEditButtonPressed(event, this)' 
            >
                <i class='fa fa-lg fa-fw fa-pen'></i>
            </a>
        ";
    }

    /**
     * Prepare the remove relation button.
     * 
     * @param integer $id The id of the model.
     * @return string HTML of the remove relation button
     */
    private function btnRemoveRelation(int $id)
    {
        return "
            <a class='btn btn-xs btn-default text-danger mx-1 shadow' title='Delete' 
                data-toggle='modal' data-target='#remove-modal' data-id='$id'
                onclick='onRemoveButtonPressed(event, this)' 
            >
                <i class='fa fa-lg fa-fw fa-trash'></i>
            </a>
        ";
    }

    public function notificationIndicator($message)
    {
        return $message
            ? '<span class="badge badge-primary ml-2">' . $message . '</span>'
            : '';
    }
}
