<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Account\Database\Factories\AccountApiKeyFactory;

/**
 * Modules\Account\Entities\AccountApiKey
 *
 * @property int $id
 * @property int|null $account_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Account\Entities\Account|null $account
 * @method static \Modules\Account\Database\Factories\AccountApiKeyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey query()
 * @mixin \Eloquent
 */
class AccountApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'token',
    ];

    /**
     * The users that belong to the account.
     *
     * @return BelongsTo<Account, AccountApiKey>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return Factory<AccountApiKey>
     */
    protected static function newFactory(): Factory
    {
        return AccountApiKeyFactory::new();
    }
}
