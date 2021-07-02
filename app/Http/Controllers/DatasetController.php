<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Models\Dataset;
use App\Imports\DatasetImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $dataset = Dataset::all();
            return DataTables::of($dataset)->make(true);
        }
        return view('data.index');
    }

    public function truncate(){
        Dataset::truncate();
        return response()->json(['success' => 'Dataset telah dikosongkan']);
    }

    public function import(){
        Excel::import(new DatasetImport,request()->file('file'));
        return response()->json(['success' => 'Dataset berhasil di import']);
    }
}
