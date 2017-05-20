<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'theed',
                    'email' => 'admin@mail.com',
                    'password' => Hash::make('theed')
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'user',
                    'email' => 'user@mail.com',
                    'password' => Hash::make('user')
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'kareo',
                    'email' => 'kareo@wn.co.ke',
                    'password' => Hash::make('kareo')
                ),
        ));
    }
}
