<?php

use Illuminate\Database\Seeder;

class setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Setting([
            'sitename_ar'=>'arabic',
            'sitename_en'=>'english'
        ]);
    }
}
