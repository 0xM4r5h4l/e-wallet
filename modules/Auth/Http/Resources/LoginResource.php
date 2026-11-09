<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['user']->uuid,
            'name' => $this->resource['user']->name,
            'email' => $this->resource['user']->email,
            'email_verified' => $this->resource['user']->email_verified_at !== null,
            'mobile_number_verified' => $this->resource['user']->mobile_number_verified_at !== null,
            'joined_at' => $this->resource['user']->created_at->toIso8601String(),
            'token' => $this->resource['token'],
        ];
    }
}
