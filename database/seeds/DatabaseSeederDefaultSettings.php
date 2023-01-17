<?php

use Illuminate\Database\Seeder;

class DatabaseSeederDefaultSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(DataTypesTableSeederCustom::class);
        $this->call(DataRowsTableSeeder::class);
        $this->call(DataRowsTableSeederCustom::class);

        // menu
        $this->call(MenusTableSeederCustom::class);
        $this->call(MenuItemsTableSeederCustom::class);

        // roles
        $this->call(RolesTableSeederCustom::class);
        $this->call(PermissionsTableSeederCustom::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(PermissionRoleTableSeederCustom::class);
        $this->call(UsersTableSeederCustom::class);
        $this->call(SettingsTableSeederCustom::class);


    }
}
