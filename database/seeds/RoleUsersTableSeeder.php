<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
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
        DB::table('role_users')->delete();

        DB::table('role_users')->insert(
            [
                ['user_id' => 1, 'role_id' => 1],
            ]
        );
    }
}
