<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\RegisterUserJob;

class RegisterUserController extends Controller
{
    public function __invoke()
    {
        $result = $this->dispatchSync(new RegisterUserJob);
        return response()->json($result, 201);
    }
}
