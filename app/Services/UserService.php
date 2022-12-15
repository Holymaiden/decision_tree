<?php

namespace App\Services;

use App\Repositories\Contracts\UserContract as UserRepo;
use App\Services\Contracts\UserContract;
use Illuminate\Support\Facades\Hash;

class UserService implements UserContract
{
    protected $contractRepo;

    public function __construct(UserRepo $contractRepo)
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
        $input['created_by'] = auth()->user()->id;
        $input['password'] = Hash::make($input['password']);
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
        if ($input['password'] == '') {
            $input['password'] = $data->password;
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        $input['updated_by'] = auth()->user()->id;
        return $this->contractRepo->update($input, $id);
    }

    /**
     * Delete Data By ID
     */
    public function delete($id)
    {
        return $this->contractRepo->delete($id);
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
