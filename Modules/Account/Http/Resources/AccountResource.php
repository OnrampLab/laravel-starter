<?php

namespace Modules\Account\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'redirect_domain' => $this->redirect_domain,
            'logo' => $this->logo,
            'email_validation_enabled' => $this->email_validation_enabled,
            'signature' => $this->signature,
            'address' => $this->address,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
