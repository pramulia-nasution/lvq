<?php

namespace App\Imports;

use App\Models\Dataset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dataset([
            'x1' => $row['x1'],
            'x2' => $row['x2'],
            'x3' => $row['x3'],
            'x4' => $row['x4'],
            'x5' => $row['x5'],
            'x6' => $row['x6'],
            'x7' => $row['x7'],
            'x8' => $row['x8'],
            'x9' => $row['x9'],
            'x10' => $row['x10'],
            'x11' => $row['x11'],
            'x12' => $row['x12'],
            'x13' => $row['x13'],
            'x14' => $row['x14'],
            'x15' => $row['x15'],
            'x16' => $row['x16'],
            'x17' => $row['x17'],
            'x18' => $row['x18'],
            'x19' => $row['x19'],
            'x20' => $row['x20'],
            'x21' => $row['x21'],
            'x22' => $row['x22'],
            'x23' => $row['x23'],
            'x24' => $row['x24'],
            'x25' => $row['x25'],
            'x26' => $row['x26'],
            'x27' => $row['x27'],
            'x28' => $row['x28'],
            'x29' => $row['x29'],
            'x30' => $row['x30'],
            'x31' => $row['x31'],
            'x32' => $row['x32'],
            'x33' => $row['x33'],
            'x34' => $row['x34'],
            'target' => $row['target'],
        ]);
    }
}
