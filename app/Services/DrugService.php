<?php

namespace App\Services;

use App\Models\Drug;
use App\Repositories\Contracts\DrugContract as DrugRepo;
use App\Services\Contracts\DrugContract;
use App\Traits\Uploadable;

class DrugService implements DrugContract
{
    use Uploadable;

    protected $contractRepo;
    protected $image_path = 'uploads/drug';

    public function __construct(DrugRepo $contractRepo)
    {
        $this->contractRepo = $contractRepo;
    }

    /**
     * Get Data
     */
    public function getAll()
    {
        return $this->contractRepo->index();
    }

    /**
     * Store Data
     */
    public function store($request)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $image_name = pathinfo($image, PATHINFO_FILENAME);
            $image_name = $this->uploadFile2($request->file('image'), $this->image_path, '');
            $input['image'] = $image_name;
        }

        // $category = Drug::where('type', $input['type'])->count();
        // $category_all = Drug::select('category')->distinct()->get();
        // if ($category > 0) {
        //     $input['category'] = Drug::where('type', $input['type'])->first()->category;
        // } else {
        //     // random category
        //     $input['category'] = $category_all->random()->category;
        // }

        return $this->contractRepo->store($input);
    }

    /**
     * Get Data By ID
     */
    public function show($id)
    {
        return $this->contractRepo->show($id);
    }

    /**
     * Update Data By ID
     */
    public function update($request, $id)
    {
        $input = $request->all();
        $data = $this->contractRepo->show($id);
        if ($request->hasFile('image')) {
            $this->deleteFile2($data->image, $this->image_path);
            $image = $request->file('image')->getClientOriginalName();
            $image_name = pathinfo($image, PATHINFO_FILENAME);
            $image_name = $this->uploadFile2($request->file('image'), $this->image_path, '');
            $input['image'] = $image_name;
        } else {
            $input['image'] = $input['image_old'];
        }
        return $this->contractRepo->update($input, $id);
    }

    /**
     * Delete Data By ID
     */
    public function delete($id)
    {
        $data = $this->contractRepo->show($id);
        $this->deleteFile2($data->image, $this->image_path);
        return $this->contractRepo->delete($id);
    }

    /**
     * Get Data with Where 
     */
    public function where($column, $value)
    {
        return $this->contractRepo->where($column, $value);
    }

    /**
     * Get Data with Pagination
     */
    public function paginate($perPage = 0, $columns = array('*'))
    {
        $perPage = $perPage ?: config('constants.PAGINATION');
        return $this->contractRepo->paginate($perPage, $columns);
    }
}
