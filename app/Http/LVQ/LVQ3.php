<?php 

namespace App\Http\LVQ;
use App\Http\LVQ\Helper;

class LVQ3{
    protected $dataFinal = [];
    protected $bobotAwal = [];
    protected $bobotAkhir = [];
    private $alpha;
    private $decAlpha;
    private $maxEpoch;
    private $minAlpha;
    private $window;

    function __construct($dataTrain, $bobotAwal ,$alpha, $decAlpha, $minAlpha, $window,$maxEpoch)
    {
        $this->dataFinal = $dataTrain;
        $this->bobotAwal = $bobotAwal;

        $this->alpha    = $alpha;
        $this->decAlpha = $decAlpha;
        $this->minAlpha = $minAlpha;
        $this->window   = $window;
        $this->maxEpoch = $maxEpoch;
        $this->run();
    }

    public function run(){
        $loop = true;
        $epoch = 0;
        $perhitungan = new Helper();
        $this->bobotAkhir = $this->bobotAwal->toArray();
        while($loop){
            $cek = [];
            foreach($this->dataFinal as $data){
                $result = $perhitungan->bobotPerhitungan($data,$this->bobotAkhir);
                $klasifikasi = $result->sortBy('total')->take(2);
                $klasifikasi = array_values(collect($klasifikasi)->toArray());
                $newBobotWinner = [];
                $newBobotRunnerUp = [];
                if($klasifikasi[0]['target'] == $data['target']){
                    foreach($this->bobotAkhir[$klasifikasi[0]['index']] as $key => $value){
                        if($key == 'key' || $key == 'target'){
                            $newBobotWinner[$key] = $value;
                            continue;
                        }
                        $newBobotWinner[$key] = $value + ($this->alpha * ($data[$key] - $value));
                    }
                }else{
                    $kondisi = $perhitungan->cekWindow($klasifikasi[0]['total'],$klasifikasi[1]['total'],$this->window);
                    if($kondisi){
                        foreach($this->bobotAkhir[$klasifikasi[1]['index']] as $key => $value){
                            if($key == 'key' || $key == 'target'){
                                $newBobotRunnerUp[$key] = $value;
                                continue;
                            }
                            $newBobotRunnerUp[$key] = $value + ($this->alpha * ($data[$key] - $value));
                        }
                        foreach($this->bobotAkhir[$klasifikasi[0]['index']] as $key => $value){
                            if($key == 'key' || $key == 'target'){
                                $newBobotWinner[$key] = $value;
                                continue;
                            }
                            $newBobotWinner[$key] = $value - ($this->alpha * ($data[$key] - $value));
                        }
                    }else{
                        $beta = $this->window * $this->alpha;
                        foreach($this->bobotAkhir[$klasifikasi[0]['index']] as $key => $value){
                            if($key == 'key' || $key == 'target'){
                                $newBobotWinner[$key] = $value;
                                continue;
                            }
                            $newBobotWinner[$key] = $value - ($beta * ($data[$key] - $value));
                        }
                        foreach($this->bobotAkhir[$klasifikasi[1]['index']] as $key => $value){
                            if($key == 'key' || $key == 'target'){
                                $newBobotRunnerUp[$key] = $value;
                                continue;
                            }
                            $newBobotRunnerUp[$key] = $value + ($beta * ($data[$key] - $value));
                        }
                    }
                    $this->bobotAkhir[$klasifikasi[1]['index']] = $newBobotRunnerUp;
                }
                $this->bobotAkhir[$klasifikasi[0]['index']] = $newBobotWinner; 
            }
            $epoch++;
            $this->alpha = $this->alpha - ($this->decAlpha * $this->alpha);
            if($epoch >= $this->maxEpoch || $this->alpha <= $this->minAlpha){
                $loop = false;
            }
        }
    }
    public function getBobotAkhir(){
        return collect($this->bobotAkhir);
    }
    
}

?>