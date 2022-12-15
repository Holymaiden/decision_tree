<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Builder;
use DB;

class BaseRepository implements BaseContract
{
    /**
     * @var
     */
    protected $model;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param  mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->model->paginate(config('constants.PAGINATION'));
        // return $this->model->get();
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     */
    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
        // return $this->model->whereIn('id', (array) $id)->update($data);
    }

    /**
     * @param $model
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function deleteWhere($column, $value)
    {
        return $this->model->where($column, $value)->delete();
    }

    /**
     * @param $column
     */
    public function where($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function whereOne($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * @param $orderBy
     * @param $oderType
     * 
     * @return mixed
     */
    // public function allOrder($orderBy, $oderType)
    // {
    //     return $this->model->orderBy($orderBy, $oderType)->get();
    // }

    // public function orderBy($orderBy, $oderType)
    // {
    //     return $this->model->orderBy($orderBy, $oderType);
    // }

    /**
     * @param $column
     * @param $value
     * @param array $with
     * 
     * @return mixed
     */
    // public function getOneWhere($column, $value, $with = [])
    // {
    //     return $this->model->with($with)->where($column, $value)->first();
    // }

    /**
     * @param $column
     * @param $value
     * 
     * @return mixed
     */
    // public function getManyWhere($column, $value)
    // {
    //     if (!empty($value)) {
    //         $tempStr = implode(',', $value);
    //         return $this->model->whereIn($column, (array) $value)->orderByRaw(DB::raw("FIELD($column, $tempStr)"))->get();
    //     }

    //     return [];
    // }

    /**
     * 
     * @param  $column
     * @param  $value
     * @return void
     */
    // public function where($column, $value)
    // {
    //     return $this->model->where($column, $value)->get();
    // }

    /**
     *
     * @param $column
     * @param array $range
     * @return void
     */
    // public function whereBetween($column, array $range)
    // {
    //     return $this->model->whereBetween($column, $range)->get();
    // }

    /**
     * 
     * @param  $column
     * @param  $value
     * @return void
     */
    // public function orWhere($column, $value)
    // {
    //     return $this->model->orWhere($column, $value)->get();
    // }

    /**
     * @param array $column
     * @param $value
     * @return void
     */
    // public function whereLike(array $column = null, $value = null)
    // {
    //     Builder::macro('whereLike', function ($attributes, string $searchTerm) {
    //         $this->where(function (Builder $query) use ($attributes, $searchTerm) {
    //             foreach (array_wrap($attributes) as $attribute) {
    //                 $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
    //             }
    //         });

    //         return $this;
    //     });

    //     return $this->model->whereLike($column, $value)->get();
    // }

    /**
     * pagination
     *
     * @param integer $perPage
     * @param array $columns
     * @return void
     */
    public function paginate($perPage = 0, $columns = array('*'))
    {
        $perPage = $perPage ?: config('constants.PAGINATION');

        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param $column
     * @param $value
     * 
     * @return mixed
     */
    // public function countWhere($column, $value)
    // {
    //     return $this->model->where($column = '', $value)->count();
    // }

    // public function save($model)
    // {
    //     $model->save();

    //     return $model;
    // }

    /**
     * @param $column
     * @param $value
     * 
     * @return void
     */
    // public function deleteWhere($column, $value)
    // {
    //     return $this->model->create($column, $value)->delete();
    // }

    /**
     * @param $select
     * 
     * @return mixed
     */
    // public function datatable($select)
    // {
    //     return $this->model->select($select);
    // }

    /**
     * @param $select
     * @param array $with
     * 
     * @return mixed
     */
    // public function datatableWith($select, array $with)
    // {
    //     return $this->datatable($select)->with($with);
    // }

    /**
     * whereHas 
     *
     * @param $attribute
     * @param \Closure $closure
     * @return void
     */
    // public function whereHas($attribute, \Closure $closure = null)
    // {
    //     return $this->model->whereHas($attribute, $closure);
    // }

    /**
     * with relation
     *
     * @param array $with
     * @return void
     */
    // public function with(array $with)
    // {
    //     return $this->model->with($with);
    // }
}
