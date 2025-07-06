<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupProject extends Command
{
    protected $signature = 'buildup';

    protected $description = 'Run migrations, initializing seeders to set up the database';

    public function handle()
    {
        $this->info('Generating app key...');
        $this->call('key:generate');

        $this->info('Resetting migrations...');
        $this->call('migrate:reset');

        $this->info('Running migrations...');
        $this->call('migrate');

        $this->info('Seeding database...');
        $this->call('db:seed', ['--class' => 'CustomerSeeder']);

        $this->info('---Setup complete! Run "php artisan serve" to start the server---');

        return 0;
    }
}
