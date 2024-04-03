<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        \Storage::deleteDirectory( 'images/products');
        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

    }
}
