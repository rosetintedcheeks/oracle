<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';

    public function links(): HasMany {
        return $this->HasMany(Link::class);
    }

    public function root(): HasOne {
        return $this->HasOne(LinkRoot::class);
    }
}
