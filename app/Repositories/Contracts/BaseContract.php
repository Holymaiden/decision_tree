<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param $orderBy
     * @param $orderType
     * 
     * @return mixed
     */
    // public function allOrder($orderBy, $orderType);

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param $id
     * 
     * @return mixed
     */
    public function show($id);

    /**
     * @param array $data
     * @param $id
     * 
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * 
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $column
     * @param $value
     * @param $with
     * 
     * @return mixed
     */
    // public function getOneWhere($column, $value, $with);

    /**
     * @param $column
     * @param $value
     * 
     * @return mixed
     */
    // public function getManyWhere($column, $value);

    /**
     * @param $column
     * @param $value
     * 
     * @return mixed
     */
    // public function countWhere($column, $value);

    /**
     * @param $column
     * @param $value
     * 
     * @return mixed
     */
    // public function deleteWhere($column, $value);

    /**
     * @param $select
     * @return mixed
     */
    // public function datatable($select);

    /**
     * @param $select
     * @param array $with
     * 
     * @return mixed
     */
    // public function datatableWith($select, array $with);
}
