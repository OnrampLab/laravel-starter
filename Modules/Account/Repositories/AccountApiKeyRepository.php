<?php

namespace Modules\Account\Repositories;

use Illuminate\Encryption\Encrypter;
use Modules\Account\Entities\AccountApiKey;
use Prettus\Repository\Eloquent\BaseRepository;

class AccountApiKeyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return AccountApiKey::class;
    }

    public function createApiKey(int $accountId): AccountApiKey
    {
        $token = base64_encode(Encrypter::generateKey(config('app.cipher')));

        return $this->create([
            'account_id' => $accountId,
            'token' => $token,
        ]);
    }

    public function findByToken(string $token): AccountApiKey|null
    {
        return $this->findByField('token', $token)->first();
    }
}
