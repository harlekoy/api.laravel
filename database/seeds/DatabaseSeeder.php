<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     * @author Donna Borja <donna@idearobin.com>
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(ActivationsTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(UserInformationTableSeeder::class);

        Model::reguard();
    }
}
