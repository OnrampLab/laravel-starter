<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Account\Database\Factories\AccountApiKeyFactory;

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
