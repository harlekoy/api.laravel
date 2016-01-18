<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Carbon\Carbon;
use IdeaRobin\Api\Eloquent\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        DB::table('users')->delete();

        $users = $this->users();

        foreach ($users as $user) {
            User::create($user);
        }
    }

    /**
     * Users data.
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function users()
    {
        return [
            [
                'email'        => 'bertrand@idearobin.com',
                'password'     => Hash::make('retardko'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'donna@idearobin.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'ir_donna_1@mailinator.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'ir_donna_2@mailinator.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'ir_donna_3@mailinator.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'ir_donna_4@mailinator.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'ir_donna_5@mailinator.com',
                'password'     => Hash::make('test'),
                'last_login'   => Carbon::now(),
            ],
        ];
    }
}
