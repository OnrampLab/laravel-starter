<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Auth\Services\CreateUserService;
use Modules\Auth\Services\ListUserService;
use Modules\Auth\Services\GetUserService;
use Modules\Auth\Services\UpdateUserService;
use Modules\Auth\Services\DeleteUserService;
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

     /**
     * @var GetUserService
     */
    protected $getUserService;

    /**
     * @var UpdateUserService
     */
    protected $updateUserService;

    /**
     * @var DeleteUserService
     */
    protected $deleteUserService;

    public function __construct(
        CreateUserService $createUserService,
        ListUserService $listUserService,
        GetUserService $getUserService,
        UpdateUserService $updateUserService,
        DeleteUserService $deleteUserService
    ){
        $this->createUserService = $createUserService;
        $this->listUserService = $listUserService;
        $this->getUserService = $getUserService;
        $this->updateUserService = $updateUserService;
        $this->deleteUserService = $deleteUserService;
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
     * @param int $userId
     * @return Response
     */
    public function show(int $userId)
    {
        $user = $this->getUserService->perform($userId);

        return new UserResource($user);
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
     * @param int $userId
     * @return Response
     */
    public function update(Request $request, int $userId)
    {
        $payload = $request->input();
        $user = $this->updateUserService->perform($payload, $userId);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $userId
     * @return Response
     */
    public function destroy(int $userId)
    {
        $this->deleteUserService->perform($userId);

        return response(null, 204);
    }
}
