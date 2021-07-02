<?php 
namespace App\Http\LVQ;
class collectData{

    private $dataTrain;
    private $data = [];
    private $kelas = [];
    private $bobotAwal = [];
    private $keyDelete = [];
    private $dataFinal = [];

    function __construct($dataTrain){
        $this->dataTrain = $dataTrain;
        $this->setData(); 
        $this->setBobotAwal();
        $this->setDataFinal();
    }

    private function setData(){
        foreach($this->dataTrain as $key => $item){
            $this->data[] = [
                'key' => $item->id,
                'x1'  => $item->x1,  'x2'  => $item->x2,  'x3'  => $item->x3,  'x4'  => $item->x4, 
                'x5'  => $item->x5,  'x6'  => $item->x6,  'x7'  => $item->x7,  'x8'  => $item->x8, 
                'x9'  => $item->x9,  'x10' => $item->x10, 'x11' => $item->x11, 'x12' => $item->x12, 
                'x13' => $item->x13, 'x14' => $item->x14, 'x15' => $item->x15, 'x16' => $item->x16, 
                'x17' => $item->x17, 'x18' => $item->x18, 'x19' => $item->x19, 'x20' => $item->x20, 
                'x21' => $item->x21, 'x22' => $item->x22, 'x23' => $item->x23, 'x24' => $item->x24, 
                'x25' => $item->x25, 'x26' => $item->x26, 'x27' => $item->x27, 'x28' => $item->x28, 
                'x29' => $item->x29, 'x30' => $item->x30, 'x31' => $item->x31, 'x32' => $item->x32, 
                'x33' => $item->x33, 'x34' => $item->x34,
                'target'    => $item->target  
            ];

            if(!in_array($item->target,$this->kelas)){
                array_push($this->kelas,$item->target);
            }
        }
    }

    public function getData(){
        return collect($this->data);
    }

    public function getKelas(){
        return collect($this->kelas);
    }

    private function setBobotAwal(){
        foreach($this->getKelas() as $value){
            $target = $this->getData()->where('target',$value)->first();
            array_push($this->bobotAwal,$target);
            array_push($this->keyDelete,$target['key']);
        }
    }

    public function getBobotAwal(){
        return collect($this->bobotAwal);
    }

    private function setDataFinal(){
        $this->dataFinal = $this->getData()->whereNotIn(('key'),$this->keyDelete);
    }

    public function getDataFinal(){
        return collect($this->dataFinal);
    }

    
}

