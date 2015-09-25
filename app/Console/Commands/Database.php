<?php

namespace CodeProject\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a database based on environment variables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = env('DB_DATABASE');
        $user     = env('DB_USERNAME');
        $pass     = env('DB_PASSWORD');
        $host     = env('DB_HOST');
        $driver   = Config::get('database.default');

        switch ($driver) {
            case 'mysql':
            case 'pgsql':
                $dsn = "{$driver}:host={$host};";
                break;

            case 'sqlsrv':
                $dsn = "{$driver}:Server={$host};";
                break;

            case 'sqlite':
                if (file_exists(storage_path('database.sqlite'))) {
                    unlink(storage_path('database.sqlite'));
                }
                $handle = fopen(storage_path('database.sqlite'), 'w');
                fclose($handle);
                $this->info("SQLite Database created succefuly");
                break;
            
            default:
                $this->error("Invalid Database Driver: {$driver}");
                $driver = 'sqlite';
                break;
        }

        if ($driver !== 'sqlite') {
            try {
                $conn = new \PDO($dsn, $user, $pass, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]);
                $conn->exec('DROP DATABASE IF EXISTS ' . $database);
                $conn->exec('CREATE DATABASE ' . $database);
                $this->info("Database {$driver}:{$database} created succefuly");
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
