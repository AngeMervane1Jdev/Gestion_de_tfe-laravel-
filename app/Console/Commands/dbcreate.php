<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MySQL database based on config file or the provided parameter';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schemaName = $this->argument('name') ?: config('database.connections.mysql.database');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_general_ci');

        config(['database.connections.mysql.database' => null]);

        $query = "DROP DATABASE IF EXISTS $schemaName;";
        DB::statement($query);

        $query = "CREATE DATABASE $schemaName CHARACTER SET $charset COLLATE $collation;";
        DB::statement($query);

        $this->info("Database $schemaName created successfully");

        config(['database.connections.mysql.database' => $schemaName]);
    }
}