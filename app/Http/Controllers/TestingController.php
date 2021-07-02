<?php

namespace App\Http\Controllers;

use App\Http\LVQ\collectData;
use App\Http\LVQ\Helper;
use App\Imports\TestingImport;
use App\Models\Result;
use App\Models\Testing;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TestingController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $testing = Testing::all();
            return DataTables::of($testing)->make(true);
        }
        return view('calculation.testing');
    }

    public function store(Request $request){
        Testing::create($request->except('_token'));
        return response()->json(['message' => 'data has been added']);
    }

    public function generate(Request $request){
        $testing = Testing::all();
        $collect_data = new collectData($testing);
        $output = [];
        $result  = Result::type($request->type);
        if($result->count() > 0){
            foreach(json_decode($result->value) as $data){
                $data = collect($data)->toArray();
                array_push($output,$data);
            }
            $new_testing = new Testing;
            $new_value = [];
            $helper = new Helper();
            foreach($collect_data->getData() as $item){
                $calculate = $helper->bobotPerhitungan($item,$output);
                $minimumData = $calculate->where('total',$calculate->min('total'))->first();
                array_push($new_value,[
                    'id'     => $item['key'],
                    'target' => $minimumData['target']
                ]);
            }
            $index = 'id';
            batch()->update($new_testing,$new_value,$index);   
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    public function import(){
        Excel::import(new TestingImport, request()->file('file'));
        return response()->json(['message' => 'data has been import']);
    }

    public function truncate(){
        Testing::truncate();
        return response()->json(['success' => 'Dataset telah dikosongkan']);
    }
}
