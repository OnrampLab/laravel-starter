<?php

namespace Modules\Account\Http\Middleware;

use Closure;
use Modules\Account\Repositories\AccountApiKeyRepository;

class CheckAccountApiKey
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
     * Handle an incoming request.
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next): mixed
    {
        $header = $request->header('Authorization');
        $error = 'API Token is invalied.';

        if (! $header) {
            abort(401, $error);
        }

        $token = str_replace('Bearer ', '', $header);
        $apiKey = $this->accountApiKeyRepository->findByToken($token);

        if ($apiKey) {
            $request->route()->setParameter('accountId', $apiKey->account_id);
        } else {
            abort(401, $error);
        }

        return $next($request);
    }
}
