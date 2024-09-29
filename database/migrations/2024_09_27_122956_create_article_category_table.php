<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(ArticleCategory::TABLE, function (Blueprint $table) {
            $table->uuid(ArticleCategory::ARTICLE_ID);
            $table->unsignedBigInteger(ArticleCategory::CATEGORY_ID);

            $table->unique(
                [
                    ArticleCategory::ARTICLE_ID,
                    ArticleCategory::CATEGORY_ID
                ]
            );

            $table->foreign(ArticleCategory::ARTICLE_ID)
                ->references(Article::ID)
                ->on(Article::TABLE)
                ->cascadeOnDelete();

            $table->foreign(ArticleCategory::CATEGORY_ID)
                ->references(Category::ID)
                ->on(Category::TABLE)
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\App\Models\ArticleCategory::TABLE);
    }
};
