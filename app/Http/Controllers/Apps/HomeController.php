<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\DecisionTree;
use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected  $title = 'home', $response;

    public function __construct()
    {
        $this->middleware('auth');
        $this->response = [
            'code' => config('constants.HTTP.CODE.FAILED'),
            'message' => __('error.public')
        ];
    }

    public function index()
    {
        $title = $this->title;
        return view('apps.home.index', compact('title'));
    }

    public function data(Request $request)
    {
        try {
            $title = $this->title;
            $cari = $request->input('cari');
            $jml = 8;
            if ($cari) {
                $decision = new DecisionTree();
                $decisionData = $decision->getDrugByDisease($cari);
                $data = Drug::whereIn('name', $decisionData)->orderBy('id', 'desc')->paginate($jml);
            } else {
                $data = Drug::when($cari, function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('cari')}%")
                        ->orWhere("description", "like", "%{$request->input('cari')}%")
                        ->orWhere("category", "like", "%{$request->input('cari')}%")
                        ->orWhere("type", "like", "%{$request->input('cari')}%");
                })->orderBy('id', 'desc')
                    ->paginate($jml);
            }

            $view = view('apps.' . $this->title . '.data', compact('data', 'title'))->with('i', ($request->input('page', 1) -
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

    public function kataKunci(Request $request)
    {
        try {
            $cari = $request->input('cari');
            $data = Drug::select('type')->when($cari, function ($query) use ($request) {
                $query->Where("type", "like", "%{$request->input('cari')}%");
            })
                ->orderBy('id', 'desc');
            $data = $cari ? $data->get() : $data->limit(5)->get();
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return response()->json($this->response);
        }
    }
}
