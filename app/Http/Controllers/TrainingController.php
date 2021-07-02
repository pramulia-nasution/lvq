<?php

namespace App\Http\Controllers;

use App\Http\LVQ\collectData;
use App\Models\Dataset;
use App\Http\LVQ\LVQ1;
use App\Http\LVQ\LVQ2;
use App\Http\LVQ\LVQ3;
use App\Http\LVQ\Testing;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Report;
use App\Models\Result;

use function PHPUnit\Framework\isNull;

class TrainingController extends Controller
{
    private $data;

    public function index(){
        $result = [
            'lvq1' => Parameter::type(1),
            'res1' => $this->prosesData(1),
            'acc1' => Report::type(1),
            'lvq2' => Parameter::type(2),
            'res2' => $this->prosesData(2),
            'acc2' => Report::type(2),
            'lvq3' => Parameter::type(3),
            'res3' => $this->prosesData(3),
            'acc3' => Report::type(3)
        ];
        return view('calculation.training',$result);
    }

    public function prosesData($r){
        $output = [];
            $res = Result::type($r);
            if($res->count() > 0){
                foreach(json_decode($res->value) as $data){
                    $data = array_values(collect($data)->toArray());
                    array_shift($data);
                    array_pop($data);
                    array_push($output,$data);
                }   
            }
        return $output;
    }

    private function collectData(){
        $data = Dataset::all();
        $this->data = new collectData($data);
    }

    private function setParameter($request){
        Parameter::updateOrCreate(['type' => $request['type']],[
            'alpha'     => $request['alpha'],
            'decAlpha'  => $request['decAlpha'],
            'minAlpha'  => $request['minAlpha'],
            'maxEpoch'  => $request['maxEpoch'],
            'window'    => $request['window'],
            'type'      => $request['type']
        ]);
    }

    private function setReport($request,$type){
        $testing = new Testing($this->data->getData(),$request);
        Report::updateOrCreate(['type' => $type],[
            'acuracy'               => $testing->accuracy(),
            'confusion_matrix'      => json_encode($testing->confusionMatrix()),
            'classification_report' => json_encode($testing->classficationReport())
        ]);
    }

    private function setResult($request,$type){
        Result::updateOrCreate(['type' => $type],[
            'value' =>$request,
            'type'  => $type
        ]);
    }

    public function calculateLVQ1(Request $request){
        $this->collectData();
        $lvq1 = new LVQ1(
            $this->data->getDataFinal(),
            $this->data->getBobotAwal(),
            $request->alpha1,
            $request->decAlpha1,
            $request->minAlpha1,
            $request->maxEpoch1
        );
        $request = [
            'alpha'     => $request->alpha1,
            'decAlpha'  => $request->decAlpha1,
            'minAlpha'  => $request->minAlpha1,
            'maxEpoch'  => $request->maxEpoch1,
            'window'    => $request->window1,
            'type'      => $request->type1
        ];
        $this->setParameter($request);
        $this->setResult(json_encode($lvq1->getBobotAkhir()),'1');
        $this->setReport($lvq1->getBobotAkhir(),'1');
        return redirect()->back()->with('message','Data telah di training dengan metode LVQ 1');
    }

    public function calculateLVQ2(Request $request){
        $this->collectData();
        $lvq2 = new LVQ2(
            $this->data->getDataFinal(),
            $this->data->getBobotAwal(),
            $request->alpha2,
            $request->decAlpha2,
            $request->minAlpha2,
            $request->window2,
            $request->maxEpoch2
        );
        $request = [
            'alpha'     => $request->alpha2,
            'decAlpha'  => $request->decAlpha2,
            'minAlpha'  => $request->minAlpha2,
            'maxEpoch'  => $request->maxEpoch2,
            'window'    => $request->window2,
            'type'      => $request->type2
        ];
        $this->setParameter($request);
        $this->setResult(json_encode($lvq2->getBobotAkhir()),'2');
        $this->setReport($lvq2->getBobotAkhir(),'2');
        return redirect()->back()->with('message','Data telah di training dengan metode LVQ 2.1');
    }

    public function calculateLVQ3(Request $request){
        $this->collectData();
        $lvq3 = new LVQ3(
            $this->data->getDataFinal(),
            $this->data->getBobotAwal(),
            $request->alpha3,
            $request->decAlpha3,
            $request->minAlpha3,
            $request->window3,
            $request->maxEpoch3
        );
        $request = [
            'alpha'     => $request->alpha3,
            'decAlpha'  => $request->decAlpha3,
            'minAlpha'  => $request->minAlpha3,
            'maxEpoch'  => $request->maxEpoch3,
            'window'    => $request->window3,
            'type'      => $request->type3
        ];
        $this->setParameter($request);
        $this->setResult(json_encode($lvq3->getBobotAkhir()),'3');
        $this->setReport($lvq3->getBobotAkhir(),'3');
        return redirect()->back()->with('message','Data telah di training dengan metode LVQ 3');
    }
}
 