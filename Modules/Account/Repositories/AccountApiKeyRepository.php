<?php

namespace Modules\Account\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Encryption\Encrypter;
use Prettus\Repository\Eloquent\BaseRepository;

use Modules\Account\Entities\AccountApiKey;

class AccountApiKeyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return AccountApiKey::class;
    }

    public function createApiKey($accountId)
    {
        $token = base64_encode(Encrypter::generateKey(config('app.cipher')));

        return $this->create([
            'account_id' => $accountId,
            'token' => $token,
        ]);
    }

    public function findByToken($token)
    {
        return $this->findByField('token', $token)->first();
    }
}
