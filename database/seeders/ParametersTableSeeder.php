<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parameters')->insert(array(
            0 => array(
                'alpha'     => '0.05',
                'decAlpha'  => '0.1',
                'minAlpha'  => '0.0001',
                'maxEpoch'  => '10',
                'window'    => '',
                'type'      =>'1'
        ),
            1 => array(
                'alpha'     => '0.05',
                'decAlpha'  => '0.1',
                'minAlpha'  => '0.0001',
                'maxEpoch'  => '10',
                'window'    => '0.2',
                'type'      =>'2'
        ),
            2 => array(
                'alpha'     => '0.05',
                'decAlpha'  => '0.1',
                'minAlpha'  => '0.0001',
                'maxEpoch'  => '10',
                'window'    => '0.2',
                'type'      =>'3'
        ))
        );
    }
}
