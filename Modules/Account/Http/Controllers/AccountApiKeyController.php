<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
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
        $apiKeys = $this->accountApiKeyRepository->findWhere([
            'account_id' => $accountId,
        ]);

        return [
            'data' => $apiKeys,
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('account::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $accountId): Response
    {
        $accountApiKey = $this->accountApiKeyRepository->createApiKey($accountId);

        return new AccountApiKeyResource($accountApiKey);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): Response
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        return view('account::edit');
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
