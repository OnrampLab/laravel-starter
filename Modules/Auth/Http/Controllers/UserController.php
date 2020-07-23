<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Auth\Services\CreateUserService;
use Modules\Auth\Services\ListUserService;
use Modules\Auth\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * @var CreateUserService
     */
    protected $createUserService;

    /**
     * @var ListUserService
     */
    protected $listUserService;

    public function __construct(
        CreateUserService $createUserService,
        ListUserService $listUserService
    ){
        $this->createUserService = $createUserService;
        $this->listUserService = $listUserService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = $this->listUserService->perform();

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('auth::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $payload = $request->input();
        $user = $this->createUserService->perform($payload);

        return new UserResource($user);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('auth::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('auth::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
