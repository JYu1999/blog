<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Table
     */
    const TABLE = 'categories';

    protected $table = self::TABLE;

    public $timestamps = false;

    /**
     * Columns
     */
    const ID = 'id';
    const NAME = 'name';

    /**
     * Relations
     */
    public function articles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Article::class,
            ArticleCategory::TABLE,
            ArticleCategory::CATEGORY_ID,
            ArticleCategory::ARTICLE_ID,
        );
    }
}
