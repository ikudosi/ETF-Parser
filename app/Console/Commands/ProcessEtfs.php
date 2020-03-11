<?php

namespace App\Console\Commands;

use App\Repositories\SSGA;
use App\Services\ETFParser;
use Illuminate\Console\Command;

class ProcessEtfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:etfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse ETFs';

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
        (new ETFParser())->handle(new SSGA);
    }
}
