<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return view('core::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('core::create');
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): Response
    {
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        return view('core::edit');
    }
}
