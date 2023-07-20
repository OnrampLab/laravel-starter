<?php

namespace Modules\Core\Contracts;

interface Sort
{
    public function getField(): string;

    public function getDirection(): SortDirection;
}
