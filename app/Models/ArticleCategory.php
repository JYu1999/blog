<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleCategory extends Pivot
{
    /**
     * Table
     */
    const TABLE = 'article_category';


    /**
     * Columns
     */
    const ARTICLE_ID = 'article_id';

    const CATEGORY_ID = 'category_id';



}
