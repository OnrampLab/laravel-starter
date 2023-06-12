<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\Services\CreateUserService;
use Modules\Auth\Services\DeleteUserService;
use Modules\Auth\Services\GetUserService;
use Modules\Auth\Services\ListUserService;
use Modules\Auth\Services\UpdateUserService;

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
        DeleteUserService $deleteUserService,
    ) {
        $this->createUserService = $createUserService;
        $this->listUserService = $listUserService;
        $this->getUserService = $getUserService;
        $this->updateUserService = $updateUserService;
        $this->deleteUserService = $deleteUserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $users = $this->listUserService->perform();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResource
    {
        $payload = $request->input();
        $user = $this->createUserService->perform($payload);

        return new UserResource($user);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $userId): JsonResource
    {
        $user = $this->getUserService->perform($userId);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId): JsonResource
    {
        $payload = $request->input();
        $user = $this->updateUserService->perform($payload, $userId);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId): Response
    {
        $this->deleteUserService->perform($userId);

        return response(null, 204);
    }
}
