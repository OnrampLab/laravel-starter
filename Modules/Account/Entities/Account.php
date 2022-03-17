<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Account\Database\Factories\AccountFactory;
use Modules\Auth\Entities\User;

class Account extends Model
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return AccountFactory::new();
    }
}
