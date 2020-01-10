<?php

use Illuminate\Database\Seeder;
use App\Models\User\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'gumtrip',
            'mobile'=>'13809811545',
            'password'=>bcrypt('123456'),
        ]);
    }
}
