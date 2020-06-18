<?php

use Illuminate\Database\Seeder;
use App\admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        admin::create([
            'name'=>"admin",
            'email'=>"admin@admin.com",
            "password"=>Hash::make(123456789),
        ]);
    }
}
