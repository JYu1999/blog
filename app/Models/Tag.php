<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Table
     */
    const TABLE = 'tags';

    protected $table = self::TABLE;

    /**
     * Columns
     */
    const ID = 'id';

    const NAME = 'name';

    /**
     * Relations
     */

    public function articles(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function tweets(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Tweet::class, 'taggable');
    }
}
