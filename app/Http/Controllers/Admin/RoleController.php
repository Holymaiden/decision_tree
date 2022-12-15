<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\Contracts\RoleContract;

class RoleController extends Controller
{
    protected $roleContract,  $response;

    public function __construct(RoleContract $roleContract)
    {
        $this->title = "roles";
        $this->roleContract = $roleContract;
        // $this->middleware("roles:{$this->title}");
        $this->response = [
            'code' => config('constants.HTTP.CODE.FAILED'),
            'message' => __('error.public')
        ];
    }

    public function index()
    {
        try {
            $title = $this->title;
            return view('admin.' . $title . '.index', compact('title'));
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function data(Request $request)
    {
        try {
            $title = $this->title;
            $jml = $request->jml == '' ? config('constants.PAGINATION') : $request->jml;
            $data = Role::when($request->input('cari'), function ($query) use ($request) {
                $query->where('role', 'like', "%{$request->input('cari')}%")
                    ->orWhere("role_name", "like", "%{$request->input('cari')}%");
            })
                ->orderBy('role_name', 'desc')
                ->paginate($jml);

            $view = view('admin.' . $this->title . '.data', compact('data', 'title'))->with('i', ($request->input('page', 1) -
                1) * $jml)->render();
            return response()->json([
                "total_page" => $data->lastpage(),
                "total_data" => $data->total(),
                "html"       => $view,
            ]);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return response()->json($this->response);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->roleContract->store($request);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->roleContract->show($id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->roleContract->update($request, $id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->roleContract->delete($id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }
}
