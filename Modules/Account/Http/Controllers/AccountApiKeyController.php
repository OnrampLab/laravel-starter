<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Http\Resources\AccountApiKeyResource;
use Modules\Account\Repositories\AccountApiKeyRepository;

class AccountApiKeyController extends Controller
{
    /**
     * @var AccountApiKeyRepository
     */
    protected $accountApiKeyRepository;

    public function __construct(AccountApiKeyRepository $accountApiKeyRepository)
    {
        $this->accountApiKeyRepository = $accountApiKeyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $accountId): Response
    {
        $apiKeys = $this->accountApiKeyRepository->search([
            'account_id' => $accountId,
        ]);

        return response([
            'data' => $apiKeys,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $accountId): JsonResource
    {
        $accountApiKey = $this->accountApiKeyRepository->createApiKey($accountId);

        return new AccountApiKeyResource($accountApiKey);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $accountId, int $id): Response
    {
        $this->accountApiKeyRepository->delete($id);

        return response(null, 204);
    }
}
