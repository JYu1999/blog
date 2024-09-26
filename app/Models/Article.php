<?php

namespace App\Models;

use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes, HasUuids, HasTags;

    /**
     * Table
     */
    const TABLE = 'articles';

    protected $table = self::TABLE;

    /**
     * Columns
     */
    const ID = 'id';

    /**
     * 文章標題
     */
    const TITLE = 'title';

    /**
     * 文章內文
     */
    const CONTENT = 'content';

    /**
     * 文章是否已發布
     */
    const IS_PUBLISHED = 'is_published';
    const DELETED_AT = 'deleted_at';
}
