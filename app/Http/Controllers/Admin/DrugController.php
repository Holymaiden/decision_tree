<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use App\Services\Contracts\DrugContract;
use App\Helpers\DecisionTree;

class DrugController extends Controller
{
    protected $drugContract, $response, $title;

    public function __construct(DrugContract $drugContract)
    {
        $this->title = "drugs";
        $this->drugContract = $drugContract;
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
            $golongan = $request->golongan == '' ? 'is not null' : '="' . $request->golongan . '"';
            $data = Drug::whereRaw('category ' . $golongan)->when($request->input('cari'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->input('cari')}%")
                    ->orWhere("category", "like", "%{$request->input('cari')}%")
                    ->orWhere("type", "like", "%{$request->input('cari')}%");
            })
                ->orderBy('id', 'desc')
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
            $data = $this->drugContract->store($request);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->drugContract->show($id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->drugContract->update($request, $id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->drugContract->delete($id);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function decisionTree()
    {
        try {
            $data = new DecisionTree();
            $data = $data->getDrugByDisease("asma");
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine());
        }
    }
}
