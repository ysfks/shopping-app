<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Product;

class ImportProductsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_products_command_dispatches_job_and_imports_products()
    {
        // Run the command
        Artisan::call('products:import');

        // Assert products are imported (Fake Store API returns 20 products)
        $this->assertDatabaseCount(Product::class, 20);
    }
}

