<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Events\AccountCreatedEvent;
use Modules\Account\Http\Resources\AccountResource;
use Modules\Account\Repositories\AccountRepository;

class AccountController extends Controller
{
    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $accounts = $this->accountRepository->all();

        return AccountResource::collection($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResource
    {
        $payload = $request->input();
        $account = $this->accountRepository->create($payload);
        event(new AccountCreatedEvent($account));

        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResource
    {
        $payload = $request->input();
        $account = $this->accountRepository->update($payload, $id);

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        $this->accountRepository->delete($id);

        return response(null, 204);
    }
}
