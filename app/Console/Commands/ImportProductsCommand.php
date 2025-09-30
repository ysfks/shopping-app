<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Domains\Product\Jobs\ImportProductsJob;

class ImportProductsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'products:import';
    protected $description = 'Import products from Fake Store API';

    public function handle(): void
    {
        $this->dispatchSync(new ImportProductsJob);

        $this->info('Product import job dispatched.');
    }
}
