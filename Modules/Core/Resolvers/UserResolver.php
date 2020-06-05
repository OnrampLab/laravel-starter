<?php
namespace Modules\Core\Resolvers;

use App\User;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        return auth()->user();
    }
}
