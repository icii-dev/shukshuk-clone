<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;
use App\Model\User;

class UsersTableSeederCustom extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();
        User::create([
            'name'           => 'Admin',
            'email'          => 'admin@shukshuk.com',
            'password'       => bcrypt('123123'),
            'remember_token' => str_random(60),
            'role_id'        => $role->id,
        ]);

        $role = Role::where('name', 'adminweb')->firstOrFail();
        $user = User::where('email', 'adminweb@adminweb.com')->first();
        if(!$user){
            User::create([
                'name'           => 'Admin Web',
                'email'          => 'adminweb@adminweb.com',
                'password'       => bcrypt('ShukPq0#'),
                'remember_token' => str_random(60),
                'role_id'        => $role->id,
            ]);
        }


        $role = Role::where('name', 'seller')->firstOrFail();
        $user = User::where('email', 'seller@shukshuk.com')->first();
        if(!$user){
            User::create([
                'name'           => 'Seller Root',
                'email'          => 'seller@shukshuk.com',
                'password'       => bcrypt('123123'),
                'remember_token' => str_random(60),
                'role_id'        => $role->id,
            ]);
        }

    }
}
