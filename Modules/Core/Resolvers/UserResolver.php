<?php

namespace Modules\Core\Resolvers;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    public static function resolve()
    {
        return auth()->user();
    }
}
