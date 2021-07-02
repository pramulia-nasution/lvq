<?php 
namespace App\Http\LVQ;
use App\Http\LVQ\Helper;

class LVQ1{

    protected $dataFinal = [];
    protected $bobotAwal = [];
    protected $bobotAkhir = [];
    private $alpha;
    private $decAlpha;
    private $maxEpoch;
    private $minAlpha;

    function __construct($dataTrain, $bobotAwal, $alpha, $decAlpha, $minAlpha,$maxEpoch)
    {
        $this->dataFinal = $dataTrain;
        $this->bobotAwal = $bobotAwal;

        $this->alpha    = $alpha;
        $this->decAlpha = $decAlpha;
        $this->minAlpha = $minAlpha;
        $this->maxEpoch = $maxEpoch;
        $this->run();
    }

    public function run(){
        $loop  = true;
        $epoch = 0;
        $perhitungan = new Helper();
        $this->bobotAkhir = $this->bobotAwal->toArray();
        while($loop){
            foreach($this->dataFinal as $data){
                $result = $perhitungan->bobotPerhitungan($data,$this->bobotAkhir);
                $minimumData = $result->where('total',$result->min('total'))->first();
                $newBobotWinner = [];
                if($minimumData['target'] == $data['target']){
                    foreach($this->bobotAkhir[$minimumData['index']] as $key => $value){
                        if($key == 'key' || $key == 'target'){
                            $newBobotWinner[$key] = $value;
                            continue;
                        }
                        $newBobotWinner[$key] = $value + ($this->alpha * ($data[$key] - $value));
                    }
                }else{
                    foreach($this->bobotAkhir[$minimumData['index']] as $key => $value){
                        if($key == 'key' || $key == 'target'){
                            $newBobotWinner[$key] = $value;
                            continue;
                        }
                        $newBobotWinner[$key] = $value - ($this->alpha * ($data[$key] - $value));
                    }
                }
                $this->bobotAkhir[$minimumData['index']] = $newBobotWinner;
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