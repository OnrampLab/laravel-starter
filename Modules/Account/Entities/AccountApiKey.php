<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @method static \Modules\Account\Database\Factories\AccountApiKeyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountApiKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccountApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'token',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected static function newFactory()
    {
        return AccountApiKeyFactory::new();
    }
}
