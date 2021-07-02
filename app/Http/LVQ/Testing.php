<?php 

namespace App\Http\LVQ;
use App\Http\LVQ\Helper;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;
use Phpml\Metric\ClassificationReport;


class Testing{

    private $data;
    private $bobot;
    private $actualLabels = [];
    private $predictLabels = [];

    function __construct($data,$bobot)
    {
        $this->data = $data;
        $this->bobot = $bobot;
        $this->kalkulasi();
    }

    public function kalkulasi(){
        foreach($this->data as $value){
            $perhitungan = new Helper();
            $result = $perhitungan->bobotPerhitungan($value, $this->bobot);
            $minimumData = $result->where('total',$result->min('total'))->first();
            array_push($this->actualLabels,$value['target']);
            array_push($this->predictLabels,$minimumData['target']);
        }
    }
    public function getLabels(){
        return [
            $this->actualLabels,
            $this->predictLabels
        ];
    }
    public function accuracy(){
        return 100*Accuracy::score($this->actualLabels,$this->predictLabels);
    }
    public function confusionMatrix(){
        return ConfusionMatrix::compute($this->actualLabels,$this->predictLabels);
    }
    public function classficationReport(){
        $report = new ClassificationReport($this->actualLabels, $this->predictLabels);
        $precission = $report->getPrecision();
        $recall = $report->getRecall();
        $f1Score = $report->getF1score();
        $support = $report->getSupport();
        return [
            'precission' => $precission,
            'recall'     => $recall,
            'f1Score'    => $f1Score,
            'support'    => $support
        ];
    }
}

?>