<?php

namespace App\Http\Controllers\User;

use App\Jobs\LoginUserJob;
use App\Http\Controllers\Controller;

class LoginUserController extends Controller
{
    public function __invoke()
    {
        $result = $this->dispatchSync(new LoginUserJob);
        return response()->json($result);
    }
}
