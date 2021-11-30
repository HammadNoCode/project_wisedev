<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $data = [];
        for($i=0; $i<20; $i++){

            $data[] = [
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
                'verified' => '1',
            ];

        }
        foreach($data as $ret){

            DB::table('users')->insert($ret);
        }
           }
}
