<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //path to sql file
        define('SETTING_SQL','database/setting_dev.sql');
        $sql = base_path(SETTING_SQL);

        //collect contents and pass to DB::unprepared
//        DB::unprepared(file_get_contents($sql));
        $sql_dump = File::get(SETTING_SQL);
        $pdo = DB::connection()->getPdo()->exec($sql_dump);

//        echo($pdo->table('users')->all());
    }
}
