<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'email'              => $this->email,
            'suspended_at'       => $this->suspended_at,
            'email_verified_at'  => $this->email_verified_at,
            'roles'              => $this->getRoleNames(),
            'permissions'        => $this->getAllPermissions()->pluck('name'),
        ];
    }
}
