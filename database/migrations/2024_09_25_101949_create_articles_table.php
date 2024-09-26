<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Article::TABLE, function (Blueprint $table) {
            $table->uuid(Article::ID);
            $table->string(Article::TITLE);
            $table->text(Article::CONTENT);
            $table->boolean(Article::IS_PUBLISHED)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Article::TABLE);
    }
};
