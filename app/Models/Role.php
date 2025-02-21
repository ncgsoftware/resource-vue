<?php

namespace App\Models;

    use Database\Factories\RoleFactory;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * @method static where(string[] $array)
     */
    class Role extends Model
    {
        /** @use HasFactory<RoleFactory> */
        use HasFactory;

        public function users(): HasMany
        {
            return $this->hasMany(User::class);
        }
    }
