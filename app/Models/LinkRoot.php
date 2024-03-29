<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LinkRoot extends Model
{
    use HasFactory;

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }
}
