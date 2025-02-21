<?php

namespace App\Http\Resources;

use App\Models\Role;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $profile_photo_url
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $email_verified_at
 * @property Role $role
 */
class UserAdministrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'role_name' => $this->role->name,
            'can' => [
                'delete' => $request->user()?->can('delete', $this->resource),
                'changerole' => $request->user()?->can('changerole', $this->resource),
                // 'timeout' => $request->user()?->can('timeout', $this->resource),
                'disable' => $request->user()?->can('disable', $this->resource),
            ],
        ];
    }
}
