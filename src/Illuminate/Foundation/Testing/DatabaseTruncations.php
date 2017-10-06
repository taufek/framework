<?php

namespace Illuminate\Foundation\Testing;

use Illuminate\Support\Facades\DB;

trait DatabaseTruncations
{
    /**
     * Truncates all tables except for `migrations` table.
     *
     * @return void
     */
    protected function truncateTables()
    {
        Schema::disableForeignKeyConstraints();

        $tableNames = collect(array_map('reset', DB::select('SHOW TABLES')))
            ->reject(function ($table) {
                return $table == 'migrations';
            })
            ->each(function ($table) {
                DB::table($table)->truncate();
            });

        Schema::enableForeignKeyConstraints();
    }
}
