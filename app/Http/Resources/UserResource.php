<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'blocked' => $this->blocked,
            'photo_url' => $this->photo_url,
            'name' => $this->name,
            'username' => $this->username,
            'type' => $this->type,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'shift_active' => $this->shift_active,
            'last_shift_end' => $this->last_shift_end,
            'last_shift_start' => $this->last_shift_start,
        ];
    }
}
