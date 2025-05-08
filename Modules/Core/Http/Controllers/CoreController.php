<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoreController extends Controller
{
    public function index(Request $request): Response
    {
        return response('', 204);
    }
}
