<?php

namespace Modules\Account\Repositories;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\App;
use Modules\Account\Entities\AccountApiKey;
use Modules\Core\Repositories\BaseRepository;

/**
 * @extends BaseRepository<AccountApiKey>
 */
class AccountApiKeyRepository extends BaseRepository
{
    public function createApiKey(int $accountId): AccountApiKey
    {
        $token = base64_encode(Encrypter::generateKey(config('app.cipher')));

        $entity = new AccountApiKey([
            'account_id' => $accountId,
            'token' => $token,
        ]);

        return $this->save($entity);
    }

    public function findByToken(string $token): AccountApiKey|null
    {
        $model = App::make($this->model());

        return $model->where('token', $token)->first();
    }

    protected function model()
    {
        return new AccountApiKey();
    }
}
