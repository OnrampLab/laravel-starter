<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Http\Resources\AccountResource;
use Modules\Account\Repositories\AccountRepository;
use Modules\Account\Events\AccountCreatedEvent;

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
     * @return Response
     */
    public function index()
    {
        $accounts = $this->accountRepository->all();

        return AccountResource::collection($accounts);
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
    public function store(Request $request)
    {
        $payload = $request->input();
        $account = $this->accountRepository->create($payload);
        event(new AccountCreatedEvent($account));

        return new AccountResource($account);
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
     * Update the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $payload = $request->input();
        $account = $this->accountRepository->update($payload, $id);

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->accountRepository->delete($id);

        return response(null, 204);
    }
}
