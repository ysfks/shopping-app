<?php
namespace App\Http\Controllers\Product;

use App\Domains\Product\Jobs\ImportProductsJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->dispatchSync(new ImportProductsJob);

        return response()->json(['message' => 'Product import job dispatched.'], 202);
    }
}

