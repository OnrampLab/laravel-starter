<?php

namespace Modules\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityResourceCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        /** @var array<string, mixed> $pagination */
        $pagination = $this->resource->toArray();

        return [
            'data' => $pagination['data'],
            'meta' => collect($pagination)->except('data'),
        ];
    }
}
