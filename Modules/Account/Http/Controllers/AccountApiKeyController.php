<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Account\Repositories\AccountApiKeyRepository;
use Modules\Account\Http\Resources\AccountApiKeyResource;

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
     * @return Response
     */
    public function index(int $accountId)
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
     * @return Response
     */
    public function create()
    {
        return view('account::create');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store(Request $request, int $accountId)
    {
        $accountApiKey = $this->accountApiKeyRepository->createApiKey($accountId);

        return new AccountApiKeyResource($accountApiKey);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('account::edit');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $accountId
     * @param int $id
     * @return Response
     */
    public function destroy($accountId, $id)
    {
        $this->accountApiKeyRepository->delete($id);

        return response(null, 204);
    }
}
