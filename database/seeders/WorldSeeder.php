<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql_file = public_path('world.sql');
        $sql_statements = file_get_contents($sql_file);

        // قم بتقسيم SQL بناءً على الجمل المنتهية بفاصلة منقوطة
        $queries = explode(';', $sql_statements);

        foreach ($queries as $query) {
            if (trim($query) != '') {
                DB::unprepared($query . ';');
            }
        }
    }
}
