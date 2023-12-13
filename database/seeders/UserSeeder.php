<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'statisticsViewer']);
        $user = DB::table('users')->insert([
            'name' => "admin",
            'email' => "admin" . '@hrfactoryapp.com',
            'password' => Hash::make('password'),
            'user_type' => 'superadmin',

        ]);
        //assign role to $user
        $user = User::where('email', 'admin@hrfactoryapp.com')->first();
        $user->assignRole('admin');
        $user = DB::table('users')->insert([
            'name' => "alzubair",
            'email' => "alzubair" . '@hrfactoryapp.com',
            'password' => Hash::make('password'),
            'user_type' => 'alzubair',

        ]);
        //assign role to $user
        $user = User::where('email', 'alzubair@hrfactoryapp.com')->first();
        $user->assignRole('statisticsViewer');
        //
    }
}
