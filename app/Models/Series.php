<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';

    public function links(): HasMany {
        return $this->HasMany(Link::class);
    }

    public function root(): BelongsTo {
        return $this->belongsTo(LinkRoot::class, 'link_root_id');
    }
}
