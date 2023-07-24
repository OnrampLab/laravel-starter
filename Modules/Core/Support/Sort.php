<?php

namespace Modules\Core\Support;

use Modules\Core\Contracts\Sort as BaseSort;
use Modules\Core\Contracts\SortDirection;

class Sort implements BaseSort
{
    public function __construct(
        private readonly string $field,
        private readonly SortDirection $direction,
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getDirection(): SortDirection
    {
        return $this->direction;
    }
}
