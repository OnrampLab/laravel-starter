<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Auth\Entities\User;

class Account extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The users that belong to the account.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'account_user')->withTimestamps();
    }
}
