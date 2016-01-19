<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
        DB::table('roles')->delete();

        $initial_data = $this->data();

        foreach ($initial_data as $role) {
            DB::table('roles')->insert($role);
        }
    }

    /**
     * Roles data.
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function data()
    {
        return [
            [
                'slug'        => 'root',
                'name'        => 'Root',
                'permissions' => $this->permission('root'),
                'created_at'  => '2014-10-21 22:56:12',
                'updated_at'  => '2014-11-04 15:10:19',
            ],
            [
                'slug'        => 'administrator',
                'name'        => 'Administrator',
                'permissions' => $this->permission('admin'),
                'created_at'  => '2014-10-21 22:56:12',
                'updated_at'  => '2014-10-31 02:05:22',
            ],
        ];
    }

    private function permission($role)
    {
        $arr = [];

        $root_permission = $arr = array_merge(
            $this->set('dashboard', ['view'])
        );

        switch ($role) {
            case 'root':
                $arr = $root_permission;
                break;
            case 'admin':
                $arr = $root_permission;
                break;
            case 'ess':
                $arr = array_merge(
                    $this->set('dashboard', ['view'])
                );
                break;
        }

        return json_encode($arr);
    }

    public function set($label, $only = [])
    {
        $permit = ['create', 'update', 'view', 'delete'];

        // If $only array is empty return all permission
        if (!count($only)) {
            $only = $permit;
        }

        $arr = [];

        foreach ($only as $action) {
            if (in_array($action, $permit)) {
                $arr[$label.'.'.$action] = true;
            }
        }

        return $arr;
    }
}
