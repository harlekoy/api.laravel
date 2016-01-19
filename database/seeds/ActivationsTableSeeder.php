<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Illuminate\Database\Seeder;

class ActivationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function run()
    {
        DB::table('activations')->delete();

        DB::table('activations')->insert(
            [
                [
                    'id'           => 1,
                    'user_id'      => 1,
                    'code'         => 'E33Q3NTPjnZgvgjLRmzcRzuAVcY17tTo',
                    'completed'    => 1,
                    'completed_at' => '2014-10-21 22:56:12',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-11-04 15:10:19',
                ],
            ]
        );
    }
}
