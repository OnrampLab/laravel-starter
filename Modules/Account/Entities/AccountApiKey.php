<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountApiKey extends Model
{
    protected $fillable = [
        'account_id',
        'token',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
