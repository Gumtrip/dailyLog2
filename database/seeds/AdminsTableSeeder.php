<?php

use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'gumtrip',
            'mobile'=>'13809811545',
            'password'=>bcrypt('123456'),
        ]);
        Admin::create([
            'name'=>'milly',
            'mobile'=>'13889943867',
            'password'=>bcrypt('123456'),
        ]);
    }
}
