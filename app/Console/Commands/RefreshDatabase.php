<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo 'Refreshing database... ';
        try {
            // Drop tables or database
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Drop all tables
            $tables = DB::select('SHOW TABLES');
            $dbName = env('DB_DATABASE');

            foreach ($tables as $table) {
                $tableName = $table->{'Tables_in_' . $dbName};
                DB::statement("DROP TABLE IF EXISTS `$tableName`;");
            }

            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Run migrations
            Artisan::call('migrate');
            echo Artisan::output() . "";

            // Seed database
            Artisan::call('db:seed');
            echo Artisan::output() . "";

            echo 'Database refreshed successfully. ';
            logger('Database successfully refreshed!');
        } catch (\Exception $e) {
            echo 'Failed to refresh database: ' . $e->getMessage();
            logger()->error('Failed to refresh database: ' . $e->getMessage());
        }
    }
}
