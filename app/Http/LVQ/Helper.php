<?php

namespace App\Http\LVQ;
use Phpml\Math\Distance\Euclidean;

class Helper{

    public function normalisasiArray(array $value){
        array_shift($value);
        array_pop($value);
        return array_values($value);
    }

    public function hitungEuclidean(array $a, array $b){
        $euclidean = new Euclidean();
        return $euclidean->distance($a,$b);
    }
    
    public function bobotPerhitungan($data,$bobot){
        $bobotPerhitungan = [];
        $tempData = $this->normalisasiArray($data);
        foreach($bobot as $indexBobotAwal => $bobotAwalItem){ 
             $tempBobot = $this->normalisasiArray($bobotAwalItem);
             $tempTotal = $this->hitungEuclidean($tempData,$tempBobot);
             array_push($bobotPerhitungan,[
                'key'   => $bobotAwalItem['key'],
                'total' => $tempTotal,
                'index' => $indexBobotAwal,
                'target'=> $bobotAwalItem['target']
            ]);
        }
        return collect($bobotPerhitungan);
    }

    public function cekWindow($dc, $dr, $window){
       $cek = (min($dc/$dr,$dr/$dc) > (1-$window)*(1+$window)) ? true : false;
       return $cek;
    }
}

?>