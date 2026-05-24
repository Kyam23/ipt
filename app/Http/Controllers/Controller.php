<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use Dispatchable;
    use ValidatesRequests;
}
